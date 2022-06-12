<?php

namespace App\Http\Controllers;

use App\TeacherSubject;
use App\User;
use App\Teacher;
use App\NoticeBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $teachers = Teacher::with('user', 'subjects')->latest()->paginate(10);
        return view('backend.teachers.index', compact('teachers'));
    }

    public function noticeBoard()
    {
        $notices = noticeBoard::all();
        // return $notice;
        return view('noticeBoard.index' , compact('notices'));
    }

    public function addNotice()
    {
        return view('noticeBoard.create');
    }

    public function destroyNotice($id)
    {
        // return $id;
        $notice = noticeBoard::find($id);
        $notice->delete();
        return redirect()->back();
    }


    public function saveNotice(Request $request)
    {
        // return $request;
        $notice = NoticeBoard::create([
            'description'=> $request['description'],
        ]);

        return redirect()->route('notice.board.index');
    }


    public function showNotice()
    {
        $notices = NoticeBoard::all();
        return view('NoticeBoard.show', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'gender' => 'required|string',
            'phone' => 'required|string|max:255',
            'dateofbirth' => 'required|date',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($user->name) . '-' . $user->id . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = 'avatar.png';
        }
        $user->update([
            'profile_picture' => $profile
        ]);

        $user->teacher()->create([
            'gender' => $request->gender,
            'phone' => $request->phone,
            'dateofbirth' => $request->dateofbirth,
            'current_address' => $request->current_address,
//            'subject_id' => $request->subject_id,
            'permanent_address' => $request->permanent_address
        ]);
        foreach ($request->subject_id as $subject) {
            TeacherSubject::create([
                'subject_id' => $subject,
                'teacher_id' => $user->id,
            ]);
        }

        $user->assignRole('Teacher');

        return redirect()->route('teacher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $teacher = Teacher::with('user', 'subjects')->findOrFail($teacher->id);

        return view('backend.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $teacher->user_id,
            'gender' => 'required|string',
            'phone' => 'required|string|max:255',
            'dateofbirth' => 'required|date',
            'current_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255'
        ]);

        $assign_teacher = TeacherSubject::where('teacher_id', $teacher->id)->delete();
        foreach ($request->subject_id as $subject) {
            TeacherSubject::create([
                'subject_id' => $subject,
                'teacher_id' => $teacher->user_id,
            ]);
        }

        $user = User::findOrFail($teacher->user_id);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug($user->name) . '-' . $user->id . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = $user->profile_picture;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile_picture' => $profile
        ]);

        $user->teacher()->update([
            'gender' => $request->gender,
            'phone' => $request->phone,
            'dateofbirth' => $request->dateofbirth,
//            'subject_id'       => $request->subject_id,
            'current_address' => $request->current_address,
            'permanent_address' => $request->permanent_address
        ]);

        return redirect()->route('teacher.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Teacher $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $user = User::findOrFail($teacher->user_id);

        $user->teacher()->delete();

        $user->removeRole('Teacher');

        if ($user->delete()) {
            if ($user->profile_picture != 'avatar.png') {
                $image_path = public_path() . '/images/profile/' . $user->profile_picture;
                if (is_file($image_path) && file_exists($image_path)) {
                    unlink($image_path);
                }
            }
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\ExamTimeTable;
use App\Grade;
use App\Room;
use App\Section;
use App\Services\TimeTableService;
use App\Subject;
use App\TimeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Mixed_;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $classes = Grade::latest()->get();
        return view('backend.time-table.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
//        Carbon::parse(Carbon::parse($request->start_time)->addMinutes($diff_in_hours/$request->total_lecture)->format('H:i'))->subMinutes($diff_in_hours/$request->total_lecture)->format('H:i'),
        $to = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $from = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        $diff_in_hours = $to->diffInMinutes($from);
        $classes = Grade::all();
        $sectionCount = Section::all()->count();
        $roomCount = Room::all()->count();

        if ($roomCount >= $sectionCount){
        foreach ($classes as $class) {
            TimeTable::whereGradeId($class->id)->delete();
            $assign_subject = DB::table('grade_subject')->where('grade_id', $class->id)->count();
            $oneLectureTime = $diff_in_hours / $assign_subject;
            foreach (TimeTableService::getSectionOfClass($class->id) as $sectionIndex => $section) {

                foreach (TimeTableService::DayArray() as $day) {

                    if ($day != "Saturday" || $day != "Sunday") {
                        for ($i = 0; $i < $assign_subject; $i++) {
                            $subject_id = TimeTableService::checkSubjectInTimeTable($class->id, $section->id, $day);
                            $start_time = Carbon::parse($request->start_time)->addMinutes($oneLectureTime * $i)->format('H:i');
                            $end_time = Carbon::parse($request->start_time)->addMinutes($oneLectureTime * $i + $oneLectureTime)->format('H:i');
                            $teacherSubject = TimeTableService::checkTeacherInTimeTable($class->id, $day, $start_time, $end_time, $subject_id, $section->id);
                            TimeTable::create([
                                'grade_id' => $class->id,
                                'section_id' => $section->id ?? null,
                                'room_id' => Room::all()[$sectionIndex]->name ?? null,
                                'subject_id' => $teacherSubject['subject_id'] ?? null,
                                'teacher_id' => $teacherSubject['teacher_id'] ?? null,
                                'day' => $day,
                                'class_start_time' => $start_time,
                                'class_end_time' => $end_time,
                            ]);
                        }
                    }
                }
            }
        }
    }

        return redirect(route('time-table.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TimeTable $timeTable
     * @return \Illuminate\Http\Response
     */
    public
    function show(TimeTable $timeTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\TimeTable $timeTable
     * @return \Illuminate\Http\Response
     */
    public
    function edit(TimeTable $timeTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\TimeTable $timeTable
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, TimeTable $timeTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TimeTable $timeTable
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(TimeTable $timeTable)
    {
        //
    }

    public function examTimeTable()
    {
        return view('backend.exam-time-table.index');
    }

    public function examTimeTableStore(Request $request)
    {
        $to = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $from = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        $diff_in_hours = $to->diffInMinutes($from);
        $classes = Grade::all();
        $sectionCount = Section::all()->count();
        $roomCount = Room::all()->count();

        if ($roomCount >= $sectionCount){
            foreach ($classes as $class) {
                ExamTimeTable::whereGradeId($class->id)->delete();
                $assign_subject = DB::table('grade_subject')->where('grade_id', $class->id)->count();
                $oneLectureTime = $diff_in_hours / $assign_subject;
                foreach (TimeTableService::getSectionOfClass($class->id) as $sectionIndex => $section) {

                    foreach (TimeTableService::DayArray() as $day) {

                        if ($day != "Saturday" || $day != "Sunday") {
                            for ($i = 0; $i < $assign_subject; $i++) {
                                $subject_id = TimeTableService::checkSubjectInTimeTable($class->id, $section->id, $day);
                                $start_time = Carbon::parse($request->start_time)->addMinutes($oneLectureTime * $i)->format('H:i');
                                $end_time = Carbon::parse($request->start_time)->addMinutes($oneLectureTime * $i + $oneLectureTime)->format('H:i');
                                $teacherSubject = TimeTableService::checkTeacherInTimeTable($class->id, $day, $start_time, $end_time, $subject_id, $section->id);
                                ExamTimeTable::create([
                                    'grade_id' => $class->id,
                                    'section_id' => $section->id ?? null,
                                    'room_id' => Room::all()[$sectionIndex]->name ?? null,
                                    'subject_id' => $teacherSubject['subject_id'] ?? null,
                                    'teacher_id' => $teacherSubject['teacher_id'] ?? null,
                                    'day' => $day,
                                    'class_start_time' => $start_time,
                                    'class_end_time' => $end_time,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect(route('exam.time.table'));
    }
}

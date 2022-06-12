<?php

namespace App\Services;

use App\ExamTimeTable;
use App\Room;
use App\Section;
use App\Subject;
use App\Teacher;
use App\TeacherSubject;
use App\TimeTable;
use Illuminate\Support\Facades\DB;

;

class TimeTableService
{
    public static function DayArray(): array
    {
        return [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
    }

    public static function allRoom($section_id = null)
    {
            return TimeTable::where('section_id',$section_id)->first()->room_id ?? null;
    }

    public static function checkSubjectInTimeTable($class_id, $section_id, $day)
    {
        $subjects = DB::table('grade_subject')->whereGradeId($class_id)->get();
        foreach ($subjects as $subject) {
            $data = TimeTable::whereGradeId($class_id)
                ->whereSectionId($section_id)
                ->whereSubjectId($subject->subject_id)
                ->where('day', $day)->count();
            if ($data == 0) {
                return $subject->subject_id;
            }
        }
        return false;

    }

    public static function checkTeacherInTimeTable($class_id, $day, $start_time, $end_time, $subject_id, $section_id)
    {

        $subjects = DB::table('grade_subject')->whereGradeId($class_id)->get();
        $subjectRand = $subjects[rand(0, $subjects->count() - 1)];
        $teachers = TeacherSubject::whereSubjectId($subjectRand->subject_id)->get();
        foreach ($teachers as $teacher) {
            $data = ExamTimeTable::where('day', $day)
                ->where('grade_id', $class_id)
//                ->where('section_id', $section_id)
                ->where('subject_id', $subjectRand->subject_id)
                ->where('teacher_id', $teacher->teacher_id)
                ->count();
            if ($data == 0) {
                return [
                    'teacher_id' => $teacher->teacher_id,
                    'subject_id' => $teacher->subject_id,
                ];
            }
        }
        return null;
    }

    public static function getSectionOfClass($class_id)
    {
        return Section::whereGradeId($class_id)->get();
    }

    public static function getClassOfSubject($class_id)
    {
        return DB::table('grade_subject')
            ->where('grade_id', $class_id)
            ->join('subjects', 'grade_subject.subject_id', '=', 'subjects.id')
            ->join('teachers', 'subjects.teacher_id', '=', 'teachers.id')
            ->join('grades', 'grade_subject.grade_id', '=', 'grades.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->select('subjects.id as subject_id',
                'subjects.name as subject_name',
                'grades.class_name as class_name',
                'grades.id as class_id',
                'teachers.id as teacher_id',
                'users.name as teacher_name'
            )->get();
    }

    public static function subjectDropdown()
    {
        return Subject::all();
    }

    public static function allSection()
    {
        return Section::all();
    }

    public static function getTimeTableSection($section_id)
    {
        return TimeTable::whereSectionId($section_id)->get();
    }

    public static function getTimeTableDayClass($section_id, $class_id, $day)
    {
        return TimeTable::with('teacher', 'subject')->whereSectionId($section_id)
            ->whereGradeId($class_id)
            ->where('day', $day)
            ->get();
    }

    public static function getExamTimeTableDayClass($section_id, $class_id, $day)
    {
        return ExamTimeTable::with('teacher', 'subject')->whereSectionId($section_id)
            ->whereGradeId($class_id)
            ->where('day', $day)
            ->get();
    }

    public static function checkRoomClass($class_id, $section_id, $day)
    {
        $rooms = Room::all();
        foreach ($rooms as $room) {
            $data = TimeTable::where([
                'grade_id' => $class_id,
                'room_id' => $room->id,
                'day' => $day
            ])->count();
            if ($data == 0) {
                return $room->id;
            }
        }
        return false;
    }
}

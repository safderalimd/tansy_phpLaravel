<?php

namespace App\Http\Modules\reports\School\Models;

use App\Http\Models\Model;
use App\Http\Models\Traits\OwnerOrganization;

class FinalProgress extends Model
{
    protected $screenId = '/cabinet/pdf---final-progress';

    protected $repositoryNamespace = 'App\Http\Modules\reports\School\Repositories\FinalProgressRepository';

    use OwnerOrganization;

    public $reportName = 'Final Progress Card';

    public $schoolName = '-';

    public $schoolWorkPhone = '-';

    public $students;

    public $exams;

    public $studentFullName;

    public $classStudentId;

    public $studentRollNumber;

    public $className;

    public $overallGrade;

    public $subjects;

    public $subjectsTotal;

    public $subjectsGrade;

    public $subjectsResult;

    public $attendance;

    public function setRtAttribute($value)
    {
        $this->setAttribute('filter_type', $value);
        return $value;
    }

    public function setEiAttribute($value)
    {
        $this->setAttribute('subject_entity_id', $value);
        return $value;
    }

    public function setStudentData($student)
    {
        $this->exams = $this->getExamListForStudent($student);
        $this->setStudentInfo($student);
        $this->subjects = $student->reject(function ($item, $key) {
                            return '1 detail' != $item['row_type'];
                        });

        $key = $student->search(function ($item, $key) {
            return '2 total' == $item['row_type'];
        });
        $this->subjectsTotal = $student[$key];

        $key = $student->search(function ($item, $key) {
            return '3 grade' == $item['row_type'];
        });
        $this->subjectsGrade = $student[$key];

        $key = $student->search(function ($item, $key) {
            return '4 result' == $item['row_type'];
        });
        $this->subjectsResult = $student[$key];

        if (isset($this->attendance[$this->classStudentId])) {
            $this->studentAttendance = $this->attendance[$this->classStudentId];
        } else {
            $this->studentAttendance = collect([]);
        }
    }

    public function workingDays($month)
    {
        $key = $this->studentAttendance->search(function ($item, $key) use ($month) {
            return $month == $item['calendar_month'];
        });

        if (!is_numeric($key)) {
            return '-';
        }

        if (isset($this->studentAttendance[$key]['working_days'])) {
            return $this->studentAttendance[$key]['working_days'];
        }

        return '-';
    }

    public function presentDays($month)
    {
        $key = $this->studentAttendance->search(function ($item, $key) use ($month) {
            return $month == $item['calendar_month'];
        });

        if (!is_numeric($key)) {
            return '-';
        }

        if (isset($this->studentAttendance[$key]['present_days'])) {
            return $this->studentAttendance[$key]['present_days'];
        }

        return '-';
    }

    public function loadPdfData()
    {
        $data = $this->repository->generateProgressFinal($this);

        $students = collect(first_resultset($data));
        $this->students = $students->groupBy('class_student_id');

        $attendance = collect(second_resultset($data));
        $this->attendance = $attendance->groupBy('class_student_id');

        $this->setOwnerOrganizationInfo();
    }

    public function setStudentInfo($student)
    {
        $firstRow = $student->first();
        $firstRow = collect($firstRow);

        $this->studentFullName = $firstRow->get('student_full_name');
        $this->studentRollNumber = $firstRow->get('student_roll_number');
        $this->className = $firstRow->get('class_name');
        $this->overallGrade = $firstRow->get('overall_grade');
        $this->classStudentId = $firstRow->get('class_student_id');
    }

    public function getExamListForStudent($student)
    {
        $firstRow = $student->first();
        $firstRow = collect($firstRow);

        return $firstRow->reject(function ($value, $key) {
                    return is_int($key);
                })->reject(function ($value, $key) {
                    $remove = [
                        'class_student_id',
                        'row_type',
                        'student_full_name',
                        'class_name',
                        'student_roll_number',
                        'subject_entity_id',
                        'subject',
                        'overall_subject_grade',
                        'overall_grade',
                    ];
                    return in_array($key, $remove);
                })->keys()->all();
    }
}

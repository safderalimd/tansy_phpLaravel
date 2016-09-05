<?php

namespace App\Http\FPDF\MarkSheet;

class Contents
{
    protected $markSheet;

    // general data for all pages below ..
    public $title = 'Mark Sheet';
    public $schoolName = 'Canadian International School';
    public $phoneNr = '0343243244';
    public $examName = 'Formative Assesesment - 1';

    public function __construct($markSheet)
    {
        // $this->markSheet = $markSheet;

        // $data = $markSheet->marksGrid();
        // $allItems = first_resultset($data);
        // $columns = second_resultset($data);

        // $examEntityId = $markSheet->exam_entity_id;
        // $classEntityId = $markSheet->class_entity_id;
        // $subjectEntityId = $markSheet->subject_entity_id;

        // $this->examName = isset($columns[0]['main_exam_name']) ? $columns[0]['main_exam_name'] : '-';
        // $className = isset($columns[0]['class_name']) ? $columns[0]['class_name'] : '-';
        // $subjectName = isset($columns[0]['subject_name']) ? $columns[0]['subject_name'] : '-';

        // $maxMarks = 0;
        // foreach ($columns as $column) {
        //     if (isset($column['average_reduced_marks']) && is_numeric($column['average_reduced_marks'])) {
        //         $maxMarks += $column['average_reduced_marks'];
        //     }
        // }
    }
}

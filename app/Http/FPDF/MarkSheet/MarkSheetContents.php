<?php

namespace App\Http\FPDF\MarkSheet;

class MarkSheetContents
{
    protected $export;

    public $title = 'MarkSheet';
    public $reportName = '';
    public $schoolName = '';
    public $headerSecondLine = '';
    public $headerThirdLine = '';
    public $website = '';

    public $examName = '';
    public $className = '';
    public $subjectName = '';

    public $columns;
    public $allItems;
 
    public function __construct($export)
    {
        $this->export = $export;

        $this->schoolName = $export->organizationName();
        $this->headerSecondLine = $export->organizationLine2();
        $this->headerThirdLine = $export->organizationLine3();
        $this->website = $export->organizationWebsite();
        $this->reportName = $export->reportName;

        $data = $export->marksGrid();
        $this->allItems = first_resultset($data);
        $columns = second_resultset($data);

        $examEntityId = $export->exam_entity_id;
        $classEntityId = $export->class_entity_id;
        $subjectEntityId = $export->subject_entity_id;

        $this->examName = isset($columns[0]['main_exam_name']) ? $columns[0]['main_exam_name'] : '-';
        $this->className = isset($columns[0]['class_name']) ? $columns[0]['class_name'] : '-';
        $this->subjectName = isset($columns[0]['subject_name']) ? $columns[0]['subject_name'] : '-';

        $maxMarks = 0;
        foreach ($columns as $column) {
            if (isset($column['average_reduced_marks']) && is_numeric($column['average_reduced_marks'])) {
                $maxMarks += $column['average_reduced_marks'];
            }
        }

        $this->columns = $columns;
    }
}

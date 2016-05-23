<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Http\Modules\reports\School\Models\ProgressPrintStudent;

class StubProgressPrintStudent extends ProgressPrintStudent
{
    public function __construct()
    {

    }
}

class DBStudentReportParseTest extends TestCase
{
    /** @test */
    public function it_extracts_subjects_from_results()
    {
        $data = [
            "student_roll_number" => "RN010",
            0                     => "RN010",
            "student_full_name"   => "SURESH  GUMMADI",
            1                     => "SURESH  GUMMADI",
            "Computers Lab"       => null,
            2                     => null,
            "Hindi"               => "55.00",
            3                     => "55.00",
            "Telugu"              => "89.00",
            4                     => "89.00",
            "English"             => "45.00",
            5                     => "45.00",
            "Maths"               => "91.00",
            6                     => "91.00",
            "Science"             => "75.00",
            7                     => "75.00",
            "Social"              => "61.00",
            8                     => "61.00",
            "max_total_marks"     => "700.00",
            9                     => "700.00",
            "student_total_marks" => "416.00",
            10                    => "416.00",
            "score_percent"       => "59.43",
            11                    => "59.43",
            "grade"               => "B",
            12                    => "B",
            "class_student_id"    => 2,
            13                    => 2,
            "pass_fail"           => "Pass",
            14                    => "Pass",
            "class_name"          => "IX-A",
            15                    => "IX-A",
            "class_entity_id"     => 29,
            16                    => 29,
        ];

        $expected = [
            "Computers Lab"       => null,
            "Hindi"               => "55.00",
            "Telugu"              => "89.00",
            "English"             => "45.00",
            "Maths"               => "91.00",
            "Science"             => "75.00",
            "Social"              => "61.00",
        ];

        $progress = new StubProgressPrintStudent;
        $this->assertEquals($expected, $progress->extractSubjects($data));
    }
}

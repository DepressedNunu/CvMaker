<?php

class EducationModel {
    public $institute;
    public $degree;
    public $from;
    public $to;
    public $grade;

    public function __construct($institute, $degree, $from, $to, $grade) {
        $this->institute = $institute;
        $this->degree = $degree;
        $this->from = $from;
        $this->to = $to;
        $this->grade = $grade;
    }
}

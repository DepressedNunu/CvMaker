<?php

class SkillModel {
    public $skill;
    public $skillLevel;

    public function __construct($skill, $skillLevel) {
        $this->skill = $skill;
        $this->skillLevel = intval($skillLevel);
    }
}
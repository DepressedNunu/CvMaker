<?php

require 'Skill.php';
require 'Hobby.php';
require 'Education.php';
require 'Experience.php';

class ResumeModel {
    public $profile;
    public $firstName;
    public $lastName;
    public $profession;
    public $email;
    public $phone;
    public $aboutMe;
    public $skills = [];
    public $hobbies = [];
    public $educations = [];
    public $experiences = [];

    public function __construct($profile, $firstName, $lastName, $profession, $email, $phone, $aboutMe) {
        $this->profile = $profile;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->profession = $profession;
        $this->email = $email;
        $this->phone = $phone;
        $this->aboutMe = $aboutMe;
    }

    function insertResumeData($db): void
    {
        // Insert basic information
        $stmt = $db->prepare("INSERT INTO resumes (profile, first_name, last_name, profession, email, phone, about_me) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $this->profile, SQLITE3_TEXT);
        $stmt->bindValue(2, $this->firstName, SQLITE3_TEXT);
        $stmt->bindValue(3, $this->lastName, SQLITE3_TEXT);
        $stmt->bindValue(4, $this->profession, SQLITE3_TEXT);
        $stmt->bindValue(5, $this->email, SQLITE3_TEXT);
        $stmt->bindValue(6, $this->phone, SQLITE3_TEXT);
        $stmt->bindValue(7, $this->aboutMe, SQLITE3_TEXT);
        $result = $stmt->execute();

        // Get the last inserted resume ID
        $resumeId = $db->lastInsertId();

        // Insert skills
        foreach ($this->skills as $skill) {
            $stmt = $db->prepare("INSERT INTO skills (resume_id, skill, skill_level) VALUES (?, ?, ?)");
            $stmt->bindValue(1, $resumeId, SQLITE3_INTEGER);
            $stmt->bindValue(2, $skill->skill, SQLITE3_TEXT);
            $stmt->bindValue(3, $skill->skillLevel, SQLITE3_TEXT);
            $stmt->execute();
        }

        // Insert hobbies
        foreach ($this->hobbies as $hobby) {
            $stmt = $db->prepare("INSERT INTO hobbies (resume_id, hobby) VALUES (?, ?)");
            $stmt->bindValue(1, $resumeId, SQLITE3_INTEGER);
            $stmt->bindValue(2, $hobby->hobby, SQLITE3_TEXT);
            $stmt->execute();
        }

        // Insert educations
        foreach ($this->educations as $education) {
            $stmt = $db->prepare("INSERT INTO educations (resume_id, institute, degree, from_date, to_date, grade) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $resumeId, SQLITE3_INTEGER);
            $stmt->bindValue(2, $education->institute, SQLITE3_TEXT);
            $stmt->bindValue(3, $education->degree, SQLITE3_TEXT);
            $stmt->bindValue(4, $education->from, SQLITE3_TEXT);
            $stmt->bindValue(5, $education->to, SQLITE3_TEXT);
            $stmt->bindValue(6, $education->grade, SQLITE3_TEXT);
            $stmt->execute();
        }

        // Insert experiences
        foreach ($this->experiences as $experience) {
            $stmt = $db->prepare("INSERT INTO experiences (resume_id, title, description) VALUES (?, ?, ?)");
            $stmt->bindValue(1, $resumeId, SQLITE3_INTEGER);
            $stmt->bindValue(2, $experience->title, SQLITE3_TEXT);
            $stmt->bindValue(3, $experience->description, SQLITE3_TEXT);
            $stmt->execute();
        }

        if ($result) {
            echo "Data inserted successfully!<br>";
        } else {
            echo "Data not inserted!<br>";
        }
    }



    public function addSkill($skill, $skillLevel) {
        $this->skills[] = new SkillModel($skill, $skillLevel);
    }

    public function addHobby($hobby) {
        $this->hobbies[] = new HobbyModel($hobby);
    }

    public function addEducation($institute, $degree, $from, $to, $grade) {
        $this->educations[] = new EducationModel($institute, $degree, $from, $to, $grade);
    }

    public function addExperience($title, $description) {
        $this->experiences[] = new ExperienceModel($title, $description);
    }
}

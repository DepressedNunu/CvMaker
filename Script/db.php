<?php

require_once '../Models/Resume.php';

function retrieveLastResume(): ResumeModel
{
    require_once '../Models/Resume.php';
    try {
        $dsn = 'sqlite:../Script/db.sqlite';
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
// Retrieve the last resume data from the database
    $stmt = $pdo->prepare("SELECT * FROM resumes ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $resume = new ResumeModel(
        $result['profile'],
        $result['first_name'],
        $result['last_name'],
        $result['profession'],
        $result['email'],
        $result['phone'],
        $result['about_me']
    );
// Fetch skills
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE resume_id = ?");
    $stmt->bindValue(1, $result['id'], PDO::PARAM_INT);
    $stmt->execute();
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($skills as $skill) {
        $resume->addSkill($skill['skill'], $skill['skill_level']);
    }

// Fetch hobbies
    $stmt = $pdo->prepare("SELECT * FROM hobbies WHERE resume_id = ?");
    $stmt->bindValue(1, $result['id'], PDO::PARAM_INT);
    $stmt->execute();
    $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($hobbies as $hobby) {
        $resume->addHobby($hobby['hobby']);
    }

// Fetch educations
    $stmt = $pdo->prepare("SELECT * FROM educations WHERE resume_id = ?");
    $stmt->bindValue(1, $result['id'], PDO::PARAM_INT);
    $stmt->execute();
    $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($educations as $education) {
        $resume->addEducation(
            $education['institute'],
            $education['degree'],
            $education['from_date'],
            $education['to_date'],
            $education['grade']
        );
    }

// Fetch experiences
    $stmt = $pdo->prepare("SELECT * FROM experiences WHERE resume_id = ?");
    $stmt->bindValue(1, $result['id'], PDO::PARAM_INT);
    $stmt->execute();
    $experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($experiences as $experience) {
        $resume->addExperience($experience['title'], $experience['description']);
    }
    return $resume;
}
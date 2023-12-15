<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Models/Resume.php';

try {
    $dsn = 'sqlite:db.sqlite';
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully!<br>";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

try {
    $pdo->query("SELECT 1 FROM resumes");
} catch (Exception   $e) {
    $pdo->query("CREATE TABLE resumes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        profile TEXT NOT NULL,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        profession TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT NOT NULL,
        about_me TEXT NOT NULL
    )");
    echo "Table created successfully!<br>";
}

$resume = new ResumeModel(
    $_FILES['profile_image']['name'],
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['profession'],
    $_POST['email'],
    $_POST['phone'],
    $_POST['about_me']
);

// add skills to the Resume object
for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST['skill' . $i]) && isset($_POST['skill_level' . $i])) {
        $resume->addSkill($_POST['skill' . $i], $_POST['skill_level' . $i]);
    }
}

// add hobbies to the Resume object
for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST['hobby' . $i])) {
        $resume->addHobby($_POST['hobby' . $i]);
    }
}
// add education to the Resume object
for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST['institute' . $i]) && isset($_POST['degree' . $i]) && isset($_POST['from' . $i]) && isset($_POST['to' . $i]) && isset($_POST['grade' . $i])) {
        $resume->addEducation($_POST['institute' . $i], $_POST['degree' . $i], $_POST['from' . $i], $_POST['to' . $i], $_POST['grade' . $i]);
    }
}

// add experience to the Resume object
for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST['title' . $i]) && isset($_POST['description' . $i])) {
        $resume->addExperience($_POST['title' . $i], $_POST['description' . $i]);
    }
}

// insert the Resume object into the database
try {
    $resume->insertResumeData($pdo);
} catch (PDOException $e) {
    die("Error inserting data: " . $e->getMessage());
}

$stmt = $pdo->query('SELECT * FROM resumes');
$storedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
$lastRow = end($storedData);


header("Location: /Views/resume-template.php");
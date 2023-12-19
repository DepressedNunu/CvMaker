<?php

ob_start();
require_once '../Views/resume-template.php';
$html = ob_get_contents();
ob_end_clean();

if ($_GET['id']) {
    require_once '../Script/db.php';
    require_once '../Models/Resume.php';
    $dsn = 'sqlite:../Script/db.sqlite';
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM resumes WHERE id = ?");
    $stmt->bindValue(1, $_GET['id'], PDO::PARAM_INT);
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
        $resume->addExperience
        ($experience['title'], $experience['description']);
    }
}



require '../TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage();
// remove the button from the html before printing
$html .= '<style>'.file_get_contents('../Views/Style/resume.css').'</style>';
$html = preg_replace('/<div class="pdf-button">.*<\/div>/s', '', $html);
$pdf->writeHTML($html);
// add css to the pdf
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->Output('resume.pdf', 'I');
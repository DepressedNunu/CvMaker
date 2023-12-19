<?php
require_once '../Script/db.php';
if ($_GET['id']) {
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
        $resume->addExperience(
            $experience['title'],
            $experience['description']
        );
    }
}
else {
    $resume = retrieveLastResume();
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
        <title><?php echo ucwords($resume->firstName) . ' Resume'; ?></title>
        <link rel="stylesheet" href="Style/resume.css">
    </head>
    <body>
    <div class="grid-container">
        <div class="zone-1">
            <div class="toCenter">
                <img src="<?php echo $resume->profile; ?>" class="profile" alt="">
            </div>
            <!-- Adjusted spacing and styling for better layout -->
            <div class="contact-box">
                <div class="title">
                    <h2>Contact</h2>
                </div>
                <div class="call">
                    <i class="fas fa-phone-alt"></i>
                    <div class="text"><?php echo $resume->phone; ?></div>
                </div>
                <div class="email">
                    <i class="fas fa-envelope"></i>
                    <div class="text"><?php echo $resume->email; ?></div>
                </div>
            </div>
            <!-- Adjusted spacing for better layout -->
            <div class="personal-box">
                <div class="title">
                    <h2>Skills</h2>
                </div>
                <?php
                foreach ($resume->skills as $skill) {
                    echo "<div class='skill-1'>
                        <p><strong>" . strtoupper($skill->skill) . "</strong></p>
                        <div class='progress'>";
                    for ($i = 0; $i < $skill->skillLevel; $i++) {
                        echo '<div class="fas fa-star active"></div>';
                    }
                    echo '</div></div>';
                }
                ?>
            </div>
            <div class="hobbies-box">
                <div class="title">
                    <h2>Hobbies</h2>
                </div>
                <?php
                foreach ($resume->hobbies as $hobby) {
                    echo "<div class='d-flex align-items-center'>
                        <div class='circle'> <div style='margin-left: 130px'><strong>" . ucwords($hobby->hobby) . "</strong></div> </div>
                    </div>";
                }
                ?>
            </div>
        </div>
        <div class="zone-2">
            <div class="headTitle">
                <h1><?php echo ucwords($resume->firstName); ?><br><b><?php echo ucwords($resume->lastName); ?></b></h1>
            </div>
            <div class="subTitle">
                <h1><?php echo ucwords($resume->profession); ?></h1>
            </div>
            <!-- Adjusted spacing for better layout -->
            <div class="group-1">
                <div class="title">
                    <div class="box">
                        <h2>About Me</h2>
                    </div>
                </div>
                <div class="desc"><?php echo $resume->aboutMe; ?></div>
            </div>
            <!-- Adjusted spacing for better layout -->
            <div class="group-2">
                <div class="title">
                    <div class="box">
                        <h2>Education</h2>
                    </div>
                </div>
                <div class="desc">
                    <?php
                    foreach ($resume->educations as $education) {
                        echo "<ul>
                            <li>
                                <div class='msg-1'>" . $education->from . "-" . $education->to . " | " .
                            ucwords($education->degree) . ", " . $education->grade . "</div>
                                <div class='msg-2'>" . ucwords($education->institute) . "</div>
                            </li>
                        </ul>";
                    }
                    ?>
                </div>
            </div>
            <!-- Adjusted spacing for better layout -->
            <div class="group-3">
                <div class="title">
                    <div class="box">
                        <h2>Experience</h2>
                    </div>
                </div>
                <div class="desc">
                    <?php
                    foreach ($resume->experiences as $experience) {
                        echo "<ul>
                            <li>
                                <div class='msg-1'><br></div>
                                <div class='msg-2'>" . ucwords($experience->title) . "</div>
                                <div class='msg-3'>" . ucfirst($experience->description) . "</div>
                            </li>
                        </ul>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="pdf-button">
        <a class="btn" href="../Script/htmlToPdf.php">Download PDF</a>
    </div>
    </body>
    </html>
<?php
?>
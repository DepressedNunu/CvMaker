<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Generator</title>
    <link rel="stylesheet" href="/Style/index.css">
    <script src="/Script/app.js"></script>
    <script src="/Script/index.js"></script>
</head>
<body>
<div class="container">
    <h1 class="text-center my-5 fw-bold">Resume Form</h1>
    <div class="form-container">
        <form action="/Script/submitToDatabase.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="token" value="HGsZOXpfNC">
            <div class="border mb-3">
                <h2>Profile Image</h2>
                <div class="mb-3">
                    <label class="form-label">Select a square image 1:1 (Recommended)</label>
                    <input class="form-control" name="profile_image" type="file" required>
                </div>
            </div>
            <div class="border mb-3">
                <h2>Contact</h2>
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <label class="form-label">First Name</label>
                        <label>
                            <input type="text" name="first_name" class="form-control" required>
                        </label>
                    </div>
                    <div>
                        <label class="form-label">Last Name</label>
                        <label>
                            <input type="text" name="last_name" class="form-control" required>
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Profession</label>
                    <label>
                        <input type="text" class="form-control" name="profession" required>
                    </label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <label>
                        <input type="email" class="form-control" name="email" required>
                    </label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone number</label>
                    <label for="phone"></label><input type="tel" class="form-control" id="phone" name="phone"
                                                      placeholder="07 12 34 56 78" required>
                </div>
            </div>
            <div class="border mb-3">
                <h2>Skills (Max:5)</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Skillset Name</label>
                    <label>
                        <input type="text" class="form-control" name="skill1" required>
                    </label>
                    <label>
                        <select class="form-select mt-2" name="skill_level1" required>
                            <option value="">Select stars based upon your skill level</option>
                            <option value="1">1 - Novice</option>
                            <option value="2">2 - Advanced Beginner</option>
                            <option value="3">3 - Competent</option>
                            <option value="4">4 - Proficient</option>
                            <option value="5">5 - Expert</option>
                        </select>
                    </label>
                </div>
                <div id="addSkill"></div>
                <div class="mb-3">
                    <button type="button" id="skill_hide" class="btn-primary" onclick="addSkill()">+</button>
                </div>
            </div>
            <div class="border mb-3">
                <h2>Hobbies (Max:4)</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Hobby</label>
                    <label>
                        <input type="text" name="hobby1" class="form-control" required>
                    </label>
                </div>
                <div id="addHobby"></div>
                <div class="mb-3">
                    <button type="button" id="hobby_hide" class="btn-primary" onclick="addHobby()">+</button>
                </div>
            </div>
            <div class="border mb-3">
                <h2>About Me</h2>
                <div class="form-floating">
                    <label>
                        <textarea class="form-control" name="about_me" style="height: 100px" required></textarea>
                    </label>
                </div>
            </div>
            <div class="border mb-3">
                <h2>Education (Max:3)</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">School/College/University</label>
                    <label>
                        <input type="text" name="institute1" class="form-control">
                    </label>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Degree Name</label>
                    <label>
                        <input type="text" name="degree1" class="form-control">
                    </label>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <div>
                        <label for="exampleInputEmail1" class="form-label">From</label>
                        <label>
                            <input type="text" name="from1" class="form-control">
                        </label>
                    </div>
                    <div>
                        <label for="exampleInputEmail1" class="form-label">To</label>
                        <label>
                            <input type="text" name="to1" class="form-control">
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Grade/Score/CGPA</label>
                    <label>
                        <input type="text" name="grade1" class="form-control">
                    </label>
                </div>
                <div id="addEducation"></div>
                <div class="mb-3">
                    <button type="button" id="education_hide" class="btn-primary" onclick="addEducation()">+</button>
                </div>
            </div>
            <div class="border mb-3">
                <h2>Experience (Max:3)</h2>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Title</label>
                    <label>
                        <input type="text" name="title1" class="form-control">
                    </label>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Description</label>
                    <label>
                        <input type="text" name="description1" class="form-control">
                    </label>
                </div>
                <div id="addExperience"></div>
                <div class="mb-3">
                    <button type="button" id="experience_hide" class="btn-primary" onclick="addExperience()">+</button>
                </div>
            </div>
            <button type="submit" class="btn-primary">Submit</button>
        </form>
    </div>
</div>

<div class="recent-list-container">
    <h1 class="text-center my-5 fw-bold">Recent Resumes</h1>
    <div class="recent-list">
        <?php
        require_once '../Script/db.php';
        $resume = retrieveAllResumes();
        $i = 0;
        foreach ($resume as $currentResume) {
            $i +=1;
            echo "<div class='recent-item' data-value='$currentResume->dbId'>
                <div class='recent-item-name'>
                    <h3>" . $currentResume->firstName . " " . $currentResume->lastName . "</h3>
                </div>
                <div class='recent-item-profession'>
                    <h4>" . $currentResume->profession . "</h4>
                </div>
                <div class='recent-item-button'>
                    <a class='btn' href='../Views/resume-template.php?id=" . $currentResume->dbId . "'>Download PDF</a>
                </div>
            </div>";
        }
        ?>
    </div>
</div>
</body>
</html>

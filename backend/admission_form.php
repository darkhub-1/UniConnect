<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming user_id is stored in session after login
    $user_id = $_SESSION['user_id']; // Ensure user_id is properly set in your session after login

    // Sanitize input data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $previous_course = mysqli_real_escape_string($conn, $_POST['previous_course']);
    $desired_course = mysqli_real_escape_string($conn, $_POST['desired_course']);
    
    // File upload handling
    $marksheet = $_FILES['marksheet']['name'];
    $marksheet_tmp = $_FILES['marksheet']['tmp_name'];
    $national_id_proof = $_FILES['national_id_proof']['name'];
    $national_id_proof_tmp = $_FILES['national_id_proof']['tmp_name'];
    $student_photo = $_FILES['student_photo']['name'];
    $student_photo_tmp = $_FILES['student_photo']['tmp_name'];

    $marksheet_target = "uploads/MS" . basename($marksheet);
    $national_id_proof_target = "uploads/ID" . basename($national_id_proof);
    $student_photo_target = "uploads/PHT" . basename($student_photo);

    // Check if the uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Move uploaded files
    if (move_uploaded_file($marksheet_tmp, $marksheet_target) && move_uploaded_file($national_id_proof_tmp, $national_id_proof_target) && move_uploaded_file($student_photo_tmp, $student_photo_target)) {
        // Insert into the database
        $sql = "INSERT INTO admissions (user_id, first_name, last_name, father_name, dob, email, phone, previous_course, marksheet, desired_course, national_id_proof, student_photo)
                VALUES ('$user_id', '$first_name', '$last_name', '$father_name', '$dob', '$email', '$phone', '$previous_course', '$marksheet', '$desired_course', '$national_id_proof', '$student_photo')";

        if ($conn->query($sql) === TRUE) {
            // Admission form submitted successfully
            $_SESSION['admission_success'] = true; // Set a session variable for notification
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload files.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form</title>
    <link rel="stylesheet" href="admission_form_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="form-box">
        <form class="form" action="" method="POST" enctype="multipart/form-data">
            <span class="title">Admission Form</span>
            <span class="subtitle">Fill your details</span>
            <div class="form-container">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <input type="text" class="input" name="first_name" placeholder="First Name" required>
                <input type="text" class="input" name="last_name" placeholder="Last Name" required>
                <input type="text" class="input" name="father_name" placeholder="Father's Name" required>
                <label for="dob">Date of Birth:</label>
                <input type="date" class="input" name="dob" id="dob" required>
                <input type="email" class="input" name="email" placeholder="Email" required>
                <input type="text" class="input" name="phone" placeholder="Phone Number" required>
                <input type="text" class="input" name="previous_course" placeholder="Previous Course" required>
                <label for="marksheet">Upload Marksheet:</label>
                <input type="file" class="input" name="marksheet" id="marksheet" required>
                <select name="desired_course" class="input" required>
                    <option value="" disabled selected>Select Desired Course</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Civil Engineering">Civil Engineering</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Economics">Economics</option>
                    <option value="Biotechnology">Biotechnology</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Physics">Physics</option>
                    <option value="Chemistry">Chemistry</option>
                </select>
                <label for="student_photo">Upload Student Photo:</label>
                <input type="file" class="input" name="student_photo" id="student_photo" required>
                <label for="national_id_proof">Upload National ID Proof:</label>
                <input type="file" class="input" name="national_id_proof" id="national_id_proof" required>
            </div>
            <button type="submit">Submit</button> 
        </form>
    </div>
    <div class="navbar-container">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" onclick="history.back()"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</body>
</html>

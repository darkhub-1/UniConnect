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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $previous_course = mysqli_real_escape_string($conn, $_POST['previous_course']);
    $desired_course = mysqli_real_escape_string($conn, $_POST['desired_course']);

    // File upload handling
    $marksheet = $_FILES['marksheet']['name'];
    $marksheet_tmp = $_FILES['marksheet']['tmp_name'];
    $national_id_proof = $_FILES['national_id_proof']['name'];
    $national_id_proof_tmp = $_FILES['national_id_proof']['tmp_name'];

    $marksheet_target = "uploads/" . basename($marksheet);
    $national_id_proof_target = "uploads/" . basename($national_id_proof);

    // Check if the uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Move uploaded files
    if (!move_uploaded_file($marksheet_tmp, $marksheet_target)) {
        echo "Failed to upload marksheet.";
        exit();
    }
    if (!move_uploaded_file($national_id_proof_tmp, $national_id_proof_target)) {
        echo "Failed to upload national ID proof.";
        exit();
    }

    // Insert into the database
    $sql = "INSERT INTO admissions (user_id, first_name, last_name, father_name, email, phone, previous_course, marksheet, desired_course, national_id_proof)
            VALUES ('$user_id', '$first_name', '$last_name', '$father_name', '$email', '$phone', '$previous_course', '$marksheet', '$desired_course', '$national_id_proof')";

    if ($conn->query($sql) === TRUE) {
        echo "Admission form submitted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

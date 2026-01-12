<?php
session_start();

// Check if admission form was successfully submitted
if (isset($_SESSION['admission_success']) && $_SESSION['admission_success']) {
    echo "<div class='alert success'>Admission form submitted successfully!</div>";
    // Clear the session variable to avoid showing the message on subsequent visits
    unset($_SESSION['admission_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dash_styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
        <div class="navbar-container">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    <a class="nav-link" href="admission_form.php">Admission Form</a>
                    <a class="nav-link" href="help.php">Help</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                </div>
            </div>
        </div>

        <div class="content">
            <br>
            <br>
            <br>
            <h2>Fee Structure</h2>
            <p>For the fee structure: <a href="https://dsatm.edu.in/images/admission/2024-25/be_barch_fee_structure_2024_25.pdf" class="btn">Fee PDF</a></p>
            <h2>Admission Form</h2>
            <p>For admission, please <a href="admission_form.php" class="btn">Fill Admission Form</a></p>

            <!-- Information Bulletin Section -->
            <h2>Information Bulletin</h2>
            <div class="bulletin" id="bulletin">
                <ul>
                    <li> Orientation program for new students on August 1st.</li>
                    <li> Last date for admission form submission is December 15th.</li>
                    <li> Mid-semester exams start from February 10th.</li>
                    <li> Annual sports meet scheduled for December 25th.</li>
                    <li> Check the <a href="https://www.nitk.ac.in/document/attachments/6481/Academic_Calendar_of_all_the_programmes_of_even_semester_except_II_Semester_B.Tech_for_the_AY_2023-24.pdf">academic calendar</a> for more details.</li>
                </ul>
            </div>
        </div>
    </div>
    <script src="Js1.js"></script>
</body>
</html>

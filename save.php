<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students
    (fullname, email, phone, gender, course)
    VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssss",
        $fullname,
        $email,
        $phone,
        $gender,
        $course
    );

    if ($stmt->execute()) {

        echo "<h2>Registration Successful!</h2>";
        echo "<p>Your information has been saved.</p>";
        echo '<a href="index.php">Register Another Student</a>';
        echo "<br><br>";
        echo '<a href="students.php">View Students</a>';

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>
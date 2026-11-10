<?php

include "db.php";

$sql = "SELECT * FROM students ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Students</title>

    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f0f0f0;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid gray;
            text-align: left;
        }

        th {
            background: blue;
            color: white;
        }
    </style>
</head>

<body>

<h2>Registered Students</h2>

<table>

<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Gender</th>
    <th>Course</th>
    <th>Date</th>
</tr>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "<tr>";

        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
        echo "<td>" . htmlspecialchars($row['course']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";

        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='7'>No students registered yet.</td></tr>";
}

$conn->close();

?>

</table>

<br>

<a href="index.php">Register New Student</a>

</body>
</html>
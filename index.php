<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>

    <style>
        body {
            font-family: Arial;
            background: #e8f0fe;
            padding: 30px;
        }

        .container {
            background: white;
            width: 350px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        button {
            background: blue;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="container">

<h2>Student Registration</h2>

<form action="save.php" method="POST">

    <label>Full Name</label>
    <input type="text" name="fullname" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Phone</label>
    <input type="tel" name="phone" required>

    <label>Gender</label>
    <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>

    <label>Course</label>
    <select name="course" required>
        <option value="">Select Course</option>
        <option value="PHP">PHP</option>
        <option value="Database">Database</option>
        <option value="Networking">Networking</option>
        <option value="Electronics">Electronics</option>
    </select>

    <button type="submit" name="register">
        Register
    </button>

</form>

<br>

<a href="students.php">View Registered Students</a>

</div>

</body>
</html>
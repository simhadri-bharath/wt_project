<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Database connection details
        $serverName = "localhost";
        $userName = "root";
        $dbPassword = ""; // Database user password
        $dbName = "yoga";

        // Create connection
        $conn = new mysqli($serverName, $userName, $dbPassword, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement
        $sql = "SELECT email, password FROM student WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ss", $email, $password);

        // Execute query
        $stmt->execute();

        // Store result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<script type="text/javascript">';
            echo 'alert("Successfully logged in!");';
            echo 'window.location.href = "index.html";';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("Incorrect email or password!");';
            echo 'window.location.href = "login.html";';
            echo '</script>';
        }

        // Close the prepared statement and the connection
        $stmt->close();
        $conn->close();
        exit();
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Email and password required!");';
        echo 'window.location.href = "login.html";';
        echo '</script>';
        exit();
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid request method!");';
    echo 'window.location.href = "login.html";';
    echo '</script>';
    exit();
}
?>

<?php
// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure that all required fields are present
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
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

     

        // Use prepared statements for secure data insertion
        $stmt = $conn->prepare("INSERT INTO student (name, email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $password);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Data is inserted successfully.";
                 // Close the prepared statement
                 $stmt->close();

                 // Close the database connection
                 $conn->close();
 
                 // Output JavaScript for displaying message in bold and redirection
                 echo '<script type="text/javascript">';
                 echo 'document.body.innerHTML = "<p style=\'font-weight: bold;\'>Registered successfully!</p>";';
                 echo 'setTimeout(function() { window.location.href = \'index.html\'; }, 2000);';
                 echo '</script>';
                 exit();
                
            } else {
                echo "Error while inserting the data: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "Required parameters are missing.";
    }
} else {
    echo "Invalid request method.";
}
?>

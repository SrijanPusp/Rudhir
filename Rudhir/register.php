<?php
$host = "sql6.freesqldatabase.com";
$username = "sql6679712";
$password = "YAZNRVsF6J";
$database = "sql6679712";
$port = 3306;

$conn = new mysqli($host, $username, $password, $database, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
 
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    
    if ($password !== $confirm_password) {
        echo "Error: Passwords do not match";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Get user input
    $login_email = $_POST["login_email"];
    $login_password = $_POST["login_password"];

    
    $sql = "SELECT * FROM users WHERE email='$login_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
 
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row['password'])) {
            echo "Login successful!";
        } else {
            echo "Error: Incorrect password";
        }
    } else {
        echo "Error: User not found";
    }
}

// Close the connection
$conn->close();
?>

<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "organic";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Retrieve user data from the database
    $sql = "SELECT username, password FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            header("Location: landingpage.html");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    } else {
        $message = "No user found with that username.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a8e063 0%, #56ab2f 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
            transition: all 0.3s ease;
        }
        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 25px rgba(0,0,0,0.3);
        }
        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            border-color: #56ab2f;
            box-shadow: 0 0 8px rgba(86, 171, 47, 0.5);
            outline: none;
        }
        .form-group button {
            width: 100%;
            padding: 15px;
            background-color: #56ab2f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group button:hover {
            background-color: #a8e063;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .form-group a {
            display: block;
            margin-top: 10px;
            color: #56ab2f;
            text-decoration: none;
        }
        .form-group a:hover {
            text-decoration: underline;
        }
        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            color: white;
            background-color: #ff4c4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($message)) : ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="signin.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <div class="form-group">
                <a href="register.php">Don't have an account? Register here.</a>
            </div>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <style>
        body {
            background-image: linear-gradient(#F4E1FB, #C89EF1);
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content {
            text-align: center;
            border-radius: 15px;
            border: 2px solid #F4E1FB;
            margin: 150px auto;
            padding: 30px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.85);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        label {
            font-size: 15pt;
            color: #6A0572;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        h1 {
            text-shadow: 2px 2px 8px #C89EF1;
            color: #4A154B;
            font-size: 35pt;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #C89EF1;
            font-size: 14pt;
            background-color: #F4E1FB;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #C89EF1;
            font-size: 16pt;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #6A0572;
        }
        p {
            color: #FF0000;
            font-size: 12pt;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h1><strong>Registration Page</strong></h1>
<div class="content">
    <form method="post" action="sucess.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />

        <input type="submit" name="register" value="Register" />
    </form>

    <?php
    // MySQL PDO connection setup
    $host = "localhost";
    $dbname = "connexion";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
        $user = trim($_POST['username']);
        $pass = trim($_POST['password']);
        $error = "";

        // Basic validation
        if (empty($user) || empty($pass)) {
            $error = "All fields are required.";
        }

        if (!$error) {
            // Insert user into the database using prepared statement
            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$user, $pass]);

                // Redirect to success page after successful registration
                header("Location: sucess.php");
                exit();
            } catch (PDOException $e) {
                $error = "Error: " . $e->getMessage();
            }
        }

        // Display any error messages
        if ($error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
    ?>
</div>
</body>
</html>

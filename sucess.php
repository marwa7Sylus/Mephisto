<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <title>Navigation Page</title>
    <style>
        body {
            background-image: linear-gradient(to bottom, #F4E1FB, #C89EF1);
            background-size: cover;
            background-repeat: initial;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .content {
            text-align: center;
            border-radius: 15px;
            border: 2px solid #C89EF1;
            margin: 50px auto;
            padding: 30px;
            width: 600px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            color: #C89EF1;
            font-size: 40px;
            text-align: center;
            margin-top: 20px;
        }
        .button {
            display: block;
            margin: 20px auto;
            padding: 15px 40px;
            font-size: 20px;
            color: white;
            background-color: #C89EF1;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
        .button:hover {
            background-color: #A876D5;
        }
    </style>
</head>
<body>
<h1><strong>Bienvenue</strong></h1>
<div class="content">
    <a href="student_display.php" class="button">Afficher Étudiants</a>
        <a href="student_add.php" class="button">Ajouter Étudiant</a>
        <a href="etab_add.php" class="button">Ajouter Établissement</a>
        <a href="etab_display.php" class="button">Afficher Établissement</a>
</div>
<br>
<br>
<br>
</body>
</html>

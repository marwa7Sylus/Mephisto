<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4E1FB;
            color: #4A4A4A;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #C89EF1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #FFFFFF;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #C89EF1;
        }

        th {
            background-color: #C89EF1;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #F4E1FB;
        }

        tr:hover {
            background-color: #EADAF9;
        }

        button {
            background-color: #C89EF1;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        button:hover {
            background-color: #A77DD5;
        }

        form {
            display: inline;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #4A4A4A;
        }
    </style>
</head>
<body>
<h1>Student Table</h1>
<?php
$host = "localhost";
$dbname = "scolarite";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if they don't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS etablissement (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NOT NULL
        )");

    $conn->exec("CREATE TABLE IF NOT EXISTS student (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(255) NOT NULL,
            etablissement_id INT NOT NULL,
            FOREIGN KEY (etablissement_id) REFERENCES etablissement(id) ON DELETE CASCADE ON UPDATE CASCADE
        )");

    // Insert example data if tables are empty
    $checkEtablissement = $conn->query("SELECT COUNT(*) FROM etablissement")->fetchColumn();
    if ($checkEtablissement == 0) {
        $conn->exec("INSERT INTO etablissement (nom) VALUES ('EIDIA'), ('EMADU')");
    }

    $checkStudent = $conn->query("SELECT COUNT(*) FROM student")->fetchColumn();
    if ($checkStudent == 0) {
        $conn->exec("INSERT INTO student (nom, etablissement_id) VALUES 
                ('Alice', 1), 
                ('Bob', 2), 
                ('Charlie', 1)");
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

try {
    // Query with JOIN to get student data along with their establishment name
    $stmt = $conn->query("
            SELECT s.id, s.nom AS student_name, e.nom AS establishment_name 
            FROM student s
            JOIN etablissement e ON s.etablissement_id = e.id
        ");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($students) > 0) {
        echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Establishment</th>
                        <th>Actions</th>
                    </tr>";
        foreach ($students as $student) {
            echo "<tr>
                        <td>" . htmlspecialchars($student['id']) . "</td>
                        <td>" . htmlspecialchars($student['student_name']) . "</td>
                        <td>" . htmlspecialchars($student['establishment_name']) . "</td>
                        <td>
                            <form action='edit_etudiant.php' method='get'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($student['id']) . "'>
                                <button type='submit'>Modifier</button>
                            </form>
                            <form action='delete_student.php' method='post'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($student['id']) . "'>
                                <button type='submit'>Supprimer</button>
                            </form>
                        </td>
                      </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No students found in the database.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
</body>
</html>

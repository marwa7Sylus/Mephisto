<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Establishments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4E1FB;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #C89EF1;
            padding: 20px;
        }

        table {
            margin: 20px auto;
            width: 80%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        th, td {
            border: 1px solid #C89EF1;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #C89EF1;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #F4E1FB;
        }

        tr:nth-child(odd) {
            background-color: #FFFFFF;
        }

        button {
            background-color: #C89EF1;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }

        button:hover {
            background-color: #A570D8;
        }

        form {
            display: inline;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #C89EF1;
        }
    </style>
</head>
<body>
<h1>List of Establishments</h1>
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
        $conn->exec("INSERT INTO etablissement (nom) VALUES ('EIDIA'), ('EMADU'), ('EPS'), ('BIOMED'), ('INSA')");
    }

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

try {
    // Query to get distinct establishment names
    $stmt = $conn->query("SELECT id, nom FROM etablissement");
    $etablissements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($etablissements) > 0) {
        echo "<table>
                    <tr>
                        <th>Establishment ID</th>
                        <th>Establishment Name</th>
                        <th>Actions</th>
                    </tr>";
        foreach ($etablissements as $etablissement) {
            echo "<tr>
                        <td>" . htmlspecialchars($etablissement['id']) . "</td>
                        <td>" . htmlspecialchars($etablissement['nom']) . "</td>
                        <td>
                            <form action='modify_etab.php' method='get'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($etablissement['id']) . "'>
                                <button type='submit'>Modify</button>
                            </form>
                            <form action='delete_etab.php' method='post'>
                                <input type='hidden' name='id' value='" . htmlspecialchars($etablissement['id']) . "'>
                                <button type='submit' onclick=\"return confirm('Are you sure you want to delete this establishment?')\">Delete</button>
                            </form>
                        </td>
                      </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No establishments found in the database.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
</body>
</html>

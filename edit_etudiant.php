<?php
$host = "localhost";
$dbname = "scolarite";
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM student WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            echo "<style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #F4E1FB;
                        margin: 0;
                        padding: 0;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .form-container {
                        background-color: white;
                        border: 1px solid #C89EF1;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        padding: 20px;
                        width: 300px;
                    }
                    .form-container label {
                        color: #C89EF1;
                        font-weight: bold;
                        display: block;
                        margin-bottom: 5px;
                    }
                    .form-container input, .form-container select, .form-container button {
                        width: 100%;
                        padding: 10px;
                        margin-bottom: 15px;
                        border: 1px solid #C89EF1;
                        border-radius: 5px;
                    }
                    .form-container button {
                        background-color: #C89EF1;
                        color: white;
                        font-weight: bold;
                        cursor: pointer;
                        transition: background-color 0.3s;
                    }
                    .form-container button:hover {
                        background-color: #A977D9;
                    }
                  </style>";

            echo "<div class='form-container'>
                    <form action='' method='post'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($student['id']) . "'>
                        <label for='nom'>Nom:</label>
                        <input type='text' id='nom' name='nom' value='" . htmlspecialchars($student['nom']) . "' required><br>
                        <label for='etablissement'>Établissement:</label>
                        <select id='etablissement' name='etablissement' required>";

            $etablissements = $conn->query("SELECT * FROM etablissement")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($etablissements as $etablissement) {
                $selected = $etablissement['id'] == $student['etablissement_id'] ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($etablissement['id']) . "' $selected>" . htmlspecialchars($etablissement['nom']) . "</option>";
            }

            echo "</select>
                        <button type='submit'>Enregistrer</button>
                    </form>
                  </div>";
        } else {
            echo "Étudiant non trouvé.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['nom'], $_POST['etablissement'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $etablissement_id = $_POST['etablissement'];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE student SET nom = :nom, etablissement_id = :etablissement_id WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':etablissement_id', $etablissement_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Étudiant mis à jour avec succès !";
        header("Location: student_display.php"); // Remplacez 'student_display.php' par la page qui liste les étudiants
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Requête invalide.";
}
?>

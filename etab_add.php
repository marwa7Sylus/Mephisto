<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Étudiant & Établissement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4E1FB;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            color: #C89EF1;
            text-align: center;
        }

        form {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 10px;
        }

        label {
            font-weight: bold;
            color: #333333;
            display: block;
            margin-bottom: 5px;
        }

        select, input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #C89EF1;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #C89EF1;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #A775D9;
        }

        p {
            color: #333333;
            text-align: center;
        }

        .success {
            color: #4CAF50;
        }

        .error {
            color: #F44336;
        }
    </style>
</head>
<body>
<h2>Ajout d'un établissement</h2>
<form action="" method="post">
    <label for="etablissement_nom">Nom de l'établissement:</label><br>
    <select id="etablissement_nom" name="etablissement_nom" required>
        <option value="EIDIA">EIDIA</option>
        <option value="EMADU">EMADU</option>
        <option value="EPS">EPS</option>
        <option value="BIOMED">BIOMED</option>
        <option value="INSA">INSA</option>
        <option value="Autre">Autre</option>
    </select><br><br>
    <input type="submit" name="add_etablissement" value="Ajouter l'établissement">
</form>

<?php
$host = "localhost";
$dbname = "scolarite";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_etablissement'])) {
        $etablissement_nom = $_POST['etablissement_nom'];

        // Si l'utilisateur choisit "Autre", on peut ajouter un champ texte pour préciser le nom
        if ($etablissement_nom == "Autre") {
            echo '<form action="" method="post">
                    <label for="nouveau_etablissement">Nom de l\'autre établissement:</label><br>
                    <input type="text" id="nouveau_etablissement" name="nouveau_etablissement" required><br><br>
                    <input type="submit" name="add_other_etablissement" value="Ajouter l\'autre établissement">
                  </form>';
        } else {
            $stmt = $conn->prepare("INSERT INTO etablissement (nom) VALUES (:nom)");
            $stmt->bindParam(':nom', $etablissement_nom);
            $stmt->execute();
            echo "<p class='success'>Établissement ajouté avec succès!</p>";

            // Redirection vers la page d'accueil (index.php ou autre)
            header("Location: sucess.php"); // Remplacez 'index.php' par le nom de votre page d'accueil
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_other_etablissement'])) {
        $nouveau_etablissement = $_POST['nouveau_etablissement'];
        $stmt = $conn->prepare("INSERT INTO etablissement (nom) VALUES (:nom)");
        $stmt->bindParam(':nom', $nouveau_etablissement);
        $stmt->execute();
        echo "<p class='success'>Nouvel établissement ajouté avec succès!</p>";

        // Redirection vers la page d'accueil (index.php ou autre)
        header("Location: sucess.php"); // Remplacez 'index.php' par le nom de votre page d'accueil
        exit();
    }

} catch (PDOException $e) {
    echo "<p class='error'>Erreur: " . $e->getMessage() . "</p>";
}
?>

</body>
</html>

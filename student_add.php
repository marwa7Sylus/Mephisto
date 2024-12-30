<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4E1FB;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #C89EF1;
            margin-top: 20px;
        }

        form {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #C89EF1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #C89EF1;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #C89EF1;
            color: #FFFFFF;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #A77ACF;
        }

        p {
            text-align: center;
            font-size: 14px;
        }

        p.erreur {
            color: red;
            font-weight: bold;
        }

        p.succes {
            color: green;
            font-weight: bold;
        }

        .retour {
            text-align: center;
            margin-top: 20px;
        }

        .retour a {
            color: #C89EF1;
            font-weight: bold;
            text-decoration: none;
            font-size: 16px;
        }

        .retour a:hover {
            color: #A77ACF;
        }
    </style>
</head>
<body>
<h2>Ajout d'étudiant</h2>
<form action="" method="post">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required>

    <label for="etablissement">Établissement:</label>
    <select id="etablissement" name="etablissement" required>
        <?php
        $host = "localhost";
        $dbname = "scolarite";
        $username = "root";
        $password = "";

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->query("SELECT id, nom FROM etablissement");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nom']) . "</option>";
            }
        } catch (PDOException $e) {
            echo "<p class='erreur'>Erreur: " . $e->getMessage() . "</p>";
        }
        ?>
    </select>

    <input type="submit" value="Soumettre">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nom = $_POST['nom'];
        $etablissement_id = $_POST['etablissement'];

        $stmt = $conn->prepare("INSERT INTO student (nom, etablissement_id) VALUES (:nom, :etablissement_id)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':etablissement_id', $etablissement_id);

        $stmt->execute();

        echo "<p class='succes'>Étudiant enregistré avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p class='erreur'>Erreur: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Lien pour revenir à la page d'accueil -->
<div class="retour">
    <a href="sucess.php">Retour à l'accueil</a>
</div>

</body>
</html>

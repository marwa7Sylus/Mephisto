<?php
$host = "localhost";
$dbname = "scolarite";
$username = "root";
$password = "";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si l'ID est passé en paramètre
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Préparer la requête pour supprimer l'établissement
        $stmt = $conn->prepare("DELETE FROM etablissement WHERE id = :id");
        $stmt->bindParam(':id', $id);

        // Exécuter la requête
        $stmt->execute();

        // Message de confirmation
        echo "<p>Établissement supprimé avec succès!</p>";
        echo "<a href='etab_display.php'>Retourner à la liste des établissements</a>"; // Redirige vers la page d'accueil
    } else {
        echo "<p>ID de l'établissement manquant.</p>";
    }

} catch (PDOException $e) {
    echo "<p>Erreur: " . $e->getMessage() . "</p>";
}
?>


<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Datenbank erstellen, falls sie nicht existiert
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === FALSE) {
    die("Fehler beim Erstellen der Datenbank: " . $conn->error);
}

// Zur erstellten Datenbank wechseln
$conn->select_db($dbname);

// Tabelle erstellen, falls sie nicht existiert
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die("Fehler beim Erstellen der Tabelle: " . $conn->error);
}

// Beispiel-Benutzer hinzufügen, falls die Tabelle leer ist
$sql = "SELECT COUNT(*) as count FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sql = "INSERT INTO users (username, password) VALUES
        ('testuser', MD5('passwort123'))";
    if ($conn->query($sql) === FALSE) {
        die("Fehler beim Hinzufügen von Beispiel-Benutzern: " . $conn->error);
    }
}

$conn->close();
header("Location: index.html"); // Zurück zur Login-Seite
exit();
?>

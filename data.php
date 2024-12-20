<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

// Verbindung erstellen
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
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    die("Fehler beim Erstellen der Tabelle: " . $conn->error);
}

// Beispiel-Daten einfügen, falls die Tabelle leer ist
$sql = "SELECT COUNT(*) as count FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sql = "INSERT INTO users (name, email) VALUES
        ('Max Mustermann', 'max@example.com'),
        ('Anna Müller', 'anna@example.com')";
    if ($conn->query($sql) === FALSE) {
        die("Fehler beim Einfügen von Daten: " . $conn->error);
    }
}

// Daten aus der Tabelle abrufen
$sql = "SELECT id, name, email, created_at FROM users";
$result = $conn->query($sql);

// Ergebnisse in einem Array speichern
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// JSON-Ausgabe der Daten
header('Content-Type: application/json');
echo json_encode($data);

// Verbindung schließen
$conn->close();
?>

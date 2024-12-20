<?php
session_start(); // Sitzung starten

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Login-Daten prüfen
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Passwort verschlüsseln und mit der Datenbank vergleichen
    $hashedPassword = md5($inputPassword);
    $sql = "SELECT * FROM users WHERE username = '$inputUsername' AND password = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login erfolgreich
        $_SESSION['username'] = $inputUsername;
        header("Location: mainpage.php"); // Weiterleitung zur Hauptseite
        exit();
    } else {
        // Login fehlgeschlagen
        echo "Ungültiger Benutzername oder Passwort.";
    }
}

$conn->close();
?>

<?php
session_start();
session_destroy(); // Sitzung beenden
header("Location: index.html"); // Zurück zur Login-Seite
exit();
?>

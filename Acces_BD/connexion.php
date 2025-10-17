<?php
function Connect() {
    $env = parse_ini_file(".env");
    $conn = new mysqli($env['Serveur'], $env['Utilisateur'], $env['Password'], $env['db_name']);
    if ($conn->connect_error) {
        die("Erreur de connexion: " . $conn->connect_error);
    }
    return $conn;
}
?>

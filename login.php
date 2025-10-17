<?php 
include("public/header.php");
include("public/nav_barre.php");
?>

<h2>Authentification</h2>
<form action="login.php" method="post" class="form-login">
    <label>Email :</label>
    <input type="email" name="email" required>

    <label>Mot de passe :</label>
    <input type="password" name="password" required>

    <button type="submit">Se connecter</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "admin@gmail.com" && $password === "1234") {
        echo "<p style='color:green;'>Connexion réussie ✅</p>";
    } else {
        echo "<p style='color:red;'>Email ou mot de passe incorrect ❌</p>";
    }
}
?>

<?php include("public/footer.php"); ?>

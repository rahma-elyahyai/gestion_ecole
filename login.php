<?php 
include("public/header.php");
include("public/nav_barre.php");
?>
<link rel="stylesheet" href="public/css/login.css">

<section class="login-section">
  <div class="login-card">
    <!-- Left image -->
    <div class="login-image"></div>
    <?php
    session_start();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($email === "prof@gmail.com" && $password === "prof123") {
                header("Location: IHM/prof/affichage.php");
                exit;
            } 
            elseif ($email === "student@gmail.com" && $password === "student123") {
                header("Location: IHM/etudiant/affichage.php");
                exit;
            } 
            else {
                echo "<div class='alert alert-danger text-center mt-3'>Email ou mot de passe incorrect ❌</div>";
            }
        }
    ?>

    <!-- Right form -->
    <div class="login-form">
      <h2>Authentification</h2>

      <form action="login.php" method="post" class="form-login">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
      </form>

    </div>
  </div>
</section>

<?php include("public/footer.php"); ?>

<?php 
include("public/header.php");
include("public/nav_barre.php");
?>
<link rel="stylesheet" href="public/css/login.css">

<section class="login-section">
  <div class="login-card">
    <!-- Left image -->
    <div class="login-image"></div>

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

      <?php
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
          $email = $_POST['email'];
          $password = $_POST['password'];

          if ($email === "admin@gmail.com" && $password === "1234") {
              echo "<div class='alert alert-success'>Connexion réussie ✅</div>";
          } else {
              echo "<div class='alert alert-error'>Email ou mot de passe incorrect ❌</div>";
          }
      }
      ?>
    </div>
  </div>
</section>

<?php include("public/footer.php"); ?>

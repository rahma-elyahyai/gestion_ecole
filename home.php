<?php 
include("public/header.php");
include("public/nav_barre.php");
?>

<div class="home-container container">
  <div class="row align-items-center">
    <!-- Left side: text -->
    <div class="col-md-6 text-section">
      <h1>Bienvenue dans l’application de gestion d’école</h1>
      <p>
        Simplifiez la gestion de votre établissement : étudiants, professeurs et cours, tout en un seul endroit.
        <br><br>
        Explorez, organisez et maîtrisez votre école avec facilité.
      </p>
      <a href="login.php" class="btn btn-primary btn-lg">
        Commencer →
      </a>
    </div>

    <!-- Right side: image -->
    <div class="col-md-6 text-center">
      <img src="public/imgs/illustration.png" alt="Illustration école" class="home-img">
    </div>
  </div>
</div>

<?php include("public/footer.php"); ?>

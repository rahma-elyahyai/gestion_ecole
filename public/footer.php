<?php
$phrases = [
    "Apprendre, c’est grandir chaque jour 🌱",
    "Le savoir est une aventure infinie 🚀",
    "Codez, testez, réussissez 💻"
];
$phrase = $phrases[array_rand($phrases)];
?>
<footer class="modern-footer">
  <div class="container text-center">
    <p class="footer-phrase"><?= $phrase ?></p>
    <div class="footer-links">
      <a href="#">À propos</a>
      <a href="#">Contact</a>
      <a href="#">Confidentialité</a>
    </div>
    <p class="footer-copy">&copy; <?= date('Y') ?> Mon École. Tous droits réservés.</p>
  </div>
</footer>
</body>
</html>

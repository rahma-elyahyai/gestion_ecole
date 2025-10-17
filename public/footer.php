<?php
$phrases = [
    "Apprendre, c’est grandir chaque jour 🌱",
    "Le savoir est une aventure infinie 🚀",
    "Codez, testez, réussissez 💻"
];
$phrase = $phrases[array_rand($phrases)];
?>
<footer>
    <p><?= $phrase ?></p>
</footer>
</body>
</html>

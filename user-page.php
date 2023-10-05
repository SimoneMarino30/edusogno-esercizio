<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "./connection.php";
// Verifica se la variabile di sessione email è impostata
var_dump($_SESSION["email"]);
if (isset($_SESSION["email"])) {
  include __DIR__ . '/partials/nav.php';
?>
<h1>Ciao <?php echo $_SESSION["email"]; ?>, ecco i tuoi eventi </h1>
<a href="./logout.php">Logout</a>
<?php exit();
  include __DIR__ . './partials/closing-tag.php';
} else {
  // header("Location: index.php");
  echo "L'utente non è autenticato, gestisci il reindirizzamento o l'accesso non autorizzato."; ?>
<a href="./index.php">Home</a>
<?php }
?>
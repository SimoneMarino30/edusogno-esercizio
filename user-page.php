<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./connection.php";
// Verifica se la variabile di sessione email è impostata
// var_dump($_SESSION["email"]);
if (isset($_SESSION["email"])) {
  include __DIR__ . '/partials/nav.php';
?>
<h1>Ciao <?php echo $_SESSION["email"]; ?>, ecco i tuoi eventi </h1>

<a href="./logout.php">Logout</a>

<?php
  include __DIR__ . './partials/closing-tag.php';
  // exit();
} else {
  if (isset($_SESSION["register-mail"])) {
    include __DIR__ . '/partials/nav.php';
?>
<h1>Ciao <?php echo $_SESSION["register-mail"]; ?>, aggiungi un evento</h1>
<a href="./logout.php">Logout</a>
<?php 
  include __DIR__ . './partials/closing-tag.php';  
  }
  // header("Location: index.php");
  ?>
<a href="./index.php">vvvHome</a>
<?php }
?>
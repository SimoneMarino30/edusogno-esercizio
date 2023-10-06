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
  <h1>Ciao
    <?php echo $_SESSION["user-name"], str_repeat('&nbsp;', 1), $_SESSION["user-surname"]; ?>,
    ecco i tuoi eventi
  </h1>
  <!-- change password -->
  <button type="submit">
    <a href="./edit-password.php">edit Password</a>
  </button>
  <hr>
  <!-- section events -->
  <section class="events">
    <div class="event-card">
      <h1>Nome evento</h1>
      <div class="event-date">data</div>
      <button>Join</button>
    </div>
  </section>
  <!-- logout -->
  <a href="./logout.php">Logout</a>

  <?php
  include __DIR__ . './partials/closing-tag.php';
  // exit();
} else {
  if (isset($_SESSION["register-mail"])) {
    include __DIR__ . '/partials/nav.php';
  ?>
    <h1>Ciao
      <?php echo $_SESSION["register-name"], str_repeat('&nbsp;', 1), $_SESSION["register-surname"]; ?>,
      aggiungi un evento
    </h1>
    <!-- change password -->
    <button>Change password</button>
    <hr>
    <!-- section events -->
    <section class="events">
      <div class="event-card"></div>
    </section>
    <!-- logout -->
    <a href="./logout.php">Logout</a>
  <?php
    include __DIR__ . './partials/closing-tag.php';
  }
  ?>
  <a href="./index.php">Home</a>
<?php
  var_dump($_SESSION["user-id"]);
  // session_destroy();
}

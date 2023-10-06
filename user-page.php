<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./connection.php";

if (isset($_SESSION["email"])) {
  include __DIR__ . '/partials/nav.php';

  $EventSql = "SELECT nome_evento, data_evento, attendees FROM eventi";
  $stmt = $conn->prepare($EventSql);
  // $event_email = $_SESSION["email"];
  // $stmt->bind_param("s", $event_email);
  $stmt->execute();
  $result = $stmt->get_result();

  // $cards = "";
  // while ($row = $result->fetch_assoc()) {
  //   if ($row) {
  //     $event_name = $row["nome_evento"];
  //     $event_date = $row["data_evento"];
  //     $attendees = explode(",", $row["attendees"]);
  //   }

  //   // var_dump($attendees);
  //   foreach ($attendees as $event_email) {
  //     if ($event_email == $_SESSION["email"]) {

  //       $cards .= "
  //         <div class='event-card'>
  //             <h1>$event_name</h1>
  //             <div class='event-date'>$event_date</div>
  //             <button>Join</button>
  //         </div>";
  //     }
  //   }
  // }

?>
<h1>Ciao
  <?php echo $_SESSION["user-name"], str_repeat('&nbsp;', 1), $_SESSION["user-surname"]; ?>,
  ecco i tuoi eventi
</h1>
<button>Aggiungi evento</button>
<!-- change password -->
<button type="submit">
  <a href="./edit-password.php">edit Password</a>
</button>
<hr>
<!-- section events -->

<!-- <div class="event-card">
      <h1>Nome evento</h1>
      <div class="event-date">data</div>
      <button>Join</button>
    </div> -->
<div class="events-container">
  <?php while ($row = $result->fetch_assoc()) : ?>
  <?php
        $event_name = $row["nome_evento"];
        $event_date = $row["data_evento"];
        $attendees = explode(",", $row["attendees"]);
        foreach ($attendees as $email) :
          if ($email == $_SESSION["email"]) : ?>
  <div class='event-card'>
    <h1><?php echo $event_name; ?></h1>
    <div class='event-date'><?php echo $event_date; ?></div>
    <button>Join</button>
  </div>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php endwhile; ?>
</div>

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
<button>Aggiungi evento</button>
<!-- change password -->
<button>Change password</button>
<hr>
<!-- section events -->
<section class="events">
  <div class="event-date"></div>
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
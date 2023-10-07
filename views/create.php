<?php
include "../connection.php";
include "./models/Event.php";
include "../controllers/EventController.php";

$eventController = new EventController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $event = new Event($_POST['attendees'], $_POST['name_event'], $_POST['date_event']);
  $result = $eventController->create($event);

  if ($result) {
    echo "Evento creato con successo.";
    header("Location: ../user-page.php");
  } else {
    echo "Errore nella creazione dell'evento.";
    header("Location: index.php");
  }
}
include  "../partials/nav.php";
?>
<form method="POST" class="form-style">
  <label for="attendees">Partecipanti:</label><br>
  <input type="text" id="attendees" name="attendees"><br>
  <label for="name_event">Nome dell'evento:</label><br>
  <input type="text" id="name_event" name="name_event"><br>
  <label for="date_event">Data dell'evento:</label><br>
  <input type="date" id="date_event" name="date_event"><br>

  <input type="submit" value="Crea Evento" class="changePasswordBtn">
  <!-- link back -->
  <button type="submit" name="changePasswordBtn" class="back-button">
    <a href="../user-page.php">
      <i class="fa-solid fa-arrow-left-long"></i>
      <span>Back</span>
    </a>
  </button>
</form>
<?php
include "../partials/closing-tag.php";

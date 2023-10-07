<?php
include "../connection.php";
include "./models/Event.php";
include "../controllers/EventController.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$eventController = new EventController($conn);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
  $name_event = filter_input(INPUT_POST, 'name_event');
  $date_event = filter_input(INPUT_POST, 'date_event');
  $attendees = filter_input(INPUT_POST, 'attendees');

  if ($id && $name_event && $date_event && $attendees) {
    // new event
    $event = new Event($attendees, $name_event, $date_event);

    // update database
    if ($eventController->edit($id, $event)) {
      echo "Evento aggiornato con successo";
      header("Location: ../user-page.php");
    } else {
      echo "Errore nell'aggiornamento dell'evento";
    }
  } else {
    echo "Dati del form non validi";
  }
} else {
  // update form
  if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id) {
      $event = $eventController->show($id);
      if ($event) {
        include  "../partials/nav.php";
?>
<!--  form -->
<form action="edit.php" method="POST">
  <input type="hidden" name="id" value="<?php echo htmlspecialchars($event['id']); ?>">
  <label for="name_event">Nome Evento:</label><br>
  <input type="text" id="name_event" name="name_event"
    value="<?php echo htmlspecialchars($event['nome_evento']); ?>"><br>
  <label for="date_event">Data Evento: <?php echo htmlspecialchars($event['data_evento']); ?></label><br>
  <input type="date" id="date_event" name="date_event"
    value="<?php echo htmlspecialchars($event['data_evento']); ?>"><br>
  <!-- <label for="attendees">Partecipanti:</label><br> -->
  <input type="hidden" id="attendees" name="attendees" value="<?php echo htmlspecialchars($event['attendees']); ?>"><br>
  <input type="submit" value="Aggiorna Evento">
</form>
<?php
include  "../partials/closing-tag.php";
      } else {
        echo "Evento non trovato";
      }
    } else {
      echo "ID evento non valido";
    }
  } else {
    echo "ID evento non fornito";
  }
}
?>
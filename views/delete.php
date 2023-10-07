<?php
include "../connection.php";
include "./models/Event.php";
include "../controllers/EventController.php";

// passo l'id evento tramite URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$eventController = new EventController($conn);

if (isset($_GET['id'])) {
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  if ($id) {
    if ($eventController->delete($id)) {
      echo "Evento eliminato con successo";

      header("Location: ../user-page.php");
    } else {
      echo "Errore nell'eliminazione dell'evento";
    }
  } else {
    echo "ID evento non valido";
  }
} else {
  echo "ID evento non fornito";
}

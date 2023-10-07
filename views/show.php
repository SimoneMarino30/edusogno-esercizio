<?php
// session_start();
include "../connection.php";
include "./models/Event.php";
include "../controllers/EventController.php";

$eventController = new EventController($conn);

// passo l'id evento tramite URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

var_dump($id);

if ($id) {
  $event = $eventController->show($id);
  if ($event) {
    include  "../partials/nav.php";
    echo '<section class="show-container">';
    echo '  <div class="show-card">';
    echo '    <h1>' . htmlspecialchars($event['nome_evento']) . '</h1>';
    echo '    <p>Data: ' . htmlspecialchars($event['data_evento']) . '</p>';
    echo '    <a href="../user-page.php">Back to your personal page</a>';
    echo '  </div>';
    echo '</section>';
  } else {
    echo "Evento non trovato";
  }
} else {
  echo "ID evento non fornito";
}

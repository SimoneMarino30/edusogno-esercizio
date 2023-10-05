<?php

// * PREPARO I PARAMETRI DI CONNESSIONE
const DB_SERVERNAME = "localhost";
const DB_PORT = "3306";
const DB_USERNAME = "root";
const DB_PASSWORD = "root";
const DB_NAME = "edusogno_db";

// * PROVO AD ESEGUIRE LA CONNESSIONE NEL TRY
try {
  $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
  echo "Connessione ok";
} catch (Exception $e) {
  // * SE INCONTRO UN ERRORE 

  // * PREPARO VARIABILE ERRORE DA STAMPARE
  $error = "Connessione fallita:<br>" . $e->getMessage();

  // * INCLUDO UNA PAGINA DI ERRORE CUSTOMIZZATA
  // include(__DIR__ . "/pages/error_page.php");

  // * INTERROMPO L'ESECUZIONE DEL CODICE
  exit;
}

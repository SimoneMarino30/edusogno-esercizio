<?php

// * prepare the connection params
const DB_SERVERNAME = "localhost";
const DB_PORT = "3306";
const DB_USERNAME = "root";
const DB_PASSWORD = "root";
const DB_NAME = "edusogno_db";

// * connection try
try {
  $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
  // echo "Connessione ok";
} catch (Exception $e) {

  // * if there's an error...
  $error = "Connessione fallita:<br>" . $e->getMessage();

  // * exit
  exit;
}

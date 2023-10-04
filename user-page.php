<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recupero i dati inviati dal modulo HTML


  // Eseguo la query per trovare l'utente con l'email fornita
  $sql = "SELECT * FROM utenti WHERE email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Utente trovato, verifica la password
    $row = $result->fetch_assoc();
    $storedPassword = $row["password"];

    // if (password_verify($password, $storedPassword)) {
    if ($password === $storedPassword) {
      session_start();
      // Password corretta, login riuscito
      $_SESSION["utente_loggato"] = true;
      $_SESSION['id'] = $row['id'];
      $_SESSION['email'] = $row['email'];

      // echo "Credenziali ok";
      // header("Location: user-page.php"); // Reindirizza l'utente alla pagina di accesso

    } else {
      // Password errata, login fallito
      header("Location: index.php"); // Reindirizza l'utente alla pagina di accesso
      echo "Credenziali errate. Riprova.";
    }
  } else {
    // Nessun utente trovato con questa email, login fallito
    header("Location: index.php"); // Reindirizza l'utente alla pagina di accesso
    echo "Credenziali errate. Riprova.";
  }
  // Chiudo la connessione al database
  $conn->close();
}

include __DIR__ . './partials/nav.php';

?>

<h1>Ciao <?php echo $_SESSION['email']; ?>, ecco i tuoi eventi </h1>
<a href="./logout.php">Logout</a>
<?php
// exit();
include __DIR__ . './partials/closing-tag.php'
?>
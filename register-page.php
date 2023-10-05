<?php
session_start();
include __DIR__ . '/partials/nav.php';
require_once __DIR__ . './connection.php';

$fnameErr = $lnameErr = $mailErr = $pswErr = "";
// Recupero i dati dal modulo HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if (empty($_POST['fname'])) {
    $fnameErr = "Name is required";
  } else {
    $first_name = test_input($_POST["fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$first_name)) {
      $fnameErr = "Only letters and white space allowed";
    }
  }
  
  if (empty($_POST['lname'])) {
    $lnameErr = "Name is required";
  } else {
    $last_name = test_input($_POST["lname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/",$last_name)) {
      $lnameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST['mail'])) {
    $emailErr = "Email is required";
  } else {
    $new_mail = test_input($_POST["mail"]);
    // check if e-mail address is well-formed
    if (!filter_var($new_mail, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
    
  if (empty($_POST["psw"])) {
    $pswErr = "Password is required";
  } else {
    $valid_password = validate_input($_POST["psw"]);
  }
  
  // Eseguo l'hash della password
  $hashed_psw = password_hash($valid_password, PASSWORD_BCRYPT);

  // if (empty($errors)) {
    // Eseguo l'inserimento dei dati nel database
    $sql_insert = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)";
    // Preparazione dello statement
    $stmt = $conn->prepare($sql_insert);
    // Bind dei parametri
    $stmt->bind_param('ssss', $first_name, $last_name, $new_mail, $hashed_psw);
    // Esecuzione dello statement
    $stmt->execute();
    $result = $stmt->get_result();
    header("Location: user-page.php");
    // Chiusura dello statement e della connessione
    $stmt->close();
    $mysqli->close();
    // Reindirizza l'utente alla pagina user-page.php
    // exit();
}
?>

<h1>Crea il tuo account</h1>
<div class="form-style">
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- GET ERROR -->
    <div class="row">
      <div class="col-25">
        <label for="fname">Inserisci il nome</label>

      </div>
      <div class="col-75">
        <input type="text" id="fname" name="fname" placeholder="Mario" required />
        <span class="error">* <?php echo $fnameErr;?></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="lname">Inserisci il cognome
        </label>
      </div>
      <div class="col-75">
        <input type="text" id="lname" name="lname" placeholder="Rossi" required />
        <span class="error">* <?php echo $lnameErr;?></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="email">Inserisci l' email
        </label>

      </div>
      <div class="col-75">
        <input type="text" id="mail" name="mail" placeholder="name@example.com" required />
        <span class="error">* <?php echo $emailErr;?></span>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="psw">Inserisci la password</label>

      </div>
      <div class="col-75">
        <input type="password" id="psw" name="psw" placeholder="Scrivila qui" required />
        <span class="error">* <?php echo $pswErr;?></span>
      </div>
      <!-- PSW eye-->
      <svg width="25" height="17" viewBox="0 0 25 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg-eye">
        <path
          d="M24.8489 7.69965C22.4952 3.1072 17.8355 0 12.5 0C7.16447 0 2.50345 3.10938 0.151018 7.70009C0.0517306 7.89649 0 8.11348 0 8.33355C0 8.55362 0.0517306 8.77061 0.151018 8.96701C2.50475 13.5595 7.16447 16.6667 12.5 16.6667C17.8355 16.6667 22.4965 13.5573 24.8489 8.96658C24.9482 8.77018 25 8.55319 25 8.33312C25 8.11304 24.9482 7.89605 24.8489 7.69965ZM12.5 14.5833C11.2638 14.5833 10.0555 14.2168 9.02766 13.53C7.99985 12.8433 7.19878 11.8671 6.72573 10.7251C6.25268 9.58307 6.12891 8.3264 6.37007 7.11402C6.61123 5.90164 7.20648 4.78799 8.08056 3.91392C8.95464 3.03984 10.0683 2.44458 11.2807 2.20343C12.493 1.96227 13.7497 2.08604 14.8917 2.55909C16.0338 3.03213 17.0099 3.83321 17.6967 4.86102C18.3834 5.88883 18.75 7.0972 18.75 8.33333C18.7504 9.15421 18.589 9.96711 18.275 10.7256C17.9611 11.484 17.5007 12.1732 16.9203 12.7536C16.3398 13.3341 15.6507 13.7944 14.8922 14.1084C14.1338 14.4223 13.3208 14.5837 12.5 14.5833ZM12.5 4.16667C12.1281 4.17186 11.7586 4.22719 11.4015 4.33116C11.6958 4.73119 11.8371 5.22347 11.7996 5.71873C11.7621 6.21398 11.5484 6.6794 11.1972 7.0306C10.846 7.38179 10.3806 7.5955 9.88537 7.63297C9.39012 7.67043 8.89784 7.52917 8.49781 7.23481C8.27001 8.07404 8.31113 8.96357 8.61538 9.77821C8.91962 10.5928 9.47167 11.2916 10.1938 11.776C10.916 12.2605 11.7719 12.5063 12.641 12.4788C13.5102 12.4514 14.3489 12.152 15.039 11.623C15.7291 11.0939 16.236 10.3617 16.4882 9.52951C16.7404 8.69729 16.7253 7.80693 16.445 6.98376C16.1647 6.16058 15.6333 5.44602 14.9256 4.94067C14.2179 4.43532 13.3696 4.16462 12.5 4.16667Z"
          fill="#0057FF" />
      </svg>
    </div>

    <br />
    <div class="row">
      <input type="submit" value="REGISTRATI" class="submit-button" />
    </div>
  </form>
  <div class="bottom-form-link">
    Hai già un account?
    <a href="./index.php">Accedi</a>
  </div>
</div>
<!-- error messages -->
<!-- <div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>8 characters</b></p>
</div> -->

<?php include __DIR__ . '/partials/closing-tag.php' ?>
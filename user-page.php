<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./connection.php";

if (isset($_SESSION["email"])) {

  $EventSql = "SELECT id, nome_evento, data_evento, attendees FROM eventi";
  $stmt = $conn->prepare($EventSql);
  $stmt->execute();
  $result = $stmt->get_result();
  include __DIR__ . '/partials/nav.php';
?>
  <h1>Ciao
    <?php echo $_SESSION["user-name"], str_repeat('&nbsp;', 1), $_SESSION["user-surname"]; ?>,
    ecco i tuoi eventi
  </h1>
  <div class="btn-event-container">
    <button class="add-event">
      <a href="./views/create.php">Aggiungi evento</a>
    </button>
    <!-- change password -->
    <button type="submit" class="event-btn">
      <a href="./edit-password.php">edit Password</a>
    </button>
    <!-- logout -->
    <button class="logout">
      <a href="./logout.php">
        <i class="fa-solid fa-user-gear"></i>
        Logout
      </a>
    </button>

  </div>


  <hr>

  <div class="events-container">
    <?php while ($row = $result->fetch_assoc()) : ?>
      <?php
      $event_name = $row["nome_evento"];
      $event_date = $row["data_evento"];
      $event_id = $row["id"];

      $attendees = explode(",", $row["attendees"]);
      foreach ($attendees as $email) :
        if ($email == $_SESSION["email"]) : ?>
          <div class=' event-card'>
            <h1><?php echo $event_name; ?></h1>
            <div class='event-date'><?php echo $event_date; ?></div>
            <div class='hidden'><?php echo $event_id; ?></div>
            <button class="event-btn">Join</button>
            <div class="crud-container">
              <button>
                <a href="./views/show.php?id=<?php echo $event_id; ?>">
                  <i class="fa-solid fa-eye"></i>
                  <span>Vedi</span>
                </a>
              </button>
              <button>
                <a href="./views/edit.php?id=<?php echo $event_id; ?>">
                  <i class="fa-solid fa-pen"></i>
                  <span>Edita</span>
                </a>
              </button>
              <button>
                <a href="./views/delete.php?id=<?php echo $event_id; ?>">
                  <i class="fa-solid fa-trash-can"></i>
                  <span>Cancella</span>
                </a>
              </button>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endwhile; ?>
  </div>



  <?php
  include __DIR__ . './partials/closing-tag.php';
  // exit();
} else {
  if (isset($_SESSION["register-mail"])) {
    include __DIR__ . '/partials/nav.php';
  ?>
    <h1>Ciao
      <?php echo $_SESSION["register-name"], str_repeat('&nbsp;', 1), $_SESSION["register-surname"]; ?>,
      non hai eventi registrati al momento
    </h1>
    <div class="btn-event-container">
      <button class="add-event">
        <a href="./views/create.php">Aggiungi evento</a>
      </button>
      <!-- change password -->
      <button type="submit" class="event-btn">
        <a href="./edit-password.php">edit Password</a>
      </button>
      <!-- logout -->
      <button class="logout">
        <a href="./logout.php">
          <i class="fa-solid fa-user-gear"></i>
          Logout
        </a>
      </button>

    </div>

    <hr>
    <!-- section events -->
    <section class="events">
      <div class="event-date"></div>
    </section>

  <?php
    include __DIR__ . './partials/closing-tag.php';
  }
  ?>
  <a href="./index.php">Home</a>
<?php
}

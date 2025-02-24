<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . ('/../functions/functions.php');
include __DIR__ . ('/../connection.php');

if (isset($_POST['changePasswordBtn'], $_POST['token'])) {
  if (validate_token($_POST['token'])) {
    //process the form
    //initialize an array to store any error message from the form
    $form_errors = array();

    //Form validation
    $required_fields = array('current_password', 'new_password', 'confirm_password');

    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //Fields that requires checking for minimum length
    $fields_to_check_length = array('new_password' => 8, 'confirm_password' => 8);

    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));
    // var_dump('--***********************--');
    // var_dump($form_errors);
    //check if error array is empty, if yes process form data
    if (empty($form_errors)) {
      if ($_POST['hidden_id'] == $_SESSION['user-id']) {
        $id = $_POST['hidden_id'];
        $current_password = $_POST['current_password'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        //check if new password and confirm password is same
        if ($password1 != $password2) {
          $result = flashMessage("New password and confirm password does not match");
        } else {
          // try {
          //process request-//check if the old password is correct
          $sqlSquery = "SELECT password FROM utenti WHERE id = ?";
          $statement = $conn->prepare($sqlSquery);
          $statement->bind_param('i', $id);

          $statement->execute();
          $result = $statement->get_result();
          //check if record is found
          if ($result->num_rows >= 1) {
            $row = $result->fetch_assoc();
            $password_from_db = $row['password'];

            if ($current_password == $password_from_db) {
              //hashed new password
              $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

              //SQL statement to update password
              $sqlUpdate = "UPDATE utenti SET `password` = ? WHERE `id` = ?";
              $statement = $conn->prepare($sqlUpdate);
              $statement->bind_param('si', $hashed_password, $id);

              $statement->execute();
              $result = $statement->get_result();
              if ($statement->affected_rows === 1) {
                // include __DIR__ . ('/nav.php');
                header(('Location: ../user-page.php'));
                $result = "<script type=\"text/javascript\">
                              swal({
                              title: \"Operation Successful!\",
                              text: \"You password was updated successfully.\",
                              type: 'success',
                              confirmButtonText: \"Thank You!\" });
                              </script>";
                // var_dump($_SESSION['user-id'] . "success");
                // session_destroy();
                exit();
              } else {
                var_dump($_SESSION['user-id'] . " primo if");
                $result = flashMessage("No changes saved");
              }
            } else {
              var_dump($_SESSION['user-id'] . " secondo if");
              $result = "<script type=\"text/javascript\">
                              swal({
                              title: \"OOPS!!\",
                              text: \"Old password is not correct, please try again\",
                              type: 'error',
                              confirmButtonText: \"Ok!\" });
                             </script>";
            }
          }
        }
      } else {
        if (count($form_errors) == 1) {
          $result = flashMessage("There was 1 error in the form<br>");
        } else {
          $result = flashMessage("There were " . count($form_errors) . " errors in the form <br>");
        }
      }
    } else {
      $result = "<script type='text/javascript'>
                    swal('Error','This request originates from an unknown source, posible attack'
                    ,'error');
                    </script>";
    }
  }
}

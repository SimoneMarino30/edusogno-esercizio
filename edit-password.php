<?php
session_start();
include __DIR__ . '/partials/parse_change-password.php';
include __DIR__ . '/partials/nav.php';

?>
<h3>Update Password</h3>
<hr>
<form method="POST" action="./partials/parse_change-password.php" class="form-style">
  <!-- current password -->
  <div class="form-group">
    <label for="currentpasswordField">Current Password</label>
    <input type="password" name="current_password" class="form-control" id="currentpasswordField"
      placeholder="Current Password">
  </div>
  <!-- new password -->
  <div class="form-group">
    <label for="newpasswordField">New Password</label>
    <input type="password" name="new_password" class="form-control" id="newpasswordField" placeholder="New Password">
  </div>
  <!-- confirm new password -->
  <div class="form-group">
    <label for="confirmpasswordField">Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control" id="confirmpasswordField"
      placeholder="Confirm New Password">
  </div>

  <input type="hidden" name="hidden_id" value="<?php if (isset($_SESSION['user-id'])) echo $_SESSION['user-id']; ?>">
  <input type="hidden" name="token" value="<?php if (function_exists('_token')) echo _token() ?>">
  <!-- edit button -->

  <button type="submit" name="changePasswordBtn" class="changePasswordBtn">
    <a href="./views/edit.php?id=<?php echo $event_id; ?>">
      <i class="fa-solid fa-pen"></i>
      <span>Edita</span>
    </a>
  </button>
  <!-- link back -->
  <button type="submit" name="changePasswordBtn" class="back-button">
    <a href="./user-page.php">
      <i class="fa-solid fa-arrow-left-long"></i>
      <span>Back</span>
    </a>
  </button>
</form>
<?php
// session_destroy();
// exit();
include __DIR__ . '/partials/closing-tag.php';
?>
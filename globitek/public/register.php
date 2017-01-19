<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if (is_post_request()) {
    $firstName = $lastName = $username = $email = "";

    $errors = [];
    $fields = [];
    if (is_blank($_POST['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($_POST['first_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } elseif(!has_valid_name_format($_POST['first_name'])) {
      $errors[] = "First name must only contain letters, spaces, symbols: - , . \'";
    } else {
      $firstName = h($_POST['first_name']);
    }
    $fields[] = $firstName;

    if (is_blank($_POST['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($_POST['last_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif(!has_valid_name_format($_POST['last_name'])) {
      $errors[] = "Last name must only contain letters, spaces, symbols: - , . \'";
    } else {
      $lastName = h($_POST['last_name']);
    }
    $fields[] = $lastName;

    if (is_blank($_POST['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($_POST['username'], ['min' => 8, 'max' => 255])) {
      $errors[] = "Username must be between 8 and 255 characters.";
    } elseif(!has_valid_username_format($_POST['username'])) {
      $errors[] = "Username must only contain letters, numbers, and underscores";
    } else {
      $username = h($_POST['username']);
    }
    $fields[] = $username;

    if (is_blank($_POST['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($_POST['email'])) {
      $errors[] = "Email must have a valid format and only contain letters, numbers, and symbols: _ @ .";
    } else {
      $email = h($_POST['email']);
    }
    $fields[] = $email;

    // if there were no errors, submit data to database
    if (all_fields_valid($fields)) {
      $date = date("Y-m-d H:i:s");
      // Write SQL INSERT statement
      $sql = "INSERT INTO users(first_name, last_name, username, email, created_at)
              VALUES ('$firstName', '$lastName', '$username', '$email', '$date');";

      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
        db_close($db);
        redirect_to("registration_success.php");

      } else {
          //The SQL INSERT statement failed.
        $error = db_error($db);
        echo "<script>alert(\"$error\");</script>";
        db_close($db);
        exit;
      }
    }      
  }

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    echo display_errors($errors);
  ?>

  <form action="<?php echo h($_SERVER["PHP_SELF"]);?>" method="POST">
    <p>
      First Name:<br>
      <input type="text" name="first_name" value="<?php echo h($_POST['first_name']); ?>">
    </p>
    <p>
      Last Name:<br>
      <input type="text" name="last_name" value="<?php echo h($_POST['last_name']); ?>">
    </p>
    <p>
      Userame:<br>
      <input type="text" name="username" value="<?php echo h($_POST['username']); ?>">
    </p>
    <p>
      Email:<br>
      <input type="text" name="email" value="<?php echo h($_POST['email']); ?>">
    </p>
    <p><input type="submit" name="submit"></p>
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

<?php

  // is_blank('abcd')
  function is_blank($value='') {
    return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) {
      return false;
    } elseif(isset($options['min']) && ($length < $options['min'])) {
      return false;
    } elseif(isset($options['exact']) && ($length != $options['exact'])) {
      return false;
    } else {
      return true;
    }
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) && preg_match('/\A[A-Za-z0-9@_\.]+\Z/', $value);
  }

  // has_valid_name_format('will-i-am')
  function has_valid_name_format($value) {
    return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
  }

  // has_valid_usernamename_format('will1234')
  function has_valid_username_format($value) {
    return preg_match('/\A[A-Za-z0-9_]+\Z/', $value);
  }

  function all_fields_valid($fields=array()) {
    foreach ($fields as $field) {
      if (empty($field)) {
        return false;
      }
    }
    return true;
  }

?>

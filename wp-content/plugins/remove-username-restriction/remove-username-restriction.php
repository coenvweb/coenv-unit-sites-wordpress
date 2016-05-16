<?php
/*
    Plugin Name: Username Char Limit
*/

function remove_username_char_limit($result) {  
  if ( is_wp_error( $result[ 'errors' ] ) && !empty( $result[ 'errors' ]->errors ) ) {

    // Get all the error messages from $result
    $messages = $result['errors']->get_error_messages();
    $i = 0;
    foreach ( $messages as $message ) {

      // Check if any message is the char limit message
      if ( 0 == strcasecmp("Username must be at least 4 characters.", $message)) {
        // Unset whole 'user_name' error array if only 1 message exists
        // and that message is the char limit error
        if ( 1 == count($messages) ) {
          unset( $result['errors']->errors['user_name'] );
        } else {
          // Otherwise just unset the char limit message
          unset( $result['errors']->errors['user_name'][$i] );
        }
      } 

      $i++;
    }
  }

  return $result;   
}
add_action('wpmu_validate_user_signup', 'remove_username_char_limit');
?>

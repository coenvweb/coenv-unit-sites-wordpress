<?php

/*
 * Utilities class for ACF Compare addon
 *
 * @copyright   Copyright (c) 2015, Nugget Solutions, Inc
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
   exit;
}

/**
 * Utilities class - singleton class
 *
 * @since 1.0
 */
class OW_ACF_Compare_Utility {

   /**
    * Private constructor so nobody else can instance it
    *
    */
   private function __construct() {
      // Do Nothing
   }

   /**
    * Get the singleton instance of the OW_Utility class
    *
    * @return singleton instance of OW_Utility
    */
   public static function instance() {

      static $instance = NULL;
      if ( is_null( $instance ) ) {
         $instance = new OW_ACF_Compare_Utility();
      }

      return $instance;
   }

   /**
    * Prints message (string or array) in the debug.log file
    * 
    * @param mixed $message
    */
   public function logger( $message ) {
      if ( WP_DEBUG === true ) {
         if ( is_array( $message ) || is_object( $message ) ) {
            error_log( print_r( $message, true ) );
         } else {
            error_log( $message );
         }
      }
   }

   /**
    * Show message on admin section relavant to plugin
    * 
    * @param array $data
    * @return string
    * 
    * @since 1.0 initial version
    */
   public function admin_notice( $data = array() ) {
      extract( $data ); // Extracts $message and $type from $data array
      switch ( $type ) {
         case 'error':
            $return = "<div id=\"message\" class=\"error\">\n";
            break;
         case 'update':
            $return = "<div id=\"message\" class=\"updated\">\n";
            break;
         default:
            $message = __( 'There\'s something wrong with your code...', 'owacfcompare' );
            $return = "<div id=\"message\" class=\"error\">\n";
            break;
      }

      $return .= "    <p>" . __( $message, 'owacfcompare' ) . "</p>\n";
      $return .= "</div>\n";
      return $return;
   }

}

?>
<?php

/*
 * Register new tab and its content for ACF Compare
 *
 * @copyright   Copyright (c) 2016, Nugget Solutions, Inc
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
   exit;
}

/**
 * @class OW_ACF_Compare_Revision
 * @since 1.0
 */
class OW_ACF_Compare_Revision {

   /**
    * Set things up.
    *
    * @since 1.0
    */
   public function __construct() {
      add_action( 'owf_display_revision_compare_tab', array( $this, 'compare_acf_fields' ), 10, 3 );
   }

   public function compare_acf_fields( $original_post_id, $revision_id, $ow_diff ) {
      $ow_acf_comparator = new OW_ACF_Comparator( $original_post_id, $revision_id, $ow_diff );
      echo '<h3>' . __( 'Custom Fields', 'owacfcompare' ) . '</h3>';
      echo $ow_acf_comparator->compare_acf_fields();
   }

}

return new OW_ACF_Compare_Revision();

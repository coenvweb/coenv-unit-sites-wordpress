<?php

/*
 * Comparator for different types of ACF fields
 *
 * @copyright   Copyright (c) 2015, Nugget Solutions, Inc
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
   exit;

/**
 *
 * OW_ACF_Comparator Class
 *
 * functions to compare ACF fields between original and revision posts
 * Following are not covered:
 * Password
 * Wysiwyg Editor
 * oEmbed
 * Taxonomy
 * Google Map
 * Date Picker
 * Color Picker
 * Message
 * Tab
 * Flexible Content
 *
 * @since 1.0
 */
class OW_ACF_Comparator {

   private $original_post_id;
   private $revision_post_id;
   private $comparator;
   private $basic_types_array = array( "text", "email", "textarea", "number", "url" );
   private $choice_types_array = array( "select", "checkbox", "radio", "true_false" );
   private $content_types_array = array( "image", "file", "gallery" );
   private $relational_types_array = array( "post_object", "page_link", "relationship" );

   public function __construct( $original_post_id, $revision_post_id, $comparator ) {
      $this->original_post_id = $original_post_id;
      $this->revision_post_id = $revision_post_id;
      $this->comparator = $comparator;
   }

   /**
    * Main Comparator function
    *
    * @return string differences between ACF fields
    *
    * @since 1.0
    */
   public function compare_acf_fields() {
      $original_fields = get_field_objects( $this->original_post_id );
      $revision_fields = get_field_objects( $this->revision_post_id );

      $acf_diff = '';
      if ( $original_fields ) {
         foreach ( $original_fields as $field_name => $original_field ) {
            $revision_field = $revision_fields[$original_field['name']];

            if ( in_array( $original_field['type'], $this->basic_types_array ) ) {
               $acf_diff .= $this->compare_basic_type( $original_field, $revision_field );
            }

            if ( $original_field['type'] == 'user' ) {
               $acf_diff .= $this->compare_user_type( $original_field, $revision_field );
            }

            if ( in_array( $original_field['type'], $this->choice_types_array ) ) {
               $acf_diff .= $this->compare_choice_field_type( $original_field, $revision_field );
            }

            if ( in_array( $original_field['type'], $this->content_types_array ) ) {
               $acf_diff .= $this->compare_content_field_type( $original_field, $revision_field );
            }

            if ( in_array( $original_field['type'], $this->relational_types_array ) ) {
               $acf_diff .= $this->compare_relational_field_type( $original_field, $revision_field );
            }

            if ( $original_field['type'] == 'repeater' ) {
               $acf_diff .= $this->compare_repeater_field_type( $original_field, $revision_field );
            }
         }
      }

      return $acf_diff;
   }

   private function compare_basic_type( $original_field, $revision_field ) {
      $original_field_data = $this->format_basic_type( $original_field['label'],
      		$original_field['value'] );
      $revision_field_data = $this->format_basic_type( $revision_field['label'],
      		$revision_field['value'] );

      $acf_field_diff = $this->comparator->compare( $original_field_data, $revision_field_data );
      return $this->comparator->to_table( $acf_field_diff );
   }

   /**
    * compare the values for the ACF relationship attribute - User type
    *
    * @param array $original_field
    * @param array $revision_field
    *
    * @return difference between the user object under the relationship attribute
    *
    * @since 1.0
    */
   private function compare_user_type( $original_field, $revision_field ) {
      $original_field_data = $this->format_basic_type( $original_field['label'],
      		$original_field['value']['display_name'] );

      $revision_field_data = $this->format_basic_type( $revision_field['label'],
      		$revision_field['value']['display_name'] );

      $acf_field_diff = $this->comparator->compare( $original_field_data, $revision_field_data );
      return $this->comparator->to_table( $acf_field_diff );
   }

   /**
    * compare the values for the ACF choice type
    *
    * @param array $original_field
    * @param array $revision_field
    *
    * @return difference between the selected choices
    *
    * @since 1.0
    */
   private function compare_choice_field_type( $original_field, $revision_field ) {
      $original_field_data = '';
      $revision_field_data = '';

      // get the available choices as defined in ACF
      // if label is true_false then we will not get choices
      $available_choices = isset( $original_field['choices'] ) ? $original_field['choices'] : FALSE;

      // get the selected values for the original article
      $original_field_data .= $this->format_choice_type( $original_field['label'],
      		$original_field['value'], $available_choices );

      // get the selected values for the revision article
      $revision_field_data = $this->format_choice_type( $revision_field['label'],
      		$revision_field['value'], $available_choices );

      $acf_field_diff = $this->comparator->compare( $original_field_data, $revision_field_data );
      return $this->comparator->to_table( $acf_field_diff );
   }

   /**
    * compare the values for the ACF content type
    *
    * @param array $original_field
    * @param array $revision_field
    *
    * @return difference between the selected choices
    *
    * @since 1.0
    */
   private function compare_content_field_type( $original_field, $revision_field ) {
      $original_field_data = '';
      $revision_field_data = '';

      // get the selected values for the original article
      $original_field_data .= $this->format_content_type( $original_field['label'],
      		$original_field['value'] );

      // get the selected values for the revision article
      $revision_field_data .= $this->format_content_type( $revision_field['label'],
      		$revision_field['value'] );

      $acf_field_diff = $this->comparator->compare( $original_field_data, $revision_field_data );
      return $this->comparator->to_table( $acf_field_diff );
   }

   /**
    * compare the values for the ACF relational type
    *
    * @param array $original_field
    * @param array $revision_field
    *
    * @return difference between the field data
    *
    * @since 1.0
    */
   private function compare_relational_field_type( $original_field, $revision_field ) {
      $original_field_data = '';
      $revision_field_data = '';

      // get the selected values for the original article
      $original_field_data .= $this->format_relational_post_type( $original_field['label'],
      		$original_field['value'] );

      // get the selected values for the revision article
      $revision_field_data .= $this->format_relational_post_type( $revision_field['label'],
      		$revision_field['value'] );

      $acf_field_diff = $this->comparator->compare( $original_field_data, $revision_field_data );
      return $this->comparator->to_table( $acf_field_diff );
   }

   /**
    * compare the values for the ACF repeater type
    *
    * @param array $original_field
    * @param array $revision_field
    *
    * @return difference between the repeater fields
    *
    * @since 1.0
    */
   private function compare_repeater_field_type( $original_field, $revision_field ) {
      $original_field_data = '';
      $revision_field_data = '';
      //OW_ACF_Compare_Utility::instance()->logger( $original_field );
      // original field repeater data
      $original_field_data .= $original_field['label'] . ' : ';
      foreach ( $original_field['sub_fields'] as $sub_field ) {
         $sub_field_type = $sub_field['type'];
         $sub_field_name = $sub_field['name'];

         foreach ( $original_field['value'] as $original_field_sub_field_data ) {
            $original_field_data .= "\n";
            $original_field_data .= "\t";

            if ( in_array( $sub_field_type, $this->basic_types_array ) ) {
               $original_field_data .= $this->format_basic_type( $sub_field['label'],
               		$original_field_sub_field_data[$sub_field_name] );
            }

            if ( $sub_field_type == 'user' ) {
               $original_value = isset( $original_field_sub_field_data[$sub_field_name]['display_name'] ) ? $original_field_sub_field_data[$sub_field_name]['display_name'] : '';
               $original_field_data .= $this->format_basic_type( $sub_field['label'],
                       $original_value );
            }

            if ( in_array( $sub_field_type, $this->choice_types_array ) ) {
               // get the selected values for the original article
               $original_field_data .= $this->format_choice_type( $sub_field['label'],
               		$original_field_sub_field_data[$sub_field_name], $sub_field['choices'] );
            }

            if ( in_array( $sub_field_type, $this->content_types_array ) ) {
            	// get the selected values for the original article

            	$original_field_data .= $this->format_content_type( $sub_field['label'],
            			$original_field_sub_field_data[$sub_field_name] );
            }

            if ( in_array( $sub_field_type, $this->relational_types_array ) ) {
            	// get the selected values for the original article
            	$original_field_data .= $this->format_relational_post_type( $sub_field['label'],
            			$original_field_sub_field_data[$sub_field_name] );
            }
         }
      }

      // revision field repeater data
      $revision_field_data .= $revision_field['label'] . ' : ';
      foreach ( $revision_field['sub_fields'] as $sub_field ) {
         $sub_field_type = $sub_field['type'];
         $sub_field_name = $sub_field['name'];

         foreach ( $revision_field['value'] as $revision_field_sub_field_data ) {
            $revision_field_data .= "\n";
            $revision_field_data .= "\t";

            if ( in_array( $sub_field_type, $this->basic_types_array ) ) {
               $revision_field_data .= $this->format_basic_type( $sub_field['label'],
               		$revision_field_sub_field_data[$sub_field_name] );
            }

            if ( $sub_field_type == 'user' ) {
               $revision_value = isset($revision_field_sub_field_data[$sub_field_name]['display_name']) ? $revision_field_sub_field_data[$sub_field_name]['display_name'] : '';
               $revision_field_data .= $this->format_basic_type( $sub_field['label'],
                       $revision_value );
            }

            if ( in_array( $sub_field_type, $this->choice_types_array ) ) {
               // get the selected values for the original article
               $revision_field_data .= $this->format_choice_type( $sub_field['label'],
               		$revision_field_sub_field_data[$sub_field_name], $sub_field['choices'] );
            }

            if ( in_array( $sub_field_type, $this->content_types_array ) ) {
            	// get the selected values for the revision article
            	$revision_field_data .= $this->format_content_type( $sub_field['label'],
            			$revision_field_sub_field_data[$sub_field_name] );
            }

            if ( in_array( $sub_field_type, $this->relational_types_array ) ) {
            	// get the selected values for the revision article
            	$revision_field_data .= $this->format_relational_post_type( $sub_field['label'],
            			$revision_field_sub_field_data[$sub_field_name]  );
            }
         }
      }

      $acf_field_diff = $this->comparator->compare( $original_field_data, $revision_field_data );
      return $this->comparator->to_table( $acf_field_diff );
   }

   /**
    * Formats a basic type for display purposes
    *
    * @param string $label
    * @param string $value
    *
    * @return formatted string for the given label and value
    *
    * @since 1.0
    */
   private function format_basic_type( $label, $value ) {
      $field_data = '';

      $field_data .= $label . ' : ';
      $field_data .= $value;

      return $field_data;
   }

   /**
    * Formats a choice type for display purposes
    *
    * @param string $label
    * @param array $selected_values
    * @param array $available_choices
    *
    * @return formatted string for the given choice type
    *
    * @since 1.0
    */
   private function format_choice_type( $label, $selected_values, $available_choices ) {
      $field_data_array = array();

      // get the selected values for the original article
      if ( is_array( $selected_values ) ) {
         foreach ( $selected_values as $selected_value ) {
            $field_data_array[] = $available_choices[$selected_value];
         }
      } elseif ( $available_choices === FALSE ) { // $label = true_false
         $field_data_array[] = $selected_values;
      } else { // looks like the selected value is a single value
         // lets check $selected value is empty or exist in $available_choices
         $field_data_array[] = isset($available_choices[$selected_values]) ? $available_choices[$selected_values] : $selected_values;
      }

      $field_data = $label . ' : ' . implode( " | ", $field_data_array );

      return $field_data;
   }

   /**
    * Formats a content type for display purposes
    *
    * @param string $label
    * @param array/string $contents
    *
    * @return formatted string for the given label and contents
    *
    * @since 1.0
    */
   private function format_content_type( $label, $contents ) {
      $field_data = array();

      if ( is_array( $contents ) ) {
      	if ( array_key_exists( 'url', $contents ) ) {
         	$field_data[] = $contents['url'];
      	} else { // looks like to containing element is also an array
      		$i = 1;
      		foreach( $contents as $content) {
      			$field_data[] = $content['url'];
      			$i++;
      		}
      	}
      } else {
         $field_data[] = $contents;
      }

      $field_data = $label . ' : ' . implode( " | ", $field_data );
      return $field_data;
   }

   /**
    * Formats a relational type for display purposes
    *
    * @param string $label
    * @param object $post_object
    *
    * @return formatted string for the given label and post
    *
    * @since 1.0
    */
   private function format_relational_post_type( $label, $post_object ) {

      $field_data_array = array();

      if ( is_array( $post_object ) ) { // relationship
         foreach ( $post_object as $post ) {
            $field_data_array[] = $post->post_title;
         }
      } else if ( is_object( $post_object ) ) { // post_object
         $field_data_array[] = $post_object->post_title;
      } else { // page link
         $field_data_array[] = $post_object;
      }

      $field_data = $label . ' : ' . implode( " | ", $field_data_array );

      return $field_data;
   }

}

?>
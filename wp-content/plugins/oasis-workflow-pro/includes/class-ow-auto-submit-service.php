<?php

/*
 * Service class for the Auto Submit
 *
 * @copyright   Copyright (c) 2015, Nugget Solutions, Inc
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.2
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
   exit;

/*
 * OW_Auto_Submit_Service Class
 *
 * @since 4.2
 */
class OW_Auto_Submit_Service {

	/*
	 * Set things up.
	 *
	 * @since 4.2
	 */
	public function __construct() {
		// auto submit articles
      add_action( 'oasiswf_auto_submit_schedule', array( $this, 'auto_submit_articles' ) );
	}

   /**
    * Hook - oasiswf_auto_submit_schedule
    * Auto submit articles to the workflow - invoked via cron
    *
    * Checks for the auto submit settings, looks up the workflows allowed for auto submit
    * Submits any unsubmitted articles into the workflow
    *
    * @return int count of submitted items
    *
    * @since 2.0
    * @since 3.3 ignore "enable auto submit" if the request comes from "trigger auto submit once"
    */
   public function auto_submit_articles($ignore_enable_auto_submit = FALSE) {
      global $wpdb;
      
      $auto_submit_settings = get_option( 'oasiswf_auto_submit_settings' );
      
      /**
       * Do not check whether enable auto-submit is on/off when the request comes from
       * Trigger auto-submit just once
       * Set the administrator as user for the duration of the cron job.
       */
      if ( ! $ignore_enable_auto_submit ) {
         // if auto submit is activated then proceed
         if ( $auto_submit_settings['auto_submit_enable'] == "active" ) {
            $this->set_cron_job_user();
         } else {
            // nothing to submit, since auto submit is not enabled
            return 0;
         }
      }

      // if at least one status is specified then proceed
      $auto_submit_stati = $auto_submit_settings['auto_submit_stati'];
      if ( count( $auto_submit_stati ) == 0 ) {
         //nothing to submit, since no post statuses specified.
         return 0;
      }
      $ow_process_flow = new OW_Process_Flow();
      $ow_workflow_service = new OW_Workflow_Service();
      $workflows = $ow_workflow_service->get_workflow_by_auto_submit( 1 );

      foreach ( $auto_submit_stati as $key => $status ) { // convert to a MySQL In list ('value1', 'value2')
         $auto_submit_stati[$key] = "'" . esc_sql( $status ) . "'";
      }
      $auto_submit_stati_list = join( ",", $auto_submit_stati );
      $auto_submit_post_count = ($auto_submit_settings['auto_submit_post_count'] != null) ? $auto_submit_settings['auto_submit_post_count'] : "5";
      $auto_submit_due_days = ($auto_submit_settings['auto_submit_due_days'] != null) ? $auto_submit_settings['auto_submit_due_days'] : "1";
      $auto_submit_comments = $auto_submit_settings['auto_submit_comment'];

      // get all posts which satisfy the criteria
      $unsubmitted_posts = $this->get_unsubmitted_posts( $auto_submit_stati_list, $auto_submit_post_count );
      OW_Utility::instance()->logger( "Number of unsubmitted posts/pages:" . count( $unsubmitted_posts ) );
      $submitted_posts_count = 0;

      OW_Utility::instance()->logger( "current site:" . $GLOBALS['blog_id'] );
      foreach ( $workflows as $wf ) {
         OW_Utility::instance()->logger( "current workflow: " . $wf->name );
         $keyword_array = @unserialize( $wf->auto_submit_keywords );
         $auto_submit_info = @unserialize( $wf->auto_submit_info );
         // get auto submit keywords
         if ( array_key_exists( 'keywords', $auto_submit_info ) ) {
            $keyword_array = $auto_submit_info['keywords'];
         }
         if ( $keyword_array === false ) { // no keywords defined
            continue;
         }
         $auto_submit_keywords = explode( ",", implode( ',', $keyword_array ) );
         OW_Utility::instance()->logger( "keywords:" . implode( ',', $keyword_array ) );

         // get auto submit team for the current site
         $selected_teams_array = array();
         $applicable_team = null;
         if ( array_key_exists( 'teams', $auto_submit_info ) ) {
            $selected_teams_array = $auto_submit_info['teams'];
         }
         foreach ( $selected_teams_array as $site_team ) {
            $site_team_array = explode( '@', $site_team );
            if ( $site_team_array[0] == $GLOBALS['blog_id'] ) {
               $applicable_team = $site_team_array[1];
            }
         }
         if ( count( $unsubmitted_posts ) <= 0 ) {
            continue;
         }

         $workflow_applicable_to = @unserialize( $wf->wf_additional_info );
         $revised_post = $new_post = '';
         if ( is_array( $workflow_applicable_to ) && ! empty( $workflow_applicable_to ) ) {
            $revised_post = $workflow_applicable_to['wf_for_revised_posts'];
            $new_post = $workflow_applicable_to['wf_for_new_posts'];
         }

         foreach ( $unsubmitted_posts as $i => $row ) {

            if ( ($auto_submit_settings['search_post_title'] == 'yes' && OW_Utility::instance()->str_array_pos( $row->post_title, $auto_submit_keywords )) ||
                 ($auto_submit_settings['search_post_tags'] == 'yes' && OW_Utility::instance()->is_post_tag_in_array( $row->ID, $auto_submit_keywords )) ||
                 ($auto_submit_settings['search_post_categories'] == 'yes' && OW_Utility::instance()->is_post_category_in_array( $row->ID, $auto_submit_keywords )) ) {

               /**
                * If revised post is set and new post is not set then check post meta oasis_original exist or not
                * if not exist then its a new post/page
                */
               if ( $new_post == 0 && $revised_post == 1 && ! get_post_meta( $row->ID, '_oasis_original', TRUE ) ) {
                  continue;
               }

               /**
                * If new post is set but not revised post then check post meta oasis_original exist or not
                * If exist then its revised post/page
                */
               if ( $revised_post == 0 && $new_post == 1 && get_post_meta( $row->ID, '_oasis_original', TRUE ) ) {
                  continue;
               }

               // submit the post to workflow
               $steps = $ow_workflow_service->get_first_step_internal( $wf->ID );
               $step = $ow_workflow_service->get_step_by_id( $steps["first"][0][0] );
               if ( defined( 'OWFTEAMS_VERSION' ) && get_option( 'oasiswf_team_enable' ) == 'yes' ) {
                  $ow_teams_service = new OW_Teams_Service();
                  $step_info = json_decode( $step->step_info );
                  $assignee_roles = isset( $step_info->task_assignee->roles ) ? array_flip( $step_info->task_assignee->roles ) : null;

                  $actors = $ow_teams_service->get_team_members( $applicable_team, $assignee_roles, $row->ID );
                  $actors = implode( "@", $actors );
                  OW_Utility::instance()->logger( "applicable team:" . $applicable_team );
                  OW_Utility::instance()->logger( "users for auto submit from the team:" . $actors );
               } else {
                  $users = $ow_process_flow->get_users_in_step( $steps["first"][0][0], $row->ID );
                  if ( ! isset( $users["users"] ) ) { // we didn't find any users for the step
                     OW_Utility::instance()->logger( "We didn't find any users for this step, skipping this post:" . $row->ID);
                     continue;
                  }
                  $actors = "";
                  foreach ( $users["users"] as $user ) {
                     if ( $actors != "" ) {
                        $actors .= "@";
                     }
                     $actors .= $user->ID;
                  }
                  OW_Utility::instance()->logger( "users for auto submit:" . $actors );
               }

               $due_date = OW_Utility::instance()->get_pre_next_date( date( "m/d/Y" ), "next", $auto_submit_due_days );
               if ( $actors != "" ) {
                  $workflow_submit_data = array();
                  $workflow_submit_data['step_id'] = $steps["first"][0][0];
                  $workflow_submit_data['actors'] = $actors;
                  $workflow_submit_data['due_date'] = OW_Utility::instance()->format_date_for_display_and_edit( $due_date );
                  $workflow_submit_data['comments'] = $auto_submit_comments;
                  $workflow_submit_data['team_id'] = $applicable_team;
                  $workflow_submit_data['pre_publish_checklist'] = "";
                  $ow_process_flow->submit_post_to_workflow_internal( $row->ID, $workflow_submit_data );
                  // Lets update the post status when after submit post to workflow
                  if ( $step && $workflow = $ow_workflow_service->get_workflow_by_id( $step->workflow_id ) ) {
                     $wf_info = json_decode( $workflow->wf_info );
                        if ( $wf_info->first_step && count( $wf_info->first_step ) == 1 ) {
                           $first_step = $wf_info->first_step[0];
                           if ( is_object( $first_step ) &&
                              isset( $first_step->post_status ) &&
                              ! empty( $first_step->post_status ) ) {
                                 wp_update_post( array(
                                    'ID'          => $row->ID,
                                    'post_status' => $first_step->post_status
                                 ) );
                              }
                        }
                  }

                  // increment the count of successfully submitted posts
                  $submitted_posts_count ++;

                  // remove the post from the list of unsubmitted posts
                  unset( $unsubmitted_posts[$i] );
               }
            }
         }
      }

      return $submitted_posts_count;
   }

   /*
    * Get all unsubmitted posts
    *
    * @param $post_status_list
    * @param $post_count
    *
    * @return array|null|object
    */
   private function get_unsubmitted_posts( $post_status_list, $post_count ) {
      global $wpdb;

      $post_count = intval( sanitize_text_field( $post_count ) );

      $all_unsubmitted_posts = array();
      $post_type_condition = "";
      $show_workflow_for_post_types = get_option( 'oasiswf_show_wfsettings_on_post_types' );
      if ( is_array( $show_workflow_for_post_types ) ) {
         $show_workflow_for_post_types_list = "'" . implode( "', '", $show_workflow_for_post_types ) . "'";
         $post_type_condition = " posts.post_type in (" . $show_workflow_for_post_types_list . ") AND ";
      }

      $all_unsubmitted_posts = $wpdb->get_results( "SELECT distinct posts.ID, posts.post_title FROM {$wpdb->prefix}posts posts
		WHERE posts.post_status in (" . $post_status_list . ")
	   	AND " .
                                                   $post_type_condition .
                                                   "(NOT EXISTS (SELECT * from {$wpdb->prefix}postmeta postmeta1 WHERE postmeta1.meta_key = '_oasis_is_in_workflow' and posts.ID = postmeta1.post_id) OR
		   	EXISTS (SELECT * from {$wpdb->prefix}postmeta postmeta2 WHERE postmeta2.meta_key = '_oasis_is_in_workflow' AND postmeta2.meta_value = '0' and posts.ID = postmeta2.post_id))
		   	order by post_modified_gmt
		   	limit 0, " . $post_count );

      return $all_unsubmitted_posts;
   }

   /**
    * Set the administrator as user for the duration of the cron job.
    * @since 4.4
    */
   private function set_cron_job_user() {
      // If we're not doing cron, bail out.
      if ( ! defined( 'DOING_CRON' ) || ! DOING_CRON ) {
         return;
      }
      $args = array( 'role' => 'Administrator', 'number' => 1 );
      $oasis_user = get_users( $args );
      if ( in_array( 'administrator', $oasis_user[0]->roles ) ) {
         // Set the user for the duration of the cron job.
         wp_set_current_user( $oasis_user[0]->ID );
      }
   }

}
// construct an instance so that the actions get loaded
$ow_auto_submit_service = new OW_Auto_Submit_Service();
?>
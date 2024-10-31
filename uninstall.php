<?php

// if uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
  exit();

// Attempt to remove all simple_business_data from the database
// Execute function
if( function_exists( 'Remove_Responsive_Subheader' ) )
  Remove_Responsive_Subheader();

function Remove_Responsive_Subheader()
{
  global $wpdb;

  // Array of all option names added to the database by this plugin
 $rs_options = array(
   'rs_overlay_img',
   'rs_subheader_bg_color'
 );

  // Loop through the options and delete from the database the options created by
  // this plugin
  if( !empty( $rs_options ) )
  {
    foreach( $rs_options as $rs_option )
      delete_option( $rs_option );
  }

  // get IDs of posts associated with Responsive Subheader
  try
  {
    $iIds = $wpdb->get_results(
      "
        SELECT
          ID
        FROM
          $wpdb->posts
        WHERE
          post_type = 'responsive_subheader'
      ",
      ARRAY_A
    );
  }
  catch (Exception $e) {}

  // Check that we have an array returned from the query
  if( isset( $iIds ) && count( $iIds, COUNT_RECURSIVE) )
  {
    $aPostIds = array();
    // Create the ids array into a string
    foreach( $iIds as $iId )
      $aPostIds[] = $iId['ID'];

    if( count( $aPostIds ) ) // Makes sure there is at least one digit and a comma
    {
      // Run the prepared delete query for each table in the array
      foreach($aPostIds as $iPostId)
      {
        try
        {
          $wpdb->delete( $wpdb->postmeta, array( 'post_id' => $iPostId ) );
          $wpdb->delete( $wpdb->posts, array( 'ID' => $iPostId ) );
        }
        catch (Exception $e) {}
      }

    }
  }
}

<?php
/**
 * GDPR compliance functions
 *
 *
 */


// Prevent YouTube Cookies

function youtube_nocookie( $data, $url, $args ){
  
  $data = str_replace( 'www.youtube.com', 'www.youtube-nocookie.com', $data );
  
  return $data;
  
}
 add_filter( 'oembed_result', 'youtube_nocookie', 10, 3 );
 
 
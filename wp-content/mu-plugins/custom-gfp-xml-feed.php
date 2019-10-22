<?php
/*
   Plugin Name: Custom GFP XML Feed
   Version: 1.0.0
   Author: Daniel Bell
   Description: XML Feed of all products.
   License: GPLv3
*/

defined( 'ABSPATH' ) or die( 'No direct access!' );

// Register the endpoint
function jsforwp_create_xml_feed() {
  register_rest_route( 'gfpfeed/v1', '/products', [
    'methods' => 'GET',
    'callback' => 'jsforwp_xml_feed',
  ] );
}
add_action( 'rest_api_init', 'jsforwp_create_xml_feed' );

// Get simple posts
function jsforwp_xml_feed( $data ) {

  header('Content-Type: application/xml; charset=utf-8');
    $xml = new DOMDocument();
    $xml->formatOutput = true;
    $xml->preserveWhiteSpace = false;
    $xml->encoding = 'utf-8';
    $root = $xml->appendChild( $xml->createElement('calendario') );
    $news = new WP_Query(array(
      'posts_per_page' => 30,
      'orderby' => 'date',
      'order' => 'DESC',
      'tax_query' => array(
        array( 'taxonomy' => 'post_tag', 'terms' => array('alumnos-ccp', 'alumnos-scl', 'exalumnos', 'investigacion-2', 'newsletters'), 'field' => 'slug', 'operator' => 'NOT IN' )
      )
    ));
    if ( $news->have_posts() ) {
      global $post;
      add_filter('the_content_feed', array($this, 'theContentFilter'));
      while ( $news->have_posts() ) {
        $news->the_post();
        $entry = $root->appendChild( $xml->createElement('noticia') );
        $entry->appendChild( $this->createTextElement($xml, 'titulo', $this->sanitizeText( $post->post_title) ) );
        $entry->appendchild( $xml->createElement('fecha', $post->post_date) );
        $entry->appendChild( $xml->createElement('fotochica', $this->getThumbUrl('mobile-small') ) );
        $entry->appendChild( $xml->createElement('fotogrande', $this->getThumbUrl('mobile-normal') ) );
        $entry->appendChild( $this->createTextElement($xml, 'resumen', $this->sanitizeText( get_the_excerpt() ) ) );
        $entry->appendChild( $this->createTextElement($xml, 'texto', get_the_content_feed()) );
      }
    }
    echo $xml->saveXML();
    exit;

}
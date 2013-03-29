<?php
/*
Plugin Name: Wordpress Vine
Plugin URI: http://github.com/thenextweb/wordpress-vine
Description: Embed Vines into your Wordpress posts and pages
Author: Sam Wierema (The Next Web)
Version: 1.0.0
*/

add_action('the_content', 'render_vine_embeds');

function render_vine_embeds($content) {

  return preg_replace_callback('/\[vine[\w\s=]*\]/i', function($match) {
    if (empty($match[0])) {
      return '';
    }
    if (preg_match('/id=(\w+)/i', $match[0], $id_match) !== 1) {
      return '';
    }
    if (empty($id_match[1])) {
      return '';
    }
    $vine_id = $id_match[1];
    $vine_type = preg_match('/postcard/i', $match[0]) === 1 ? 'postcard' : 'simple';
    $vine_dimension = preg_match('/width=(600|480|320)/i', $match[0], $width_match) === 1 ? $width_match[1] : 480;
    return '<iframe class="vine-embed" src="https://vine.co/v/'. $vine_id .'/embed/'. $vine_type .'" width="'. $vine_dimension .'" height="'. $vine_dimension .'" frameborder="0"></iframe> <script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>';
  }, $content);

}
<?php
/**
 * Plugin Name: HTTP Cache-Control
 * Version: 0.1.0-alpha
 * Description: Specifies sensible HTTP  headers for all pages, including `/wp-admin`!
 * Author: nickbreennz
 * Author URI: https://www.foobar.net.nz
 * Plugin URI: https://github.com/nickbreen/wordpress-plugin-http-cache-control
 * Text Domain: wordpress-plugin-http-cache-control
 * Domain Path: /languages
 * @package HTTP Cache-Control
 */

const CACHE_CONTROL = 'Cache-Control';

$forbidden_headers = array_flip(explode(',', get_option('forbidden_headers', 'Pragma')));

$del_cache_controls = explode(',', get_option('del_cache_controls', 'no-cache,no-store'));

$add_cache_controls = explode(',', get_option('add_cache_controls', 'stale-while-revalidate=86400,stale-if-error=86400'));

$opt_cache_controls = json_decode(get_option('opt_cache_controls', json_encode(array(
  '/^max-age=(\d+)$/' => 's-maxage=$1',
  '/^must-revalidate$/' => 'proxy-revalidate',
))));

$old = error_reporting(E_USER_WARNING);

/**
 * Filter the cache-controlling headers.
 */
add_filter('nocache_headers', function ($headers) use ($del_cache_controls, $add_cache_controls, $opt_cache_controls, $forbidden_headers) {
  $cache_controls = explode(', ', $headers[CACHE_CONTROL]);
  $s_cache_controls = $cache_controls;
  foreach ($opt_cache_controls as $regex => $repl) {
    $s_cache_controls = preg_replace($regex, $repl, $s_cache_controls);
  }

  $cache_controls = array_unique(array_merge($s_cache_controls, $add_cache_controls, $cache_controls));
  $headers[CACHE_CONTROL] = implode(', ', array_diff($cache_controls, $del_cache_controls));

  $headers = array_diff_key($headers, $forbidden_headers);
  return $headers;
});

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/
// $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
// $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
// $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']); 

/*
|--------------------------------------------------------------------------
| Google Auth Settings
|--------------------------------------------------------------------------
*/
$config['google_client_id'] = '204845662863-isdq6cfqmgpra7e045bvoen9b5ih4j1b.apps.googleusercontent.com';
$config['google_client_secret'] = 'QIw0jkICmIuPJu-jtwU0OWwu';
$config['google_redirect_url'] = 'auth/login/google';
$config['google_api_key'] = 'AIzaSyAuXkxW5naZD50S0h6NyanAj2wV7o6NV0U';

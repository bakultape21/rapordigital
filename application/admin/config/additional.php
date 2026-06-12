<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['favicon']       = '';
$config['title']         = 'eRapor';
$config['brand_logo']    = '';
$config['brand_text']    = 'eRapor';
$config['cookie_name']   = 'CookieEraporV1';
$config['session_name']  = 'ERaporV1';
$config['bypass']        = array('Home');
$config['menu']          = 'database'; // database or hardcode, default use database

$config['url_api']      = "";

$protocol               = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$config['base_url']     = $protocol . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

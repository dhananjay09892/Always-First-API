<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.alwaysfirst.in', 
    'smtp_port' => 587,
    'smtp_user' => 'news@alwaysfirst.in',
    'smtp_pass' => '@alwaysfirst.in',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);
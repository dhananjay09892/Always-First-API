<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.alwaysfirst.in',
    'smtp_port' => 587,
    'smtp_user' => '', // Username
    'smtp_pass' => '', // Password
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);

// $config = array(
//     'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
//     'smtp_host' => 'mail.eleganzit.online', 
//     'smtp_port' => 465,
//     'smtp_user' => 'emailwebsite@eleganzit.online',
//     'smtp_pass' => 'eleganz@1213#',
//     'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'charset' => 'iso-8859-1',
//     'wordwrap' => TRUE
// );

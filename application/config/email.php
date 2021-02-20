<?php

defined('BASEPATH') OR exit('Ação não permitida');


/*
*  Verificar o arquivi php.ini do xamp se a extenção php_openssl está descomentada
*/


/*
* Habilitar na sua conta o acesso de aplicativos menos seguros
*/

$config = array();
$config['protocol'] = 'smtp';
$config ['smtp_host'] = 'ssl://smtp.gmail.com';
$config ['smtp_port'] = '465';
$config ['smtp_user'] = 'lojasc@gmail.com';
$config ['smtp_pass'] = 'hacker080677';
$config ['mailtype_'] = 'text';
$config ['newline'] = "\r\n"; // sem essa linha não funciona
 ?>
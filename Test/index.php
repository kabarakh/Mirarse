<?php 
include('../Gallery.php');

$gallery->callAction('list', array('directory' => '/var/www/'), 'Gallery');

?>

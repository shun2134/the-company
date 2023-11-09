<?php
include "../classes/User.php";

$user = new User;

/* post by form  store($request) in User.php / save the post */
$user->store($_POST);

?>
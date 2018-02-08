<?php
require_once("classes/users.class.php");
$users = new users();

$arrUsers = $users->getUserData();
print_r($arrUsers);

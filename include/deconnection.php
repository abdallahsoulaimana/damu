<?php
session_start();
include('connexion.php');
$login = $_SESSION['login'];
// $delete = $db->query("DELETE FROM enligne WHERE user_login = '$login'");
session_unset();
session_destroy();
header('Location: ../index.php');

?>
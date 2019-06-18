<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['nicname']);
// unset($_SESSION['root']);
// unset($_SESSION['is_party']);
// unset($_SESSION['post']);
// unset($_SESSION['admit']);
header('location:/');

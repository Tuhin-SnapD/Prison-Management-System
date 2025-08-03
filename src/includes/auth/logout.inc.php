<?php
// Session is already started in index.php
session_unset();
session_destroy();

$type = isset($_GET['type']) ? $_GET['type'] : '';

switch($type) {
    case 'admin':
        header("Location: ?page=signin-admin");
        break;
    case 'officer':
        header("Location: ?page=signin-officer");
        break;
    case 'jailor':
        header("Location: ?page=signin-jailor");
        break;
    default:
        header("Location: ?page=home");
        break;
}
exit();
?>
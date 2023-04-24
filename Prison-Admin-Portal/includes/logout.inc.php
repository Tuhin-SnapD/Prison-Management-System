<?php
session_start();
session_unset();
session_destroy();
if($_GET['logout']=="admin"){
    header("Location: ../signin-admin.php");
}
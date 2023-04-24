<?php
session_start();
session_unset();
session_destroy();
if($_GET['logout']=="officer"){
    header("Location: ../signin-officer.php");
}elseif($_GET['logout']=="jailor"){
    header("Location: ../signin-jailor.php");

}
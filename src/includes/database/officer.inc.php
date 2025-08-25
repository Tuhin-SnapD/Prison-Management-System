<?php

if (isset($_POST['officer_add'])) {
    require 'dbh.inc.php';

    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $dob = $_POST['dob'];
    $title = $_POST['title'];
    $mob_number = $_POST['mob_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cfmpassword = $_POST['cfmpassword'];

    if (empty($f_name) || empty($l_name) || empty($dob) || empty($title) || empty($mob_number) || empty($username) || empty($password) || empty($cfmpassword)) {
        header("Location: ../../public/?page=officer&error=emptyfields");
        exit();
    }
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../../public/?page=officer&error=invaliduid&uid=" . $username);
        exit();
    }
    if ($password !== $cfmpassword) {
        header("Location: ../../public/?page=officer&error=passwordnotmatched&uid=" . $username);
        exit();
    }

    $sql = "SELECT Officer_uname FROM Officer WHERE Officer_uname = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    if ($stmt->rowCount() > 0) {
        header("Location: ../../public/?page=officer&error=sameuserexistserror");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql1 = "INSERT INTO Officer (Officer_uname, Officer_pwd, First_name, Last_name, Title, Date_of_birth) VALUES (:username, :password, :f_name, :l_name, :title, :dob)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([
        'username' => $username,
        'password' => $hashed_password,
        'f_name' => $f_name,
        'l_name' => $l_name,
        'title' => $title,
        'dob' => $dob
    ]);

    $officer_id = $pdo->lastInsertId();

    $sql2 = "INSERT INTO Officer_phone(Officer_phone, Officer_id) VALUES (:mob_number, :officer_id)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(['mob_number' => $mob_number, 'officer_id' => $officer_id]);

    header("Location: ../../public/?page=successofficer&insert=success");
    exit();
} else {
    header("Location: ../../public/?page=officer&error=clickonsignupbtnerror");
    exit();
}

<?php

if (isset($_POST['crime_prisoner_add'])) {
    require 'dbh.inc.php';

    $IPC = $_POST['IPC'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];
    $dob = $_POST['dob'];
    $height = $_POST['height'];
    $addr = $_POST['addr'];
    $section_id = $_POST['section_id'];
    $status_inout = 'in';

    if (empty($IPC) || empty($f_name) || empty($l_name) || empty($date_in) || empty($date_out) || empty($dob) || empty($height) || empty($addr) || empty($section_id)) {
        header("Location: ../../public/?page=crime&error=emptyfields");
        exit();
    }

    try {
        $pdo->beginTransaction();

        $sql2 = "INSERT INTO Prisoner(First_name, Last_name, Date_in, Dob, Height, Date_out, Address, Section_id, Status_inout) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$f_name, $l_name, $date_in, $dob, $height, $date_out, $addr, $section_id, $status_inout]);

        $prisoner_id = $pdo->lastInsertId();

        if (isset($_POST["IPC"])) {
            foreach ($_POST['IPC'] as $ipc_code) {
                $sql3 = "INSERT INTO Commits(IPC, Prisoner_id) VALUES (?, ?)";
                $stmt3 = $pdo->prepare($sql3);
                $stmt3->execute([$ipc_code, $prisoner_id]);
            }
        }

        $pdo->commit();
        header("Location: ../../public/?page=successcrime_prisoner&insert=success");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: ../../public/?page=crime&error=sqlerror");
        exit();
    }
}

<?php

if (isset($_POST['visitor_add'])) {
    require 'dbh.inc.php';

    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $aadhaar = $_POST['aadhaar'];
    $date_visit = $_POST['date_visit'];
    $time_slot = $_POST['time_slot'];
    $prisoner_id = $_POST['prisoner_id'];

    try {
        $pdo->beginTransaction();

        $sql_input = "INSERT INTO Visitor(First_name, Last_name, Aadhaar) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql_input);
        $stmt->execute([$f_name, $l_name, $aadhaar]);

        $visit_sql = "INSERT INTO Visit(Visitor_aadhaar, Date_visit, Time_slot, Prisoner_id) VALUES (?, ?, ?, ?)";
        $visit_stmt = $pdo->prepare($visit_sql);
        $visit_stmt->execute([$aadhaar, $date_visit, $time_slot, $prisoner_id]);

        $pdo->commit();

        header("Location: ../../public/?page=success_visitor&insert=success");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        header("Location: ../../public/?page=visitor&error=sqlerror");
        exit();
    }
}

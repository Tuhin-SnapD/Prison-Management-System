<?php
    if(isset($_POST['prisoner_out_status'])){
        require 'dbh.inc.php';
        $prisoner_id=$_POST['prisoner_id'];

        if(empty($prisoner_id)){
            header("Location: ../prisoner_out.php?error=emptyfields");
            exit();
        }else{
          $sql1="UPDATE Prisoner SET Status_inout='OUT' WHERE Prisoner_id='$prisoner_id' ";
          if(!mysqli_query($conn,$sql1)){
            header("Location: ../prisoner_out.php?error=sqlerror");
            exit();
        }else{
            header("Location: ../prisoner_out.php?error=success");
              exit();
        }
      }
    }else{
      header("Location: ../failure.php");
      exit();
      }
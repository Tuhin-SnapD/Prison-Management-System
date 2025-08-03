<?php
    if(isset($_POST['new_section_prisoner'])){
        require 'dbh.inc.php';
        $prisoner_id=$_POST['Prisoner_id'];
        $section_id=$_POST['Section_id'];

        if(empty($prisoner_id)){
            header("Location: ../prisoner_newsection.php?error=emptyfields");
            exit();
        }else{
          $sql1="UPDATE Prisoner SET Section_id='$section_id' WHERE Prisoner_id='$prisoner_id' ";
          if(!mysqli_query($conn,$sql1)){
            header("Location: ../prisoner_newsection.php?error=sqlerror");
            exit();
        }else{
            header("Location: ../prisoner_newsection.php?error=success");
              exit();
        }
      }
    }else{
      header("Location: ../failure.php");
      exit();
      }
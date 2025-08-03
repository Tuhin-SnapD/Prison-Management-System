<?php
    if(isset($_POST['update_dateout'])){
        require'./dbh.inc.php';
        $out_date=$_POST['date_out'];
        $pid=$_POST['add_pid'];
        echo $out_date."<br>";
        echo $pid;

        if(empty($out_date)||empty($pid)){
            header("Location: ../prisoner_dateout.php?error=emptyfields");
            exit();

            }else{
                    $sql="UPDATE Prisoner SET Date_out='$out_date' WHERE Prisoner_id='$pid' ";
                    if(!mysqli_query($conn,$sql)){
                        header("Location: ../prisoner_dateout.php?error=sqlerror");
                        exit();
                    }else{
                        header("Location: ../prisoner_dateout.php?error=success");
                    
                        exit();
                    }
            }
            
            
        }else{
        header("Location: ../failure.php");
        exit();
        }
    








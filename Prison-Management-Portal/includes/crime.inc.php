<?php
    if(isset($_POST['crime_prisoner_add'])){
        require 'dbh.inc.php';
        $IPC=$_POST['IPC'];
        $f_name=$_POST['f_name'];
        $l_name=$_POST['l_name'];
        $date_in=$_POST['date_in'];
        $date_out=$_POST['date_out'];
        $dob=$_POST['dob'];
        $height=$_POST['height'];
        $addr=$_POST['addr'];
        $section_id=$_POST['section_id'];
        $status_inout='in';

        if(empty($IPC)||empty($f_name)||empty($l_name)||empty($date_in)||empty($date_out)||empty($dob)||empty($height)||empty($addr)||empty($section_id)){
              
            
            header("Location: ../crime.php?error=emptyfields");
            exit();
        }else{
                
                $sql2="INSERT INTO Prisoner(First_name,Last_name,Date_in,Dob,Height,Date_out,Address,Section_id,Status_inout) VALUES
                (?,?,?,?,?,?,?,?,?) ";
                $stmt2=mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt2,$sql2)){
                    header("Location: ../crime.php?error=sqlerror");
                    exit();
                }else{
                   
                    mysqli_stmt_bind_param($stmt2,"ssssissis",$f_name,$l_name,$date_in,$dob,$height,$date_out,$addr,$section_id,$status_inout);
                    mysqli_stmt_execute($stmt2);

                    //exit();

                }
                //getting the prioner id from the latest entry in the prisoner table;
                $sql="SELECT Prisoner_id FROM Prisoner ORDER BY Prisoner_id DESC LIMIT 1 ";
                $result=mysqli_query($conn,$sql);
               
                $res=mysqli_fetch_row($result);
                
                //inserting IPC and prisoner id into  Commits table:
                if(isset($_POST["IPC"])) 
                {
                    // Retrieving each selected option
                    foreach ($_POST['IPC'] as $IPC) {
                        $sql3="INSERT INTO Commits(IPC,Prisoner_id) VALUES (?,?)";
                        $stmt3=mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt3,$sql3)){
                            header("Location: ../crime.php?error=sqlerror");
                            exit();
                        }
                        else{    
                            mysqli_stmt_bind_param($stmt3,"ii",$IPC,$res[0]);
                            mysqli_stmt_execute($stmt3);
                            header("Location: ../successcrime_prisoner.php?insert=success");
                        }
                    }
                }

                
                           


        }
    }
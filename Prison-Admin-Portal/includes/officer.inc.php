<?php
    if(isset($_POST['officer_add'])){
      require 'dbh.inc.php';
     // $officer_id=$_POST['officer_id']; //officer id not defined in the input yet
      $f_name=$_POST['f_name'];
      $l_name=$_POST['l_name'];
      $dob=$_POST['dob'];
      $title=$_POST['title'];
      $mob_number=$_POST['mob_number'];
      $username=$_POST['username'];
      $password=$_POST['password'];
      $cfmpassword=$_POST['cfmpassword'];

      if(empty($f_name)||empty($l_name)||empty($dob)||empty($title)||empty($mob_number)||empty($username)||empty($password)||empty($cfmpassword)){   
        header("Location: ../officer.php?error=emptyfields");
        exit();
    } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
      header("Location: ../officer.php?error=invaliduid&uid=".$username);
       exit();
   } else if($password !== $cfmpassword){
    header("Location: ../officer.php?error=passwordnotmatched&uid=".$username);
    exit();
  } else{
    $sql="SELECT Officer_uname FROM Officer WHERE Officer_uname=?";
    $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../officer.php?error=sqlerror");
        exit();
        } else{
          mysqli_stmt_bind_param($stmt,"s",$username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck= mysqli_stmt_num_rows($stmt);
                if($resultCheck>0){
                    header("Location: ../officer.php?error=sameuserexistserror");
                    exit();
                }
                else{
                 
                  $sql1="INSERT INTO Officer (Officer_uname, Officer_pwd, First_name, Last_name, Title, Date_of_birth) VALUES (?,?,?,?,?,?) ";
                          $stmt1=mysqli_stmt_init($conn);
                          if(!mysqli_stmt_prepare($stmt1,$sql1)){
                              header("Location: ../officer.php?error=sqlerror");
                              exit();
                          }else{
                              //hashing the password:
                              mysqli_stmt_bind_param($stmt1,"ssssss",$username,$password,$f_name,$l_name,$title,$dob);
                              mysqli_stmt_execute($stmt1);
                             
                              //exit();
          
                          }
                           //getting the officer id of the officer just added:
                            $sql="SELECT Officer_id FROM Officer ORDER BY Officer_id DESC LIMIT 1 ";
                             $result=mysqli_query($conn,$sql);
                              $officer_id=mysqli_fetch_row($result);
                              
                          $sql2="INSERT INTO Officer_phone(Officer_phone,Officer_id ) VALUES ('$mob_number','$officer_id[0]') ";
                          if(!mysqli_query($conn,$sql2)){
                            header("Location: ../successofficer.php?insert=sqlerror");
                            
                            exit();
                          }
                         
                          else{
                          header("Location: ../successofficer.php?insert=success");
                          exit();
                         }
                  
                        }
        } 
      }
 }else{
        header("Location: ../officer.php?error=clickonsignupbtnerror");
        exit();

    }



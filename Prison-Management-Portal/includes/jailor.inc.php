<?php
    if(isset($_POST['jailor_add'])){
      require 'dbh.inc.php';
      //$jailor_id=$_POST['jailor_id']; //officer id not defined in the input yet
      $f_name=$_POST['f_name'];
      $l_name=$_POST['l_name'];
      $mob_number=$_POST['mob_number'];
   
      $username=$_POST['username'];
      $password=$_POST['password'];
      $cfmpassword=$_POST['cfmpassword'];
      $sec_id=$_POST['section_id'];
      $sec_name=$_POST['section_name'];

      if(empty($f_name)||empty($l_name)||empty($mob_number)||empty($username)||empty($password)||empty($cfmpassword)){   
        header("Location: ../jailor.php?error=emptyfields");
        exit();
    } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
      header("Location: ../jailor.php?error=invaliduid&uid=".$username);
       exit();
   } else if($password !== $cfmpassword){
    header("Location: ../jailor.php?error=passwordnotmatched&uid=".$username);
    exit();
  } else{
    $sql="SELECT Jailor_uname FROM Jailor WHERE Jailor_uname=?";
    $stmt=mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../jailor.php?error=sqlerror");
        exit();
        } else{
          mysqli_stmt_bind_param($stmt,"s",$username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck= mysqli_stmt_num_rows($stmt);
                if($resultCheck>0){
                    header("Location: ../jailor.php?error=sameuserexistserror");
                    exit();
                }
                else{
                  $sql_select="SELECT Jailor_id,Jailor_uname,Jailor_pwd,First_name,Last_name FROM Jailor WHERE Jailor_id=(SELECT Jailor_id FROM Section WHERE Section_id='$sec_id')" ;
                  $result=mysqli_query($conn,$sql_select);
                  $Jailor_info=mysqli_fetch_row($result);
                  //print_r($Jailor_info) ;
                  //echo $Jailor_info[0];
                  
                  
                  $sql_add="INSERT INTO Deleted_jailors (Jailor_id,Jailor_uname,Jailor_pwd,First_name,Last_name) VALUES(?,?,?,?,?)";
                  $stmt_add=mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt_add,$sql_add)){
                      header("Location: ../jailor.php?error=sqlerror");
                      exit();
                  }else{
                      //hashing the password:
                      mysqli_stmt_bind_param($stmt_add,"issss",$Jailor_info[0],$Jailor_info[1],$Jailor_info[2],$Jailor_info[3],$Jailor_info[4]);
                      mysqli_stmt_execute($stmt_add);
                      //header("Location: ../jailor.php?insert=success");
                      //exit();
  
                  }
                  $sql_disable1="ALTER TABLE Section DISABLE KEYS ";
                  if(!mysqli_query($conn,$sql_disable1)){
                    header("Location: ../jailor.php?error=sqlerror1");
                    exit();
                  }
                  $sql_disable2="ALTER TABLE Jailor_phone DISABLE KEYS ";
                  if(!mysqli_query($conn,$sql_disable2)){
                    header("Location: ../jailor.php?error=sqlerror11");
                    exit();
                  }
                  /* 
                  $sql0=" DELETE FROM Jailor WHERE Jailor_id=(SELECT Jailor_id FROM Section WHERE Section_id='$sec_id' ); ";
                  if(!mysqli_query($conn,$sql0)){
                    header("Location: ../jailor.php?error=sqlerror2");
                    exit();
                  }
                  */
                  
                  $sql0=" DELETE FROM Section WHERE Section_id='$sec_id;'";
                  if(!mysqli_query($conn,$sql0)){
                    header("Location: ../jailor.php?error=sqlerror2");
                    exit();
                  }
                  
                  $sql1="INSERT INTO Jailor (Jailor_uname, Jailor_pwd, First_name, Last_name) VALUES (?,?,?,?) ";
                          $stmt1=mysqli_stmt_init($conn);
                          if(!mysqli_stmt_prepare($stmt1,$sql1)){
                              header("Location: ../jailor.php?error=sqlerror3");
                              exit();
                          }else{
                              //hashing the password:
                              mysqli_stmt_bind_param($stmt1,"ssss",$username,$password,$f_name,$l_name);
                              mysqli_stmt_execute($stmt1);
                             // header("Location: ../fir.php?insert=success");
                              //exit();
          
                          }
                          //getting the jailor id of the officer just added:
                  $sql="SELECT Jailor_id FROM Jailor ORDER BY Jailor_id DESC LIMIT 1 ";
                  $result=mysqli_query($conn,$sql);
                  $jailor_id=mysqli_fetch_row($result);
                  
                  $sql2="INSERT INTO Jailor_phone (Jailor_phone,Jailor_id) VALUES (?,?)";
                  $stmt2=mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt2,$sql2)){
                          header("Location: ../jailor.php?error=sqlerror4");
                            exit();
                  }else{
                        mysqli_stmt_bind_param($stmt2,"si",$mob_number,$jailor_id[0]);
                        mysqli_stmt_execute($stmt2);
                        // header("Location: ../successjailor.php?insert=success");
                        //exit();
                  }
                  
                  $sql3="INSERT INTO Section (Section_id,Section_name,Jailor_id) VALUES (?,?,?)";
                  $stmt3=mysqli_stmt_init($conn);
                  if(!mysqli_stmt_prepare($stmt3,$sql3)){
                     header("Location: ../jailor.php?error=sqlerror5");
                      exit();
                  }else{
                              mysqli_stmt_bind_param($stmt3,"isi",$sec_id,$sec_name,$jailor_id[0]);
                              mysqli_stmt_execute($stmt3);
                              //header("Location: ../successjailor.php?insert=success");
                              //exit();
          
                  }
                  $sql_enable1="ALTER TABLE Section ENABLE KEYS; ";
                  if(!mysqli_query($conn,$sql_enable1)){
                    header("Location: ../jailor.php?error=sqlerror6");
                    exit();
                  }else{
                    $sql_enable2="ALTER TABLE Jailor_phone ENABLE KEYS; ";
                        mysqli_query($conn,$sql_enable2);
                    
                    
                    header("Location: ../successjailor.php?insert=success");
                    exit();
                  }
                }

                
                
        } 
      }
 }else{
        header("Location: ../jailor.php?error=clickonsignupbtnerror");
        exit();

    }



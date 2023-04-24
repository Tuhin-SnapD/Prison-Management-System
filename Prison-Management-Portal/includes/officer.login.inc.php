<?php
if(isset($_POST['officer_login-submit'])){
    require "dbh.inc.php";
    $uid=$_POST['officer_uname'];
    $password=$_POST['officer_pwd'];

    if(empty($uid)|| empty($password)){
        header("Location: ../signin-officer.php?error=emptyFields");
        exit();
    }else{
        $sql="SELECT Officer_uname,Officer_pwd FROM Officer WHERE Officer_uname=?; ";
        $stmt=mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../signin-officer.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$uid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                   $pwdCheck=($password==$row['Officer_pwd']);   
                // $pwdCheck=password_verify($password,$row['Officer_pwd']);
                    if($pwdCheck == false){
                        header("Location: ../signin-officer.php?error=wrongpassword");
                        exit();
                    }else if($pwdCheck==true){
                        session_start();
                        //$_SESSION['userId']=$row['Officer_id'];
                        $_SESSION['userUidOfficer']=$row['Officer_uname'];

                        header("Location: ../officer-dashboard.php?login=success");
                        exit();
                    }else{
                        header("Location: ../signin-officer.php?error=wrongpassword");
                        exit();
                    }
            }else{
                header("Location: ../signin-officer.php?error=usernotfound");
                 exit();
            }
        }
    }
}else{
    header("Location: ../signin-officer.php?error=usernotfound");
                 exit();

}    
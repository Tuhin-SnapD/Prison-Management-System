<?php
if(isset($_POST['jailor_login-submit'])){
    require "dbh.inc.php";
    $uid=$_POST['jailor_uname'];
    $password=$_POST['jailor_pwd'];

    if(empty($uid)|| empty($password)){
        header("Location: ../signin-jailor.php?error=emptyFields");
        exit();
    }else{
        $sql="SELECT Jailor_uname,Jailor_pwd FROM Jailor WHERE Jailor_uname=?; ";
        $stmt=mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../signin-jailor.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$uid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                   $pwdCheck=($password==$row['Jailor_pwd']);   
                // $pwdCheck=password_verify($password,$row['Jailor_pwd']);
                    if($pwdCheck == false){
                        header("Location: ../signin-jailor.php?error=wrongpassword");
                        exit();
                    }else if($pwdCheck==true){
                        session_start();
                        //$_SESSION['userId']=$row['Officer_id'];
                        $_SESSION['userUidJailor']=$row['Jailor_uname'];

                        header("Location: ../jailor-dashboard.php?login=success");
                        exit();
                    }else{
                        header("Location: ../signin-jailor.php?error=wrongpassword");
                        exit();
                    }
            }else{
                header("Location: ../signin-jailor.php?error=usernotfound");
                 exit();
            }
        }
    }
}else{
    header("Location: ../signin-jailor.php?error=usernotfound");
                 exit();

}    
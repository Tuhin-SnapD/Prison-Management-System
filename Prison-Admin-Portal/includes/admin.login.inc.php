<?php
if(isset($_POST['admin_login-submit'])){
    require "dbh.inc.php";
    $uid=$_POST['admin_uname'];
    $password=$_POST['admin_pwd'];

    if(empty($uid)|| empty($password)){
        header("Location: ../signin-admin.php?error=emptyFields");
        exit();
    }else{
        $sql="SELECT Admin_uname,Admin_pwd FROM Admin WHERE Admin_uname=?; ";
        $stmt=mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../signin-admin.php?error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$uid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                   $pwdCheck=($password==$row['Admin_pwd']);   
             
                    if($pwdCheck == false){
                        header("Location: ../signin-admin.php?error=wrongpassword");
                        exit();
                    }else if($pwdCheck==true){
                        session_start();
                        
                        $_SESSION['userUidAdmin']=$row['Admin_uname'];

                        header("Location: ../admin.php?login=success");
                        exit();
                    }else{
                        header("Location: ../signin-admin.php?error=wrongpassword");
                        exit();
                    }
            }else{
                header("Location: ../signin-admin.php?error=usernotfound");
                 exit();
            }
        }
    }
}else{
    header("Location: ../signin-admin.php?error=usernotfound");
                 exit();

}    
<?php
if(isset($_POST['officer_login-submit'])){
    // Use a more reliable path to include database connection
    require_once dirname(__DIR__) . '/database/dbh.inc.php';
    
    // Ensure $conn is available
    if (!isset($conn) || $conn === null) {
        // Fallback connection if the include didn't work
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'prisondb';
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }
    
    $uid=$_POST['officer_uname'];
    $password=$_POST['officer_pwd'];

    if(empty($uid)|| empty($password)){
        header("Location: ?page=signin-officer&error=emptyFields");
        exit();
    }else{
        $sql="SELECT Officer_uname,Officer_pwd FROM Officer WHERE Officer_uname=?; ";
        $stmt=mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ?page=signin-officer&error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$uid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                   $pwdCheck=($password==$row['Officer_pwd']);   
                // $pwdCheck=password_verify($password,$row['Officer_pwd']);
                    if($pwdCheck == false){
                        header("Location: ?page=signin-officer&error=wrongpassword");
                        exit();
                    }else if($pwdCheck==true){
                        // Session is already started in index.php
                        $_SESSION['userUidOfficer']=$row['Officer_uname'];

                        header("Location: ?page=officer-dashboard&login=success");
                        exit();
                    }else{
                        header("Location: ?page=signin-officer&error=wrongpassword");
                        exit();
                    }
            }else{
                header("Location: ?page=signin-officer&error=usernotfound");
                 exit();
            }
        }
    }
}else{
    header("Location: ?page=signin-officer&error=usernotfound");
                 exit();

}    
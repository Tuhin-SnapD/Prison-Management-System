<?php
if(isset($_POST['jailor_login-submit'])){
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
    
    $uid=$_POST['jailor_uname'];
    $password=$_POST['jailor_pwd'];

    if(empty($uid)|| empty($password)){
        header("Location: ?page=signin-jailor&error=emptyFields");
        exit();
    }else{
        $sql="SELECT Jailor_uname,Jailor_pwd FROM Jailor WHERE Jailor_uname=?; ";
        $stmt=mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ?page=signin-jailor&error=sqlerror");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"s",$uid);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){
                   $pwdCheck=($password==$row['Jailor_pwd']);   
                // $pwdCheck=password_verify($password,$row['Jailor_pwd']);
                    if($pwdCheck == false){
                        header("Location: ?page=signin-jailor&error=wrongpassword");
                        exit();
                    }else if($pwdCheck==true){
                        // Session is already started in index.php
                        $_SESSION['userUidJailor']=$row['Jailor_uname'];

                        header("Location: ?page=jailor-dashboard&login=success");
                        exit();
                    }else{
                        header("Location: ?page=signin-jailor&error=wrongpassword");
                        exit();
                    }
            }else{
                header("Location: ?page=signin-jailor&error=usernotfound");
                 exit();
            }
        }
    }
}else{
    header("Location: ?page=signin-jailor&error=usernotfound");
                 exit();

}    
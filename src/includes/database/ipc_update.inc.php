<?php
    if(isset($_POST['IPC'])){
        require './dbh.inc.php';
        $IPC = $_POST['IPC'];
        $prisoner_id= $_POST['Prisoner_id'];

        $sql="INSERT INTO Commits(IPC,Prisoner_id) VALUES (?,?)";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../ipc_update.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"ii",$IPC,$prisoner_id);
            $result = mysqli_stmt_execute($stmt);
            if (!$result) {
                header("Location: ../ipc_update.php?error=reserror");
                exit();
            }
            
            header("Location: ../ipc_update.php?error=success");
            exit();
        }

            
            
    }
    else{
        header("Location: ../failure.php");
        exit();
    }
    
?>





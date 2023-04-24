<?php
    require 'header.php';
    if(isset($_SESSION['userUidOfficer'])){

    include_once 'includes/dbh.inc.php';
    //require'header.php';
    }else{
        header("Location: ./failure.php");
        exit();
    }

    //require 'header.php';
  
    $sql="SELECT * FROM Crime";
    $result=mysqli_query($conn,$sql);
    $resultCheck=mysqli_num_rows($result);

    if($resultCheck  > 0){?>
  <style>.foot{padding-top:55px;}</style>

  <section class="text-gray-700 body-font relative">
  <h1 class="text-3xl text-center">
            List of all important IPC Sections
        </h1> 
    <div class="container text-center px-5 my-5 mx-auto">
        <div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-4 sm:px-6 lg:px-8">
       
        <table class="table-fixed">
            <thead>
              <tr>
                <th class="w-1/2 px-7 py-2">IPC</th>
                <th class="w-1/2 px-7 py-2">Description</th>
                

              </tr>
            </thead>
            <tbody>
        <?php
         while($row=mysqli_fetch_assoc($result)){ ?>
            
            
              <tr>
                <td class="border px-4 py-2"><?php echo"Section ".$row['IPC']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Description']."<br>";?></td>
              </tr>
             
       


        <?php }?>
        </tbody>
        </table>



    <?php }
   ?>
    </div>
    

  </div>
  
    
</section>


<footer class="foot">
<?php
 require'footer.php';?>
</foooter>

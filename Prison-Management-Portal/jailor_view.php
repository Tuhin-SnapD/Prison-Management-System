<?php
    require 'header.php';
    if(isset($_SESSION['userUidOfficer']) ||isset($_SESSION['userUidJailor'])){

    include_once 'includes/dbh.inc.php';
    }else{
        header("Location: ./failure.php");
        exit();
    }

    $sql="SELECT * FROM Deleted_Jailors as J INNER JOIN Jailor_phone as JP ON J.Jailor_id=JP.Jailor_id ;";
    $result=mysqli_query($conn,$sql);
    $resultCheck=mysqli_num_rows($result);


    if(($resultCheck ) > 0){?>
  <style>.foot{padding-top:55px;}</style>

  <section class="text-gray-700 body-font relative">
  <h1 class="text-3xl text-center">
            Jailors removed
        </h1> 
    <div class="container text-center px-5 my-5 mx-auto">
        <div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-4 sm:px-6 lg:px-8">
       
        <table class="table-fixed">
            <thead>
              <tr>
                <th class="w-1/4 px-5 py-2">Jailor ID</th>
                <th class="w-1/4 px-5 py-2">First Name</th>
                <th class="w-1/4 px-5 py-2">Last Name</th>
                <th class="w-1/4 px-4 py-2">Mobile Number</th>


              </tr>
            </thead>
            <tbody>
        <?php
        

  
            while($row=mysqli_fetch_assoc($result)){?>
               
              <tr>
                <td class="border px-4 py-2"><?php echo "JAI".$row['Jailor_id']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['First_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Last_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Jailor_phone']."<br>";?></td>
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
</footer>

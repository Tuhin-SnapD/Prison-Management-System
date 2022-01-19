<?php
    require 'header.php';
    if(isset($_SESSION['userUidOfficer'])){

    include_once 'includes/dbh.inc.php';
    //require'header.php';
    }else{
        header("Location: ./failure.php");
        exit();
    }


    $sql="SELECT O.Officer_id,O.First_name,O.Last_name,O.Title,O.Date_of_birth,OP.Officer_phone FROM 
    Officer as O INNER JOIN  Officer_phone as OP ON O.Officer_id=OP.Officer_id;";
    $result=mysqli_query($conn,$sql);
    $resultCheck=mysqli_num_rows($result);

    if($resultCheck  > 0){?>
  <style>.foot{padding-top:8gi5px;}</style>

  <section class="text-gray-700 body-font relative">
  <h1 class="text-3xl text-center">
            Officers present
        </h1> 
    <div class="container text-center px-5 my-5 mx-auto">
        <div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-3 sm:px-6 lg:px-8">
       
        <table class="table-fixed">
            <thead>
              <tr>
                <th class="w-1/8 px-7 py-2">Officer ID</th>
                <th class="w-1/8 px-7 py-2">First Name</th>
                <th class="w-1/8 px-7 py-2">Last Name</th>
                <th class="w-1/8 px-7 py-2">Title</th>
                <th class="w-1/8 px-7 py-2">Date Of Birth</th>
                <th class="w-1/8 px-7 py-2">Mobile Number</th>


              </tr>
            </thead>
            <tbody>
        <?php
         while($row=mysqli_fetch_assoc($result)){ ?>
            
            
              <tr>
                <td class="border px-4 py-2"><?php echo"OFF".$row['Officer_id']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['First_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Last_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Title']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Date_of_birth']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Officer_phone']."<br>";?></td>
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

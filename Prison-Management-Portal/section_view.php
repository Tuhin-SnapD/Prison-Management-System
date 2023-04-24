<?php
    require 'header.php';
    if(isset($_SESSION['userUidOfficer']) ||isset($_SESSION['userUidJailor'])){

    include_once 'includes/dbh.inc.php';
    }else{
        header("Location: ./failure.php");
        exit();
    }


    $sql="SELECT S.Section_id ,S.Section_name,S.Jailor_id ,J.First_name, J.Last_name,JP.Jailor_phone FROM Section AS S INNER JOIN Jailor AS J ON J.Jailor_id=S.Jailor_id INNER JOIN Jailor_phone AS JP ON J.Jailor_id=JP.Jailor_id";
    $result=mysqli_query($conn,$sql);
    $resultCheck=mysqli_num_rows($result);

    if($resultCheck  > 0){?>


  <section class="text-gray-700 body-font relative">
  <h1 class="text-3xl text-center">
            Sections present in the prison
        </h1> 
    <div class="container text-center px-5 my-5 mx-auto">
        <div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-4 sm:px-6 lg:px-8">
       
        <table class="table-fixed">
            <thead>
              <tr>
                <th class="w-1/7 px-8 py-2">Section ID</th>
                <th class="w-1/7 px-8 py-2">Section Name</th>
                <th class="w-1/7 px-8 py-2">Jailor ID</th>
                <th class="w-1/7 px-8 py-2">First_name</th>
                <th class="w-1/7 px-8 py-2">Last_name</th>
                <th class="w-1/7 px-8 py-2">Mobile number</th>

              </tr>
            </thead>
            <tbody>
        <?php
         while($row=mysqli_fetch_assoc($result)){ ?>
            
            
              <tr>
                <td class="border px-4 py-2"><?php echo"SEC".$row['Section_id']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Section_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo"JAI".$row['Jailor_id']."<br>";?></td>
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

<?php
 require'footer.php';
 ?>


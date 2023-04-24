<?php
    require 'header.php';
    if(isset($_SESSION['userUidOfficer'] )||isset( $_SESSION['userUidJailor'])){

    include_once 'includes/dbh.inc.php';
    //require'header.php';
    }else{
        header("Location: ./failure.php");
        exit();
    }
    ?>
  <form action="includes/prisoner_view.inc.php" method="post">
  <div class="flex flex-col h-screen">
    <section class="text-gray-700 body-font relative flex-grow">
      <div class="container px-5 my-5 mx-auto">
        <div class="flex flex-col text-center w-full mb-12">
          <h1
            class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900"
          >
          View all Prisoners!
          </h1>
          <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
            The Officer can view all Prisoners in the Jail!
          </p>
        </div>
      </div>
      <div class="container px-5 my-5 mx-auto md:flex md:justify-center mb-6">
      <form class="w-full max-w-sm md:items-center">
        <div class="md:flex md:items-center mb-6">
          <div class="md:w-1/3">
            <label class="block text-gray-700 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
              Section ID
            </label>
          </div>
          <div class="md:w-2/3">
            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:outline-none focus:border-indigo-500" id="inline-full-name" type="text" placeholder="Enter the Section ID" name="sec_id">
          </div>
        </div>
      </form>
      </div>
      <div class="p-2 w-full">
        <button
          class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" name="btn"
        >
          Submit
        </button>
      </div>
      </section>
</form>
<?php
    //require 'header.php';
    //if(isset($_SESSION['userUidOfficer'])){
    $sql="SELECT * FROM Prisoner ";
    $result=mysqli_query($conn,$sql);
    $resultCheck=mysqli_num_rows($result);
    if($resultCheck > 0){?>
  <style>.foot{padding-top:55px;}</style>

  <section class="text-gray-700 body-font relative">
    
    <div class="container text-center px-5 my-5 mx-auto">
        <div class="flex items-center justify-center bg-gray-50 pt-12 pb-56 px-4 sm:px-6 lg:px-8">
       
        <table class="table-fixed">
            <thead>
              <tr>
                <th class="w-1/4 px-4 py-2">Prisoner ID</th>
                <th class="w-1/4 px-5 py-2">First Name</th>
                <th class="w-1/4 px-5 py-2">Last Name</th>
                <th class="w-1/4 px-5 py-2">Date In</th>
                <th class="w-1/4 px-5 py-2">DOB</th>
                <th class="w-1/4 px-5 py-2">Height</th>
                <th class="w-1/4 px-5 py-2">Date Out</th>
                <th class="w-1/4 px-5 py-2">Address</th>
                <th class="w-1/4 px-5 py-2">Section ID</th>
                <th class="w-1/4 px-5 py-2">Status</th>


              </tr>
            </thead>
            <tbody>
        <?php
         while($row=mysqli_fetch_assoc($result)){ ?>
            
            
              <tr>
                <td class="border px-4 py-2"><?php echo"PRI".$row['Prisoner_id']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['First_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Last_name']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Date_in']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Dob']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Height']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Date_out']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Address']."<br>";?></td>
                <td class="border px-4 py-2"><?php echo$row['Section_id']."<br>";?></td>
                
                <td class="border px-4 py-2"><?php echo$row['Status_inout']."<br>";?></td>

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
</div>

<?php
    require 'header.php';
    if(isset($_SESSION['userUidAdmin'])){

    include_once 'includes/dbh.inc.php';
    //require'header.php';
    }else{
        header("Location: ./failure.php");
        exit();
    }
   
    ?>
<section class="text-gray-700 body-font">
      <div class="container px-5 py-24 mx-auto">
        <div class="font-medium title-font text-center text-gray-900 mb-20">
        <h1 class="text-3xl">
            Admin Dashboard
        </h1>    
          <br class="hidden sm:block">
          <h2 class="text-lg">Prison Management System</h2>
        </div>
        
        
        <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4">
          
          <div class="p-4 md:w-1/3 md:mb-0 mb-6 flex">
            <div class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4 flex-shrink-0">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="flex-grow pl-6">
              <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Add a Visitor</h2>
              <p class="leading-relaxed text-base">Add Visitor Details .</p>
              <a class="mt-3 text-indigo-500 inline-flex items-center"href="./visitor.php">Add Visitor
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
          <div class="p-4 md:w-1/3 md:mb-0 mb-6 flex">
            <div class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4 flex-shrink-0">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="flex-grow pl-6">
              <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Add an Officer</h2>
              <p class="leading-relaxed text-base">Add Officer Details.</p>
              <a class="mt-3 text-indigo-500 inline-flex items-center"href="./officer.php">Add Officer
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
          <div class="p-4 md:w-1/3 md:mb-0 mb-6 flex">
          <div class="w-12 h-12 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4 flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          </div>
          <div class="flex-grow pl-6">
            <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Add a Jailor</h2>
            <p class="leading-relaxed text-base">Add Jailor Details .</p>
            <a class="mt-3 text-indigo-500 inline-flex items-center"href="./jailor.php">Add Jailor
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
          
          
       
           
   
    
        </div>
      </div>
    </section>';
    
<?php
    require "./footer.php"
?>

<?php 
require "./header.php";
if(isset($_SESSION['userUidOfficer'])){
  if(isset($_GET['error'])){
    if($_GET['error']=="emptyfields"){
      echo'<h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-red-600">
       Empty fields!!       
       </h2>';
    }elseif($_GET['error']=="sqlerror"){
      echo'<h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-red-600">
      sql database connection error!!       
      </h2>';
    }elseif($_GET['error']=="reserror"){
      echo'<h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-red-600">
      IPC not updated!!       
      </h2>';
    }
}

echo'
<form action="includes/visitor.inc.php" method="POST">
  <div class="flex flex-col h-screen">
    <section class="text-gray-700 body-font relative flex-grow">
      <div class="container px-5 my-5 mx-auto">
        <div class="flex flex-col text-center w-full mb-12">
          <h1
            class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900"
          >
          Visitor Registration
          </h1>
          <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
            Add a Visitor!
          </p>
        </div>
        <div class="lg:w-1/2 md:w-2/3 mx-auto">
          <div class="flex flex-wrap -m-2">
            <div class="p-2 w-1/2">
              <label class="block text-sm leading-5 font-medium text-gray-700">First Name</label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input
                name="f_name"
                class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
                placeholder="First Name"
                />
              </div>
            </div>
            <div class="p-2 w-1/2">
              <label class="block text-sm leading-5 font-medium text-gray-700">Last Name</label>
              <div class="mt-1 relative rounded-md shadow-sm">
              <input
              name="l_name"
                class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
                placeholder="Last Name"
              />
                
              </div>
            </div>
            <div class="p-2 w-1/2">
              <label class="block text-sm leading-5 font-medium text-gray-700">Aadhaar Number</label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input required
                  name="aadhaar"
                  class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
                  placeholder="123456789012"
                />
              </div>
            </div>
            <div class="p-2 w-1/2">
              <label class="block text-sm leading-5 font-medium text-gray-700">
                Date of Visit
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <input
                  name="date_visit"
                  class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
                  type="date"
                />
              </div>
            </div>
            <div class="p-2 w-1/2">
              <label class="block text-sm leading-5 font-medium text-gray-700">
                Time Slot
              </label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <select
                  name="time_slot"
                  class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
                >
                  <option value="10AM-11AM">10AM-11AM</option>
                  <option value="12PM-1PM">12PM-1PM</option>
                  <option value="2PM-3PM">2PM-3PM</option>
                  <option value="4PM-5PM">4PM-5PM</option>
                  <option value="6PM-7PM">6PM-7PM</option>
                </select>
              </div>
            </div>
            <div class="p-2 w-1/2">
            <label class="block text-sm leading-5 font-medium text-gray-700"
              >Prisoner ID</label
            >
            <div class="mt-1 relative rounded-md shadow-sm">
              <input
              name="prisoner_id"
                placeholder="Prisoner ID" class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              />
            </div>
          </div>
            <div class="p-5 w-full">
              <input
                name="visitor_add"
                type="submit"
                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                value="Submit"
              >
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</form>
';}else{
  echo' <div class="hero bg-gray-100 py-16 h-screen">
      <!-- container -->
      <div class="container px-4 sm:px-8 lg:px-16 xl:px-20 mx-auto">
          <!-- hero wrapper -->
          <div class="hero-wrapper grid grid-cols-1 md:grid-cols-12 gap-8 items-center">

              <!-- hero text -->
              <div class="hero-text col-span-6">
                  <h1 class=" font-bold text-4xl md:text-5xl max-w-xl text-gray-900 leading-tight">Operation Failed</h1>
                  <hr class=" w-12 h-1 bg-indigo-500 rounded-full mt-8">
                  <p class="text-gray-800 text-base leading-relaxed mt-8 font-semibold">Access Denied</p>

              </div>

              <!-- hero image -->
              <div class="hero-image col-span-6">
                  <img src="./failure.svg" alt="">
              </div>
          </div>
      </div>
  </div>';
}
require "./footer.php";
?>
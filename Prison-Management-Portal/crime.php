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
        }

      }
      echo'


<form action="includes/crime.inc.php" method="post" >
  <section class="text-gray-700 body-font relative">
    <div class="container px-5 my-5 mx-auto">
      <div class="flex flex-col text-center w-full mb-12">
        <h1
          class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900"
        >
          Crime Details
        </h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
          Crime details of Prisoner
        </p>
      </div>
      <div class="lg:w-1/2 md:w-2/3 mx-auto">
        <div class="flex flex-wrap -m-2">
          <div class="p-2 w-1/2">
          <label class="block text-sm leading-5 font-medium text-gray-700"
            >IPC</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <select
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 "
              placeholder="IPC" name="IPC[]" multiple >
            <option  value="1">1</option>
            <option  value="3">3</option>
            <option  value="191">191</option>
            <option   value="300">300</option>
            <option  value="378">378</option>
            option  value="415">415</option>
           </select>
          </div>
        </div>
         
          
  
         
        
        </div>
      </div>
    </div>
  </section>

  <section class="text-gray-700 body-font relative">
  <div class="container px-5 my-5 mx-auto">
    <div class="flex flex-col text-center w-full mb-12">
      <h1
        class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900"
      >
        Add a Prisoner
      </h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
        Add a prisoner to the system
      </p>
    </div>
    <div class="lg:w-1/2 md:w-2/3 mx-auto">
      <div class="flex flex-wrap -m-2">
        <div class="p-2 w-1/2">
          <label class="block text-sm leading-5 font-medium text-gray-700"
            >First Name</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input name="f_name"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              placeholder="Steve" 
            />
          </div>
        </div>
        <div class="p-2 w-1/2">
          <label class="block text-sm leading-5 font-medium text-gray-700"
            >Last Name</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
            name="l_name"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              placeholder="Jobs"
            />
          </div>
        </div>

        <div class="p-2 w-1/2">
          <label
            for="price"
            class="block text-sm leading-5 font-medium text-gray-700"
            >Date in</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
            name="date_in"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              type="date"
            />
          </div>
        </div>

        <div class="p-2 w-1/2">
          <label
            for="price"
            class="block text-sm leading-5 font-medium text-gray-700"
            >Date Out</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
            name="date_out"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              type="date"
            />
          </div>
        </div>

        <div class="p-2 w-1/2">
          <label
            for="price"
            class="block text-sm leading-5 font-medium text-gray-700"
            >DOB</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
               name="dob"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              type="date"
            />
          </div>
        </div>
        <div class="p-2 w-1/2">
          <label
            for="price"
            class="block text-sm leading-5 font-medium text-gray-700"
            >Height(in cms)</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
              name="height"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              type="text"
            />
          </div>
        </div>
        <div class="p-2 w-1/2">
          <label class="block text-sm leading-5 font-medium text-gray-700"
            >Address</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
            name="addr"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              type="text"
            />
          </div>
        </div>
        <div class="p-2 w-1/2">
          <label class="block text-sm leading-5 font-medium text-gray-700"
            >Section ID</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <input
            name="section_id"
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"
              type="text"
            />
          </div>
        </div>
        <!--
        <div class="p-2 w-full">
          <label class="block text-sm leading-5 font-medium text-gray-700"
            >Description</label
          >
          <div class="mt-1 relative rounded-md shadow-sm">
            <textarea
              class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none h-48 focus:border-indigo-500 text-base px-4 py-2 resize-none block"
              placeholder="Description"
            ></textarea>
          </div>
        </div>
        -->
        <div class="p-2 w-full">
          <button
            name="crime_prisoner_add" type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
          >
            Submit
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
</form>
';}else{
  header("Location: ./failure.php");
        exit();

}

?>
<footer class="text-gray-700 body-font" style="  left: 0; bottom: 0;width: 100%; text-align: center;">
    <div class="bg-gray-200">
      <div
        class="container px-5 py-6 mx-auto flex items-center sm:flex-row flex-col"
      >
      <a
          class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full"
            viewBox="0 0 24 24"
          >
            <path
              d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
            ></path>
          </svg>
          <span class="ml-3 text-xl">Prison Management System</span>
        </a>
        <p class="text-sm text-gray-500 sm:ml-6 sm:mt-0 mt-4">
          © 2021 — Ayuj, Tuhin, Anish
        </p>
        <span
          class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start"
        >
          <a class="text-gray-500"> Made with ❤️ </a>
        </span>
      </div>
    </div>
  </footer>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
</body>
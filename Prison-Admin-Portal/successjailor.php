<?php
    require "./header.php";
?>
    <!-- hero -->
    <div class="hero bg-gray-100 py-16 h-screen">
        <!-- container -->
        <div class="container px-4 sm:px-8 lg:px-16 xl:px-20 mx-auto">
            <!-- hero wrapper -->
            <div class="hero-wrapper grid grid-cols-1 md:grid-cols-12 gap-8 items-center">

                <!-- hero text -->
                <div class="hero-text col-span-6">
                    <h1 class=" font-bold text-4xl md:text-5xl max-w-xl text-gray-900 leading-tight">Operation Successful</h1>
                    <hr class=" w-12 h-1 bg-indigo-500 rounded-full mt-8">
                    <p class="text-gray-800 text-base leading-relaxed mt-8 font-semibold">Jailor added successfully!</p>
                    <p class="text-gray-800 text-base leading-relaxed mt-8 font-semibold">Click <a href="./jailor.php" class="text-green-600">here</a> to add another</p>

                </div>

                <!-- hero image -->
                <div class="hero-image col-span-6">
                    <img src="./success.svg" alt="success">
                </div>
            </div>
        </div>
    </div><!-- end hero -->
<?php
    require "./footer.php";
?>
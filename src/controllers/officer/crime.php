<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

// Check if user is logged in and has officer role
if (!$auth->isLoggedIn() || !$auth->hasRole('officer')) {
    redirect('home');
}

$errors = ["emptyfields" => "Empty fields!!", "sqlerror" => "SQL database connection error!!"];

if (isset($_SESSION['userUidOfficer'])) {
    if (isset($_GET['error']) && isset($errors[$_GET['error']])) {
        echo '<h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-red-600">' .
            $errors[$_GET['error']] .
            '</h2>';
    }
    ?>
    <form action="<?php echo SRC_PATH; ?>/includes/database/crime.inc.php" method="post">
        <div class="flex flex-col h-screen">
            <section class="text-gray-700 body-font relative flex-grow">
                <div class="container px-5 my-5 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                            Crime Registration
                        </h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                            Add a Crime!
                        </p>
                    </div>
                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">First Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="f_name" placeholder="First Name"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Last Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="l_name" placeholder="Last Name"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Date In</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="date_in" type="date"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Date Out</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="date_out" type="date"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Date of Birth</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="dob" type="date"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Height</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="height" placeholder="Height"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Address</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <textarea name="addr" placeholder="Address"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10"></textarea>
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Section ID</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="section_id" placeholder="Section ID"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">IPC</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <select name="IPC[]" multiple
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-24">
                                        <?php
                                        $sql = "SELECT * FROM Ipc";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();
                                        $ipcs = $stmt->fetchAll();
                                        foreach ($ipcs as $ipc) {
                                            echo "<option value='" .
                                                $ipc['IPC'] .
                                                "'>" .
                                                $ipc['IPC_name'] .
                                                '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button name="crime_prisoner_add" type="submit"
                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
    <?php
} else {
     ?>
    <div class="hero bg-gray-100 py-16 h-screen">
        <div class="container px-4 sm:px-8 lg:px-16 xl:px-20 mx-auto">
            <div class="hero-wrapper grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="hero-text col-span-6">
                    <h1 class=" font-bold text-4xl md:text-5xl max-w-xl text-gray-900 leading-tight">Operation Failed</h1>
                    <hr class=" w-12 h-1 bg-indigo-500 rounded-full mt-8">
                    <p class="text-gray-800 text-base leading-relaxed mt-8 font-semibold">Access Denied</p>
                </div>
                <div class="hero-image col-span-6">
                    <img src="assets/images/failure.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <?php
}
require_once SRC_PATH . "/views/layouts/footer.php";
?>
</div>

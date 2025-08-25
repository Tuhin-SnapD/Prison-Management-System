<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

// Check if user is logged in and has admin role
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
}

$errors = [
    "sqlerror" => "SQL database connection error!!",
    "reserror" => "Reservation error!!"
];

if (isset($_GET['error']) && isset($errors[$_GET['error']])) {
    echo '<h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-red-600">'
        . $errors[$_GET['error']] .
        '</h2>';
}
?>
    <form action="<?php echo SRC_PATH; ?>/includes/database/visitor.inc.php" method="post">
        <div class="flex flex-col h-screen">
            <section class="text-gray-700 body-font relative flex-grow">
                <div class="container px-5 my-5 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
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
                                <label class="block text-sm leading-5 font-medium text-gray-700">Aadhaar Number</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="aadhaar" placeholder="Aadhaar Number"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Date of Visit</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="date_visit" type="date"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Time Slot</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="time_slot" placeholder="Time Slot"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Prisoner ID</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="prisoner_id" placeholder="Prisoner ID"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button name="visitor_add" type="submit"
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
require_once SRC_PATH . "/views/layouts/footer.php";
?>
</div>

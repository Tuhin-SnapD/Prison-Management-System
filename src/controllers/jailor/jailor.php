<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";

// Check if user is logged in and has admin role
if (!$auth->isLoggedIn() || !$auth->hasRole('admin')) {
    redirect('home');
}

$errors = [
    "emptyfields" => "Empty fields!!",
    "sqlerror" => "SQL database connection error!!",
    "passwordnotmatched" => "Re-enter correct password!!",
    "sameuserexistserror" => "Same user exists!!"
];

if (isset($_GET['error']) && isset($errors[$_GET['error']])) {
    echo '<h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-red-600">'
        . $errors[$_GET['error']] .
        '</h2>';
}
?>
    <form action="<?php echo SRC_PATH; ?>/includes/database/jailor.inc.php" method="post">
        <div class="flex flex-col h-screen">
            <section class="text-gray-700 body-font relative flex-grow">
                <div class="container px-5 my-5 mx-auto">
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">
                            Jailor Registration
                        </h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                            Add a Jailor!
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
                                <label class="block text-sm leading-5 font-medium text-gray-700">Mobile Number</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="mob_number" placeholder="9876543210"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Username</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="username" placeholder="UserName"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Password</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="password" type="password" placeholder="Password"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <label class="block text-sm leading-5 font-medium text-gray-700">Confirm Password</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="cfmpassword" type="password" placeholder="Confirm Password"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
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
                                <label class="block text-sm leading-5 font-medium text-gray-700">Section Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input name="section_name" placeholder="Section Name"
                                        class="w-full bg-gray-100 rounded border border-gray-400 focus:outline-none focus:border-indigo-500 text-base form-input block w-full px-3 h-10" />
                                </div>
                            </div>
                            <div class="p-2 w-full">
                                <button name="jailor_add" type="submit"
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

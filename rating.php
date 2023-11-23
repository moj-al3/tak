<?php include "snippets/base.php" ?>
<?php
require("snippets/force_loggin.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "snippets/layout/head.php" ?>


    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
 

    <style>
        input:checked + label span {
  color: #ff9900; /* يمكنك تغيير اللون حسب تفضيلك */
}
    </style>

</head>

<body class="body" style="background-image: unset !important;">
    <?php include "snippets/layout/header.php" ?>
    <main class="mb-12">
   
<button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
 Open
</button>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Terms of Service
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
            <div class=" ">
                <h2 class="text-2xl font-bold mb-6">Service Rating</h2>

                <!-- Rating Form -->
                <form  class="space-y-4">
                    <!-- Rating Selection -->
                    <div class="flex items-center space-x-4 justify-center">
                        <!-- <label for="rating" class="text-lg">Rating:</label> -->
                        <ul class="my-1 flex list-none gap-2 p-0" data-te-rating-init data-te-dynamic="true" data-te-active="bg-current rounded-[50%] !fill-black">
                            <li>
                                <input type="radio" name="rating" id="star1" value="star1" class="hidden" />
                                <label for="star1" class="cursor-pointer">
                                    <span class="text-[#673ab7] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current" data-te-rating-icon-ref>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm72.4-118.5c9.7-9 10.2-24.2 1.2-33.9C315.3 344.3 290.6 328 256 328s-59.3 16.3-73.5 31.6c-9 9.7-8.5 24.9 1.2 33.9s24.9 8.5 33.9-1.2c7.4-7.9 20-16.4 38.5-16.4s31.1 8.5 38.5 16.4c9 9.7 24.2 10.2 33.9 1.2zM176.4 272c17.7 0 32-14.3 32-32c0-1.5-.1-3-.3-4.4l10.9 3.6c8.4 2.8 17.4-1.7 20.2-10.1s-1.7-17.4-10.1-20.2l-96-32c-8.4-2.8-17.4 1.7-20.2 10.1s1.7 17.4 10.1 20.2l30.7 10.2c-5.8 5.8-9.3 13.8-9.3 22.6c0 17.7 14.3 32 32 32zm192-32c0-8.9-3.6-17-9.5-22.8l30.2-10.1c8.4-2.8 12.9-11.9 10.1-20.2s-11.9-12.9-20.2-10.1l-96 32c-8.4 2.8-12.9 11.9-10.1 20.2s11.9 12.9 20.2 10.1l11.7-3.9c-.2 1.5-.3 3.1-.3 4.7c0 17.7 14.3 32 32 32s32-14.3 32-32z" />
                                        </svg>
                                    </span>
                            </li>
                            <li>
                            <input type="radio" name="rating" id="star2" value="star2" class="hidden" />
                                <label for="star2" class="cursor-pointer">
                                <span class="text-[#3f51b5] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current" data-te-rating-icon-ref>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                </span>
                            </li>
                            <li>
                            <input type="radio" name="rating" id="star3" value="star3" class="hidden" />
                                <label for="star3" class="cursor-pointer">
                                <span class="text-[#2196f3] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current" data-te-rating-icon-ref>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM176.4 240a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm192-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM184 328c-13.3 0-24 10.7-24 24s10.7 24 24 24H328c13.3 0 24-10.7 24-24s-10.7-24-24-24H184z" />
                                    </svg>
                                </span>
                            </li>
                            <li>
                            <input type="radio" name="rating" id="star4" value="star4" class="hidden" />
                                <label for="star4" class="cursor-pointer">
                                <span class="text-[#03a9f4] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current" data-te-rating-icon-ref>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                    </svg>
                                </span>
                            </li>
                            <li>
                            <input type="radio" name="rating" id="star5" value="star5" class="hidden" />
                                <label for="star5" class="cursor-pointer">
                                <span class="text-[#00bcd4] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current" data-te-rating-icon-ref>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM183.2 132.6c-1.3-2.8-4.1-4.6-7.2-4.6s-5.9 1.8-7.2 4.6l-16.6 34.7-38.1 5c-3.1 .4-5.6 2.5-6.6 5.5s-.1 6.2 2.1 8.3l27.9 26.5-7 37.8c-.6 3 .7 6.1 3.2 7.9s5.8 2 8.5 .6L176 240.5l33.8 18.3c2.7 1.5 6 1.3 8.5-.6s3.7-4.9 3.2-7.9l-7-37.8L242.4 186c2.2-2.1 3.1-5.3 2.1-8.3s-3.5-5.1-6.6-5.5l-38.1-5-16.6-34.7zm160 0c-1.3-2.8-4.1-4.6-7.2-4.6s-5.9 1.8-7.2 4.6l-16.6 34.7-38.1 5c-3.1 .4-5.6 2.5-6.6 5.5s-.1 6.2 2.1 8.3l27.9 26.5-7 37.8c-.6 3 .7 6.1 3.2 7.9s5.8 2 8.5 .6L336 240.5l33.8 18.3c2.7 1.5 6 1.3 8.5-.6s3.7-4.9 3.2-7.9l-7-37.8L402.4 186c2.2-2.1 3.1-5.3 2.1-8.3s-3.5-5.1-6.6-5.5l-38.1-5-16.6-34.7zm6.3 175.8c-28.9 6.8-60.5 10.5-93.6 10.5s-64.7-3.7-93.6-10.5c-18.7-4.4-35.9 12-25.5 28.1c24.6 38.1 68.7 63.5 119.1 63.5s94.5-25.4 119.1-63.5c10.4-16.1-6.8-32.5-25.5-28.1z" />
                                    </svg>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!-- Submit Button -->
                    <div class="flex justify-center">
                    <button class="mx-auto px-5 w-60 mt-3 bg-red-500 text-gray-100 text-center rounded-xl">Submit</button>
                    </div>
                   
                    <!-- <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Submit</button> -->
                </form>
            </div>
            </div>
            <!-- Modal footer -->
           
        </div>
    </div>
</div>




    </main>
    <?php include "snippets/layout/footer.php" ?>
    <!-- Javascript -->
    <?php include "snippets/layout/scripts.php" ?>
    <?php include "snippets/layout/messages.php" ?>
    <script src="/assets/js/profile-tarkken.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>

    <script>
        $(function() {
            // trigger form editing when the edit icon is clicked
            $("#edit").on("click", function() {
                $("#edit").addClass("hide");
                $("#save").removeClass("hide");
                $(".editable").removeAttr('readonly');
            });

            $("#save").on("click", async function() {
                var resonse = await Swal.fire({
                    title: "Confirmation",
                    text: "Are you sure you want to save the changes?",
                    confirmButtonText: "Yes",
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    cancelButtonColor: '#ff0050',

                });
                if (resonse.isConfirmed) {
                    $("#user-form").submit();
                }
            });
        });
    </script>
</body>

</html>
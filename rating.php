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
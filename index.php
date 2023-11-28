<?php include "./snippets/base.php" ?>
<!DOCTYPE html>
<html lang="en">


<head>

    <?php include "./snippets/layout/head.php" ?>
    <link rel="stylesheet" href="./assets/css/landing.css">

    <!--  Custom Head Values  -->
    <title>Landing</title>

</head>

<body class="lan">
<?php include "./snippets/layout/header.php" ?>

<div id="content" class=" index">
    <div class="test-landing">
    <div class="landing">
        <h1>Best parking spaces for your vehicles</h1>
        <h4>Online parking</h4>
    </div>

    </div>
    <div class="enter">
        <button type="button" onclick="window.location.href = '/auth/login.php'" class="bg-sky-500 text-white font-medium rounded-lg p-3">Enter</button>
    </div>
</div>



<?php include "./snippets/layout/footer.php" ?>


<!-- Javascripts -->
<?php include "./snippets/layout/scripts.php" ?>
<script src="./assets/js/header.js"></script>

</body>

</html>
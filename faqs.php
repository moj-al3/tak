<?php include "./snippets/base.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "./snippets/layout/head.php" ?>

    <title>Parking Reservation FAQs</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    main {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    .faq-item {
        margin-bottom: 20px;
        border-bottom: 3px solid #ccc;
        padding-bottom: 20px;
        cursor: pointer;
        /* Add cursor pointer for better UX */
    }

    .question {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .answer {
        color: rgb(31 41 55);
        max-height: 0;
        overflow: hidden;
        transition: max-height 4s ease-in-out;
        text-align: justify;

        /* Add transition for smooth effect */
    }

    .answer.show {
        max-height: 1000px; /* Adjust to a value greater than the maximum height of your answers */
    }

    h1 {
        padding-right: 750PX;
        /* font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; */
        margin: 50px;
        margin-bottom: 0;
        text-indent: 3rem;
        font-size: 50px;
        color: red;
    }
    /* Media Queries */
    @media (max-width: 768px) {
        h1 {
            padding-right: 290px;
            text-indent: 0;
            font-size: 50px;
        }

        h2 {
            font-size: 20px;
        }

        .question {
            font-size: 20px;
        }
    }
</style>

</head>

<body>
    <?php include "./snippets/layout/header.php" ?>
    
    <h1 class="faq-tittle">FAQs</h1>
    <main>
        <div class="faq-item" onclick="toggleAnswer('faq1')">
            <h2 class="question">How can I reserve a parking space on the website?</h2>
            <p class="answer" id="faq1">to reserve a parking for your car,in the beginning you need to create an account,
                through which you enter your personal information and determine whether you are a visitor or a KFU member after entering the site,
                you will go to the reservations page to choose the appropriate parking for you depending on the type of user
            </p>
        </div>

        <div class="faq-item" onclick="toggleAnswer('faq2')">
            <h2 class="question">Is there a fee for parking reservations?</h2>
            <p class="answer" id="faq2">No, there is not.</p>
        </div>

        <div class="faq-item" onclick="toggleAnswer('faq3')">
            <h2 class="question">Can I modify or cancel my parking reservation?</h2>
            <p class="answer" id="faq3"> Yes , you can</p>
        </div>

        <div class="faq-item" onclick="toggleAnswer('faq4')">
            <h2 class="question">What happens if I arrive late for my reserved parking slot?</h2>
            <p class="answer" id="faq4">If you arrive late for your previously scheduled reservation time, your reservation will be cancelled,\
                 but before the reservation time expires, a reminder message will be sent so that you can extend the time or if you need more time ,
                  you can reserve again.</p>
        </div>

        <div class="faq-item" onclick="toggleAnswer('faq5')">
            <h2 class="question">Is my reservation transferable to another user?</h2>
            <p class="answer" id="faq5">No, parking reservations are non-transferable and can only be used by the account holder who made the reservation.</p>
        </div>
        <!-- Add more FAQ items as needed -->
    </main>

    <script>
    function toggleAnswer(faqId) {
        const answer = document.getElementById(faqId);

        if (answer.classList.contains('show')) {
            answer.classList.remove('show');
        } else {
            answer.classList.add('show');
        }
    }
</script>


    <?php include "./snippets/layout/footer.php" ?>
    <!-- Javascripts -->
    <?php include "./snippets/layout/scripts.php" ?>
    <script src="./assets/js/header.js"></script>
</body>

</html>
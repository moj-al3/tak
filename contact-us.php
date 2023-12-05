<?php include "./snippets/base.php" ?>
<?php include "./snippets/emailSender.php" ?>
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have form fields with name attributes 'name', 'email', and 'message'
    $name = $_POST['first_name'] . " " . $_POST['last_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    // Send email to the system admin
    sendContactUsEmail($name, $email, $message);

    // send a confirmation email to the user
    sendEmail($email, 'Contact Us Form Submission Confirmation', 'Thank you for contacting us. We will get back to you soon.');
    $_SESSION['messages'] = [["text" => "Thank you for contacting us. We will get back to you soon.", "type" => "success"]];
}


?>
<!DOCTYPE html>
<html>

<head>
    <?php include "./snippets/layout/head.php" ?>

    <title>Contact Us</title>
    <style>
        h1 {
            color: #333;
            font-size: 50px;
        }

        .form-container {
            width: 100%;
            box-shadow: 1px 1px 10px -1px #979797;
        }


        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;

        }

        input,
        textarea {
            width: 95%;
            margin: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            background-color: transparent;
            background-color: #f9f9f9;
            /* Set background color to a slightly lighter gray */

        }

        .contact-btn {
            background-color: #FF0050;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 20%;
            /* align-items: center; */
            margin-left: 200px;
        }

        .card {
            background-color: #fff;
            padding: 40px;
            margin-top: 20px;
            /* box-shadow: 0 0 100px rgba(0, 0, 0, 0.1); */
            border-radius: 8px;
            /* width: 500px; */
            margin-bottom: 100px;
            box-shadow: 1px 1px 10px -1px black;
        }

        @media only screen and (max-width: 375px) {

            h1 {
                font-size: 30px;
                font-family: 'Fira Sans', sans-serif;
                font-family: 'Poppins', sans-serif;
                font-family: 'Roboto', sans-serif;
            }

            .form-container {
                padding: 10px;
            }

            .card {
                width: 95%;
                margin: auto;

            }
        }
    </style>
</head>

<body>
    <?php include "./snippets/layout/header.php" ?>

    <div class="container">
        <h1 style="color:#FF0050; ">We are here to help you!</h1>
        <h4 style="text-align: center;">If you have any suggestions or any problems, we are happy with contact us </h4>
        <form id="contact-form" class="card" onsubmit="showConfirmationMessage(this);return false" method="post">
            <h2>Do You Need Help?</h2>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="contact-btn">Submit</button>
        </form>

        <div id="success-message" class="success-message" style="display: none;">
            Your message has been sent successfully. We will get back to you soon!
        </div>
    </div>

    <script src="/assets/js/sweetalert2.all.min.js"></script>
    <script>
        async function showConfirmationMessage(form) {
            const result = await Swal.fire({
                title: "Are you sure?",
                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText: "Cancel",
                cancelButtonColor: '#d33',
            })

            if (result.isConfirmed) {
                form.submit();
            }
        }
    </script>

    <?php include "./snippets/layout/footer.php" ?>
    <!-- Javascripts -->
    <?php include "./snippets/layout/scripts.php" ?>
    <?php include "./snippets/layout/messages.php" ?>
    <script src="./assets/js/header.js"></script>

</body>

</html>
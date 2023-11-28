<?php include "./snippets/base.php" ?>

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
            background-color: #f9f9f9; /* Set background color to a slightly lighter gray */
          
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
            margin-left:200px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
            /* box-shadow: 0 0 100px rgba(0, 0, 0, 0.1); */
            border-radius: 8px;
            width: 500px;
            margin-bottom: 100px;
            box-shadow: 1px 1px 10px -1px black;
        }
    </style>
</head>

<body>
    <?php include "./snippets/layout/header.php" ?>

    <div class="container">
        <h1>Contact Us</h1>
        <form id="contact-form" class="card">
            <div class="form-group">
                <label for="name">First Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="name">Last Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button value="submit" id="submit" type="submit" class="contact-btn">Submit</button>
        </form>

        <div id="success-message" class="success-message" style="display: none;">
            Your message has been sent successfully. We will get back to you soon!
        </div>
    </div>

    <script src="/assets/js/sweetalert2.all.min.js"></script>
    <script>
        document.getElementById("contact-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);

            // You can send the form data to the server using AJAX or fetch API
            // Here's an example using fetch API
            fetch(form.action, {
                    method: form.method,
                    body: formData
                })
                .then(function(response) {
                    if (response.ok) {
                        form.reset();
                        document.getElementById("success-message").style.display = "block";
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                });
        });

        function sure() {
            Swal.fire({
                title: "Are you sure?",
             

                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText: "Cancel",
                cancelButtonColor: '#d33',

            })

        }


        // define setup
        function setup() {
            // get reference to button


            var btn = document.getElementById("submit");
            // add event listener for the button, for action "click"
            btn.addEventListener("click", sure);

        }

        window.onload = setup;
    </script>
    <?php include "./snippets/layout/footer.php" ?>
    <!-- Javascripts -->
    <?php include "./snippets/layout/scripts.php" ?>
    <script src="./assets/js/header.js"></script>

</body>

</html>
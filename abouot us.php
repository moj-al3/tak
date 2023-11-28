<?php include "./snippets/base.php" ?>
<!DOCTYPE html>
<html lang="en">


<head>

    <?php include "./snippets/layout/head.php" ?>

    <title>About us </title>
    <style>
        .container {
            height: 100vh;
        }

        .heading h1 {
            font-size: 50px;
            margin-bottom: 25px;
            position: relative;
        }

        .about.us-container {
            width: 90%;
            margin: 0 auto;
            padding: 10px 20px;
        }

        .about {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .about-img {
            flex: 1;
            margin-right: 30px;
            overflow: hidden;
        }

        .about-img img {
            max-width: 100%;
            height: auto;
            display: block;
            transition: 0.6s ease;
        }

        .about-img:hover img {
            transform: scale(1.2);
        }

        .about-content {
            flex: 1;
        }

        .about-content p {
            font-size: 18px;
            line-height: 1.5em;
            color: #666;
            word-wrap: break-word;
            max-width: 500px;
            text-align: justify;
        }

        @media screen and (max-width:1023px) {
            .heading {
                padding: 0px 20px;
            }

            .heading h1 {
                font-size: 36px;
            }

            .about.us-container {
                padding: 0px;
            }

            .about {
                padding: 20px;
                flex-direction: column;
            }

            .about-img {
                margin-right: 0px;
                margin-bottom: 20px;
            }

            .about-content p {
                padding: 0px;
                font-size: 20px;
            }

        }

        @media screen and (max-width:768px) {

            .heading {
                padding: 0px 20px;
            }

            .heading h1 {
                font-size: 36px;
            }

            .about.us-container {
                padding: 0px;
            }

            .about {
                padding: 20px;
                flex-direction: column;
            }

            .about-img {
                margin-right: 0px;
                margin-bottom: 20px;
            }

            .about-content p {
                padding: 0px;
                font-size: 16px;
            }
        }
    </style>

</head>

<body>
    <?php include "./snippets/layout/header.php" ?>

    <div class="container">
        <div class="heading">
            <h1>About us </h1>
        </div>
        <div class="about.us-container">
            <section class="about">
                <div class="about-img">
                    <img src="/assets/img/parking.jpg" alt="">
                </div>
                <div class="about-content">
                    <p>Welcome to Tarkeen, the ultimate destination for effortless parking solutions. Our user-friendly website is designed to make finding and reserving parking spaces a breeze. With just a few clicks, you can search for parking options in your desired location, conveniently view the availability of parking spots in real-time, and effortlessly make reservations. Our extensive network of parking facilities ensures that you'll always find the perfect spot to suit your needs, whether you're attending a special event, exploring the university, or have class . Rest assured, we prioritize your convenience and security, providing you with a seamless parking experience that you can trust. Say goodbye to the stress of finding parking and let Tarkeen handle it all for you.</p>
                </div>
            </section>
        </div>
    </div>

    <?php include "./snippets/layout/footer.php" ?>
    <!-- Javascripts -->
    <?php include "./snippets/layout/scripts.php" ?>
    <script src="./assets/js/header.js"></script>

</body>

</html>
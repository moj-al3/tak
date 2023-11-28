<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<nav>
    <div class="nav-cont">
        <ul class="menu-icon">
            <li class="item">
                <button class="menu-btn">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </li>
        </ul>
        <div class='cont-menu'>
            <ul class="menu menu-logo">
                <li class="logo"><a href="/"><img src="../assets/img/logo2.png" alt=""></a></li>
            </ul>
            <ul class="menu desk-menu">
                <?php if (isset($user)): ?>
                    <li class="item"><a href="/home.php">Home</a></li>
                    <li class="item"><a href="/reservations/create.php">Reservation</a></li>
                    <?php if ($user["user_type_id"] == 3): ?>
                        <li class="item"><a href="/violations/create.php">Violations</a></li>
                        <li class="item"><a href="/reservations/scan.php">QR scanning</a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="item"><a href="/about-us.php">About us</a></li>
                <li class="item"><a href="/contact-us.php">Contact us</a></li>


                <!-- </li> -->

            </ul>
        </div>
        <ul class="menu">
            <?php if (isset($user)): ?>
                <li class="item av">
                    <!--            <div class="img-ava">-->
                    <!--            <div class="avatar-img">-->
                    <!--                <img src="../assets/img/avatar.png" alt="user-image" width="100%" height="auto">-->
                    <!--            </div>-->
                    <!--            </div>-->
                    <div class="drop-menu-prof">
                        <ul>
                            <li>
                                <a href="/auth/logout.php" class="drop-item">
                            <span>
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </span>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="item button secondary"><a href="/home.php"><?php echo $user['first_name']; ?></a></li>
                <li class="item button"><a href="/auth/logout.php">Log Out</a></li>
            <?php else: ?>
                <li class="item button"><a href="/auth/login.php">Log In</a></li>
            <?php endif; ?>
            <!-- <li class="toggle"><span class="bars"></span></li> -->
        </ul>
    </div>
    <div class="nav-cont mobile-nav-cont">
        <ul class="menu modile-menu">
            <?php if (isset($user)): ?>
                <li class="item"><a href="/home.php">Home</a></li>
                <li class="item"><a href="/reservations/create.php">Reservation</a></li>
                <?php if ($user["user_type_id"] == 3): ?>
                    <li class="item"><a href="/violations/create.php">Violations</a></li>
                    <li class="item"><a href="/reservations/scan.php">QR scanning</a></li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="item"><a href="/about-us.php">About us</a></li>
            <li class="item"><a href="/">Contact us</a></li>

        </ul>
    </div>
</nav>


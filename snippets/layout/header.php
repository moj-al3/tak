<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<nav>
    <ul class="menu">
        <li class="logo"><a href="/"><img src="/assets/img/logo2.png" alt=""></a></li>
        <li class="item"><a href="/home.php">Home</a></li>
        <li class="item"><a href="#">About</a></li>
        <li class="item"><a href="#">Services</a></li>
        <li class="item"><a href="#">history</a></li>
        </li>
        <?php if (isset($user)): ?>
            <li class="item button secondary"><a href="/profile.php"><?php echo $user['first_name']; ?></a></li>
            <li class="item button"><a href="/auth/logout.php">Log Out</a></li>
        <?php else: ?>
            <li class="item button"><a href="/auth/login.php">Log In</a></li>
            <li class="item button secondary"><a href="/auth/signup.php">Sign Up</a></li>
        <?php endif; ?>







        <li class="toggle"><span class="bars"></span></li>
    </ul>
</nav>
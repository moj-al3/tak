<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<?php
if (!empty($_SESSION['messages'])) {
    echo '<script>';
    echo 'var messages = ' . json_encode($_SESSION['messages']) . ';';
    echo '</script>';
}
$_SESSION['messages'] = [];
?>
<script>
    if (typeof messages !== 'undefined' && Array.isArray(messages)) {
        messages.forEach((message) => {
            Swal.fire({
                text: message.text,
                icon: message.type,
                showConfirmButton: false,
            });
        });
    }
</script>

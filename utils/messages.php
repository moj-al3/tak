<?php
require_once("../auth/start_session.php");

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

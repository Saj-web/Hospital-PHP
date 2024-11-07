<?php
    session_start();
    unset($_SESSION['nurse_id']);
    unset($_SESSION['nurse_number']);
    session_destroy();

    header("Location: his_doc_logout.php");
    exit;
?>
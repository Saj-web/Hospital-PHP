<?php
include('assets/inc/config.php');

$nurse_id = (isset($_GET['delete'])) ? $_GET['delete'] : '';

if (!empty($nurse_id)) {
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "DELETE FROM his_nurse WHERE nurse_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $nurse_id);
    $stmt->execute();

    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Record deleted successfully.";
        header('Location: his_admin_view_nurse.php');
        exit;
    }

    $stmt->close();
    $mysqli->close();
}
?>
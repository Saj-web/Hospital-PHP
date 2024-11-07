<?php
include('assets/inc/config.php');

$doc_id = (isset($_GET['delete'])) ? $_GET['delete'] : '';

if (!empty($doc_id)) {
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "DELETE FROM his_docs WHERE doc_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $doc_id);
    $stmt->execute();

    if ($stmt->errno) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Record deleted successfully.";
        header('Location: his_admin_view_employee.php');
        exit;
    }

    $stmt->close();
    $mysqli->close();
}
?>
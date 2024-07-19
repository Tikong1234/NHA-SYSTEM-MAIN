<?php
include 'include/config.php';
header('Content-Type: application/json');

if (isset($_GET['block_number'])) {
    $block_number = $_GET['block_number'];
    $status = 'Unoccupied';
    
 

    if ($bd->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $bd->connect_error]));
    }

    $query = $bd->prepare("SELECT lot_number FROM block_lot WHERE block_number = ? AND status = ?");
    $query->bind_param("ss", $block_number, $status);
    $query->execute();
    $result = $query->get_result();

    $lot_numbers = array();
    while ($row = $result->fetch_assoc()) {
        $lot_numbers[] = $row;
    }
    
    echo json_encode($lot_numbers);

    $query->close();
    $bd->close();
} else {
    echo json_encode(["error" => "No block number provided"]);
}
?>

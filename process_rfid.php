<?php
include_once __DIR__ . '/includes/session.php';

// Check if RFID data is received via POST kaya pala may echo amp di anaassign
if (isset($_POST['rfid'])) {
    // Get RFID data from POST request
    $rfidTag = $_POST['rfid'];

    $_SESSION['rfid'] = $rfidTag;
    
    // Prepare PHP code that will be written to the file
    // Write the PHP code to the rfid_container.php file
    $phpCode = "<?php $" . "rfidTag = '" . $rfidTag . "'; " . "echo $" . "rfidTag; ?>";


    $result = file_put_contents('rfid_container.php', $phpCode);

    if ($result === false) {
        echo "Error: Unable to write to rfid_container.php.";
    } else {
        echo "RFID Tag successfully saved to rfid_container.php.";
    }
}

?>
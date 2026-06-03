<?php
require_once 'database_connection.php';

try {
    $conn = getConnection();
    
    // Drop the incentive_transactions table
    $sql = "DROP TABLE IF EXISTS incentive_transactions";
    
    if ($conn->query($sql)) {
        echo "Table 'incentive_transactions' has been successfully deleted.\n";
    } else {
        echo "Error deleting table: " . $conn->error . "\n";
    }
    
    closeConnection();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>


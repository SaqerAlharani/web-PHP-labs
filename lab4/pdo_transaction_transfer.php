<?php
/*
====================================================
PDO Transaction Transfer Lab
Student Name: صقر الحراني
====================================================
*/

$db_connection = null;

try {

    $connection_settings = "mysql:host=localhost;dbname=banks;charset=utf8mb4";
    $db_user = "root";
    $db_pass = "";

    // Connect to the database
    $db_connection = new PDO($connection_settings, $db_user, $db_pass);
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Transaction parameters
    $sender_id   = 1;
    $receiver_id = 2;
    $transfer_sum = 500;

    // Start database transaction
    $db_connection->beginTransaction();

    // Verify sender funds
    $query = $db_connection->prepare("SELECT balance FROM accounts WHERE id = ?");
    $query->execute([$sender_id]);
    $current_balance = $query->fetchColumn();

    if ($current_balance === false) {
        throw new Exception("Source account not found");
    }

    if ($current_balance < $transfer_sum) {
        throw new Exception("Insufficient account balance");
    }

    // Deduct amount from sender
    $update_sender = $db_connection->prepare(
        "UPDATE accounts SET balance = balance - ? WHERE id = ?"
    );
    $update_sender->execute([$transfer_sum, $sender_id]);

    // Credit amount to receiver
    $update_receiver = $db_connection->prepare(
        "UPDATE accounts SET balance = balance + ? WHERE id = ?"
    );
    $update_receiver->execute([$transfer_sum, $receiver_id]);

    // Log the transaction
    $log_transaction = $db_connection->prepare(
        "INSERT INTO transactions (from_account, to_account, amount, created_at)
         VALUES (?, ?, ?, NOW())"
    );
    $log_transaction->execute([$sender_id, $receiver_id, $transfer_sum]);

    // Finalize transaction
    $db_connection->commit();

    echo "Funds transferred successfully.";

} catch (Exception $err) {

    // Revert changes if something went wrong
    if ($db_connection !== null && $db_connection->inTransaction()) {
        $db_connection->rollBack();
    }

    // Capture error in log file
    error_log(
        "[" . date("Y-m-d H:i:s") . "] Error: " . $err->getMessage() . PHP_EOL,
        3,
        "transfer_errors.log"
    );

    // Generic error message
    echo "Transaction failed. Please try again later.";
}
?>

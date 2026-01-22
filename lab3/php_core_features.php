<?php
/*
====================================================
PHP Core Features Demonstration
Student Name: صقر الحراني
====================================================
*/


/* ================================================
   DATE & TIME FUNCTIONS
================================================ */

echo "System Clock: " . date("d-m-Y | H:i:s") . "<br>";
echo "Unix Epoch Seconds: " . time() . "<br>";

$specificDate = mktime(10, 0, 0, 1, 1, 2026);
echo "New Year 2026: " . date("l, d F Y", $specificDate) . "<br>";

$nextMonday = strtotime("next Monday");
echo "Coming Monday: " . date("Y/m/d", $nextMonday) . "<br>";

echo "Full Date Details:<br>";
print_r(getdate());
echo "<br>";

$startDate = date_create("2026-01-01");
$endDate = date_create("2026-01-22");
$interval = date_diff($startDate, $endDate);

echo "Days elapsed since New Year: " . $interval->format("%a days") . "<br>";

usleep(500000); // Sleep for 0.5 seconds


/* ================================================
   FILE HANDLING
================================================ */

$dataFile = "data_log.txt";

file_put_contents($dataFile, "Initialization of PHP core features lab.\n");
echo "File Content: " . nl2br(file_get_contents($dataFile));

if (file_exists($dataFile) && is_readable($dataFile)) {
    echo "<br>Data log file is accessible.<br>";
}


/* ================================================
   DIRECTORY HANDLING
================================================ */

$workDir = "storage_dir";

if (!is_dir($workDir)) {
    mkdir($workDir);
    echo "Directory '$workDir' initialized.<br>";
}

echo "Directory Listing:<br>";
print_r(scandir($workDir));
echo "<br>";


/* ================================================
   SIMPLE LOG SYSTEM
================================================ */

$auditLog = "system_audit.log";

if (!file_exists($auditLog)) {
    file_put_contents($auditLog, "[" . date("Y-m-d H:i:s") . "] Audit log initialized\n");
} else {
    file_put_contents($auditLog, "[" . date("Y-m-d H:i:s") . "] New operation logged\n", FILE_APPEND);
}


/* ================================================
   DATABASE CONNECTION USING MySQLi
================================================ */

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "lab_features_db";

/* Connect without selecting database */
$conn = new mysqli($dbHost, $dbUser, $dbPass);

if ($conn->connect_error) {
    die("MySQLi Connection failed: " . $conn->connect_error);
}

/* Create database if not exists */
$createDbSql = "CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
$conn->query($createDbSql);

/* Select database */
$conn->select_db($dbName);
$conn->set_charset("utf8mb4");

echo "MySQLi: Connected to '$dbName' successfully.<br>";


/* ================================================
   DATABASE CONNECTION USING PDO
================================================ */

try {
    /* Connect without database */
    $pdoObj = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUser, $dbPass);
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* Create database */
    $pdoObj->exec("CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    /* Connect to database */
    $pdoObj = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "PDO: Secure connection established.<br>";

} catch (PDOException $ex) {
    echo "Database Error: " . $ex->getMessage();
}


/* ================================================
   END OF FILE
=============================================== */
?>

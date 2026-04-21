<?php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'firm_fee_test');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
echo "DB Connected successfully!\n";

// Helper functions
function filterReportName($queryDate, $reportName) {
    return $reportName . '_' . $queryDate . '.xlsx';
}

function getfileSize($filePath) {
    return round(filesize($filePath) / 1024, 2);
}



function getResult($query) {
    global $conn;
    $result = $conn->query($query);
    $rows = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->free();
    }
    return ['numRows' => count($rows), 'results' => $rows];
}

function createDirgetCompanyName($companyPath, $reportBasePath) {
    if ($companyPath === 'FEE_RECORDS') {
        return 'FEE_RECORDS';
    }
    if ($companyPath === 'FEE_COPY') {
        return 'FEE_COPY';
    }
    if ($companyPath === 'NEW_VENDOR') {
        return 'NEW_VENDOR';
    }
    return 'FAKEFIRM';
}
function getCompanyStatus($companyName) {
    // Returns 1 = Active for all test companies
    return '1';
}
require_once('FirmFeeCode.php');

echo "\n";
echo "============================================================\n";
echo "TEST CASE 1 — FEE_RECORDS (real amounts — should generate file)\n";
echo "============================================================\n";
$result1 = firmFeeCheckDetailToMyDownload(
    'FEE_RECORDS', null, 'FirmFeeReport',
    '', '', '', '', '', 0, 0, '', '',
    __DIR__ . '/output',
    '2026-03-18'
);
echo "--- RESULT ---\n";
print_r($result1);

echo "\n";
echo "============================================================\n";
echo "TEST CASE 2 — FEE_COPY (all zero amounts — should NOT generate file)\n";
echo "============================================================\n";
$result2 = firmFeeCheckDetailToMyDownload(
    'FEE_COPY', null, 'FirmFeeReport',
    '', '', '', '', '', 0, 0, '', '',
    __DIR__ . '/output',
    '2026-03-18'
);

echo "--- RESULT ---\n";
print_r($result2);

echo "\n";
echo "============================================================\n";
echo "FINAL SUMMARY\n";
echo "============================================================\n";
echo "TEST CASE 1 (FEE_RECORDS) — status: " . $result1['status'] . " — " . $result1['status_msg'] . "\n";
echo "TEST CASE 2 (FEE_COPY)    — status: " . $result2['status'] . " — " . $result2['status_msg'] . "\n";

echo "\n";
echo "============================================================\n";
echo "TEST CASE 3 — NEW_VENDOR (remit amount only — check behaviour)\n";
echo "============================================================\n";
$result3 = firmFeeCheckDetailToMyDownload(
    'NEW_VENDOR', null, 'FirmFeeReport',
    '', '', '', '', '', 0, 0, '', '',
    __DIR__ . '/output',
    '2026-03-18'
);
echo "--- RESULT ---\n";
print_r($result3);

echo "TEST CASE 3 (NEW_VENDOR) — status: " . $result3['status'] . " — " . $result3['status_msg'] . "\n";
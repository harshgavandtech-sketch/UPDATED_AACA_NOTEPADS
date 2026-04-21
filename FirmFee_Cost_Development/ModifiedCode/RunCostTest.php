<?php

// DB Connection
$conn = new mysqli('localhost', 'root', '', 'firm_cost_test');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$GLOBALS['conn'] = $conn;

// Stub helper functions
function filterReportName($date, $reportName) {
    return $date . '_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $reportName) . '.xlsx';
}

function createDirgetCompanyName($companyPath, $reportBasePath) {
    if ($companyPath === 'STB_RECORDS') return 'STB_RECORDS';
    if ($companyPath === 'STB_COPY')    return 'STB_COPY';
    return 'FAKEFIRM';
}

function getfileSize($path) {
    return file_exists($path) ? round(filesize($path) / 1024, 2) . ' KB' : '0 KB';
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
function getCompanyStatus($companyName) {
    // Returns 1 = Active for all test companies
    return '1';
}
require_once('FirmCostCode.php');

echo "============================================================\n";
echo "TEST CASE 1 — STB_RECORDS (has real amounts — should generate file)\n";
echo "============================================================\n";
$result1 = firmCostCheckDetailToMyDownload(
    'STB_RECORDS', null, 'FirmCostTest',
    '', '', '', '', '', 0, 0, '', '',
    __DIR__ . '/test_output',
    '2026-01-07'
);
echo "Status     : " . $result1['status'] . "\n";
echo "Message    : " . $result1['status_msg'] . "\n";
echo "New Status : " . $result1['new_status'] . "\n";

echo "\n";
echo "============================================================\n";
echo "TEST CASE 2 — STB_COPY (all zero amounts — should NOT generate file)\n";
echo "============================================================\n";
$result2 = firmCostCheckDetailToMyDownload(
    'STB_COPY', null, 'FirmCostTest',
    '', '', '', '', '', 0, 0, '', '',
    __DIR__ . '/test_output',  // make sure this is correct
    '2026-01-07'
);
echo "Status     : " . $result2['status'] . "\n";
echo "Message    : " . $result2['status_msg'] . "\n";
echo "New Status : " . $result2['new_status'] . "\n";

echo "\n";
echo "============================================================\n";
echo "FINAL SUMMARY\n";
echo "============================================================\n";
echo "TEST CASE 1 (STB_RECORDS) — status: " . $result1['status'] . " — " . $result1['status_msg'] . "\n";
echo "TEST CASE 2 (STB_COPY)    — status: " . $result2['status'] . " — " . $result2['status_msg'] . "\n";
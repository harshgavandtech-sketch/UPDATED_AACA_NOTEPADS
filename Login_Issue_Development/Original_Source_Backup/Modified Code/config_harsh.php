<?php
/* ============================================================================
 * config.php — Database Connection
 * ============================================================================
 * This file establishes the database connection used throughout the app.
 *
 * SECURITY RULES:
 * - Never echo, print, or expose $conn or any DB credentials anywhere.
 * - Never run SELECT queries here — this file only connects, nothing else.
 * - In production, move credentials to environment variables or a
 *   config file outside the web root.
 * ============================================================================ */

$conn = mysqli_connect("localhost", "root", "", "aaca_db");

if (!$conn) {
    // Log the real error server-side, never expose it to the browser
    error_log("Database connection failed: " . mysqli_connect_error());
    die("A system error occurred. Please contact your administrator.");
}

// Set the character set to UTF-8 for safe string handling
mysqli_set_charset($conn, "utf8mb4");
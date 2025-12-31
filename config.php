<?php
// Configuration file for production

// Base URL - automatically detect
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $host;

// Base directory path
define('BASE_PATH', dirname(__FILE__));

// Upload directory (relative to BASE_PATH)
define('UPLOAD_DIR', BASE_PATH . '/IMG/img');
define('PUZZLE_SLICES_DIR', BASE_PATH . '/puzzle_slices');

// Relative paths for web access
define('UPLOAD_WEB_PATH', './IMG/img');
define('PUZZLE_SLICES_WEB_PATH', './puzzle_slices');

// Security: Sanitize file names
function sanitizeFileName($filename) {
    // Remove any path components
    $filename = basename($filename);
    // Remove special characters
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    return $filename;
}

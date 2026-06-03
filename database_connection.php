<?php
// database_connection.php - Centralized database connection

// Database configuration - Localhost (XAMPP)
// Configured for local development environment
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP MySQL password (empty)
$dbname = "hris_db";

// Optional: Override with environment variables if needed
if (getenv('DB_HOST')) {
    $servername = getenv('DB_HOST');
}
if (getenv('DB_USER')) {
    $username = getenv('DB_USER');
}
if (getenv('DB_PASS')) {
    $password = getenv('DB_PASS');
}
if (getenv('DB_NAME')) {
    $dbname = getenv('DB_NAME');
}

// Global connection variable
$conn = null;

// Function to establish database connection
function getConnection() {
    global $conn, $servername, $username, $password, $dbname;
    
    if ($conn === null) {
        try {
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
            
            // Set charset to utf8
            $conn->set_charset("utf8");
            
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }
    }
    
    return $conn;
}

/**
 * Establish a server-level connection without selecting a specific database.
 * Useful for administrative tasks like creating databases.
 */
function getServerConnection() {
    global $servername, $username, $password;
    
    try {
        $serverConn = new mysqli($servername, $username, $password);
        
        if ($serverConn->connect_error) {
            throw new Exception("Server connection failed: " . $serverConn->connect_error);
        }
        
        $serverConn->set_charset("utf8");
        return $serverConn;
    } catch (Exception $e) {
        error_log("Server connection error: " . $e->getMessage());
        throw $e;
    }
}

// Function to close connection
function closeConnection() {
    global $conn;
    if ($conn !== null) {
        $conn->close();
        $conn = null;
    }
}

// Common headers function
function setAPIHeaders() {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    // Handle preflight requests
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);
    }
}

// Response helper functions
function sendSuccessResponse($data = null, $message = 'Operation successful') {
    $response = [
        'success' => true,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response);
}

function sendErrorResponse($message = 'An error occurred', $code = 400) {
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'message' => $message
    ]);
}

// File upload configuration
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif']);
define('ALLOWED_DOCUMENT_TYPES', [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'image/jpeg',
    'image/jpg', 
    'image/png'
]);
define('ALLOWED_CV_TYPES', [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]);

// Create upload directories if they don't exist
function createUploadDirectories() {
    $dirs = [
        UPLOAD_DIR . 'photos/',
        UPLOAD_DIR . 'cv/',
        UPLOAD_DIR . 'documents/'
    ];
    
    foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

// Validate file upload
function validateFileUpload($file, $allowed_types, $max_size = MAX_FILE_SIZE) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error: ' . $file['error']);
    }
    
    if (!in_array($file['type'], $allowed_types)) {
        throw new Exception('Invalid file type. Allowed types: ' . implode(', ', $allowed_types));
    }
    
    if ($file['size'] > $max_size) {
        throw new Exception('File too large. Maximum size: ' . ($max_size / 1024 / 1024) . 'MB');
    }
    
    return true;
}

// Generate unique filename
function generateUniqueFilename($original_name, $prefix = '', $user_id = null) {
    $extension = pathinfo($original_name, PATHINFO_EXTENSION);
    $timestamp = time();
    $random = mt_rand(1000, 9999);
    
    if ($user_id) {
        return $prefix . $user_id . '_' . $timestamp . '_' . $random . '.' . $extension;
    } else {
        return $prefix . $timestamp . '_' . $random . '.' . $extension;
    }
}

// Error logging function
function logError($message, $context = []) {
    $log_message = date('Y-m-d H:i:s') . ' - ' . $message;
    if (!empty($context)) {
        $log_message .= ' - Context: ' . json_encode($context);
    }
    error_log($log_message);
}

// Initialize upload directories on first load
createUploadDirectories();
?>
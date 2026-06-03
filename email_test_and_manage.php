<?php
// Email Testing and Management Tool for HRIS
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load email configuration
$emailConfig = require_once 'Admin/Account_creation/email_config.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Email Testing and Management - HRIS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
        .error { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .warning { background: #fff3cd; border-color: #ffeaa7; color: #856404; }
        .info { background: #d1ecf1; border-color: #bee5eb; color: #0c5460; }
        .config-item { margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 3px; }
        .btn { padding: 10px 20px; margin: 5px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; }
        .log-content { background: #f8f9fa; padding: 15px; border-radius: 4px; font-family: monospace; white-space: pre-wrap; max-height: 400px; overflow-y: auto; }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📧 Email Testing and Management Tool</h1>
        
        <div class='section info'>
            <h2>Current Email Configuration</h2>
            <div class='config-item'><strong>SMTP Host:</strong> " . $emailConfig['smtp']['host'] . "</div>
            <div class='config-item'><strong>SMTP Port:</strong> " . $emailConfig['smtp']['port'] . "</div>
            <div class='config-item'><strong>Encryption:</strong> " . ($emailConfig['smtp']['encryption'] ?: 'None') . "</div>
            <div class='config-item'><strong>Authentication:</strong> " . ($emailConfig['smtp']['auth'] ? 'Yes' : 'No') . "</div>
            <div class='config-item'><strong>Username:</strong> " . $emailConfig['smtp']['username'] . "</div>
            <div class='config-item'><strong>From Email:</strong> " . $emailConfig['from']['email'] . "</div>
            <div class='config-item'><strong>From Name:</strong> " . $emailConfig['from']['name'] . "</div>
        </div>";

// Handle form submissions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'test_email':
                testEmailSending();
                break;
            case 'switch_config':
                switchEmailConfig($_POST['config_type']);
                break;
            case 'clear_logs':
                clearEmailLogs();
                break;
        }
    }
}

function testEmailSending() {
    global $emailConfig;
    
    echo "<div class='section'>";
    echo "<h2>🧪 Email Test Results</h2>";
    
    if ($emailConfig['smtp']['host'] === 'file') {
        echo "<div class='warning'>";
        echo "<h3>File-based Email Configuration Active</h3>";
        echo "<p>Emails are being logged to files instead of being sent via SMTP. This is useful for testing.</p>";
        echo "<p>Check the email logs below to see the 'sent' emails.</p>";
        echo "</div>";
    } else {
        echo "<div class='info'>";
        echo "<h3>SMTP Configuration Active</h3>";
        echo "<p>Attempting to send test email via SMTP...</p>";
        echo "</div>";
    }
    
    // Simulate a password reset request
    $testEmail = $_POST['test_email'] ?? 'test@example.com';
    $testData = [
        'email' => $testEmail,
        'first_name' => 'Test',
        'last_name' => 'User',
        'username' => 'testuser'
    ];
    
    $token = bin2hex(random_bytes(32));
    $resetUrl = 'http://localhost/HRIS/Admin/Log_in/reset_password_form.php?token=' . $token;
    
    // Log the test
    $logFile = 'Admin/Log_in/email_logs.txt';
    $logEntry = date('Y-m-d H:i:s') . " - TEST EMAIL\n";
    $logEntry .= "Email: $testEmail\n";
    $logEntry .= "Name: Test User\n";
    $logEntry .= "Reset URL: $resetUrl\n";
    $logEntry .= "Token: $token\n";
    $logEntry .= "Subject: TEST - Password Reset Request - " . $emailConfig['templates']['company_name'] . "\n";
    $logEntry .= "---\n\n";
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    
    echo "<div class='success'>";
    echo "<h3>✅ Test Email Processed</h3>";
    echo "<p>Test email has been processed and logged. Check the email logs below.</p>";
    echo "</div>";
    
    echo "</div>";
}

function switchEmailConfig($configType) {
    echo "<div class='section'>";
    echo "<h2>🔄 Switching Email Configuration</h2>";
    
    $configFile = 'Admin/Account_creation/email_config.php';
    $configContent = file_get_contents($configFile);
    
    // Update the selected configuration
    $newConfig = "\$selectedConfig = \${$configType}Config; // Currently using {$configType} for testing";
    $updatedContent = preg_replace('/\$selectedConfig = \$[a-zA-Z]+Config;.*/', $newConfig, $configContent);
    
    if (file_put_contents($configFile, $updatedContent)) {
        echo "<div class='success'>";
        echo "<h3>✅ Configuration Updated</h3>";
        echo "<p>Email configuration has been switched to: <strong>$configType</strong></p>";
        echo "<p>Please refresh the page to see the updated configuration.</p>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "<h3>❌ Configuration Update Failed</h3>";
        echo "<p>Could not update the email configuration file.</p>";
        echo "</div>";
    }
    
    echo "</div>";
}

function clearEmailLogs() {
    echo "<div class='section'>";
    echo "<h2>🗑️ Clearing Email Logs</h2>";
    
    $logFiles = [
        'Admin/Log_in/email_logs.txt',
        'Admin/Log_in/password_reset_logs.txt'
    ];
    
    $cleared = 0;
    foreach ($logFiles as $logFile) {
        if (file_exists($logFile)) {
            if (file_put_contents($logFile, '')) {
                $cleared++;
            }
        }
    }
    
    if ($cleared > 0) {
        echo "<div class='success'>";
        echo "<h3>✅ Logs Cleared</h3>";
        echo "<p>Cleared $cleared log file(s).</p>";
        echo "</div>";
    } else {
        echo "<div class='warning'>";
        echo "<h3>⚠️ No Logs Found</h3>";
        echo "<p>No log files were found to clear.</p>";
        echo "</div>";
    }
    
    echo "</div>";
}

// Display email logs
echo "<div class='section'>
    <h2>📋 Email Logs</h2>
    <div class='grid'>";

// Email logs
$emailLogFile = 'Admin/Log_in/email_logs.txt';
if (file_exists($emailLogFile)) {
    echo "<div>
        <h3>Email Logs (email_logs.txt)</h3>
        <div class='log-content'>" . htmlspecialchars(file_get_contents($emailLogFile)) . "</div>
    </div>";
} else {
    echo "<div>
        <h3>Email Logs (email_logs.txt)</h3>
        <div class='log-content'>No email logs found.</div>
    </div>";
}

// Password reset logs
$resetLogFile = 'Admin/Log_in/password_reset_logs.txt';
if (file_exists($resetLogFile)) {
    echo "<div>
        <h3>Password Reset Logs (password_reset_logs.txt)</h3>
        <div class='log-content'>" . htmlspecialchars(file_get_contents($resetLogFile)) . "</div>
    </div>";
} else {
    echo "<div>
        <h3>Password Reset Logs (password_reset_logs.txt)</h3>
        <div class='log-content'>No password reset logs found.</div>
    </div>";
}

echo "</div></div>";

// Configuration switching
echo "<div class='section'>
    <h2>⚙️ Switch Email Configuration</h2>
    <p>Choose a different email provider configuration:</p>
    <form method='POST'>
        <input type='hidden' name='action' value='switch_config'>
        <div class='form-group'>
            <label>Select Configuration:</label>
            <select name='config_type'>
                <option value='file'>File-based (Testing)</option>
                <option value='gmail'>Gmail (Requires App Password)</option>
                <option value='outlook'>Outlook/Hotmail</option>
                <option value='yahoo'>Yahoo Mail</option>
                <option value='local'>Local XAMPP Mail</option>
            </select>
        </div>
        <button type='submit' class='btn btn-warning'>Switch Configuration</button>
    </form>
</div>";

// Test email form
echo "<div class='section'>
    <h2>🧪 Test Email Functionality</h2>
    <form method='POST'>
        <input type='hidden' name='action' value='test_email'>
        <div class='form-group'>
            <label>Test Email Address:</label>
            <input type='email' name='test_email' value='test@example.com' required>
        </div>
        <button type='submit' class='btn btn-primary'>Send Test Email</button>
    </form>
</div>";

// Management actions
echo "<div class='section'>
    <h2>🛠️ Management Actions</h2>
    <form method='POST' style='display: inline;'>
        <input type='hidden' name='action' value='clear_logs'>
        <button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to clear all email logs?\")'>Clear All Logs</button>
    </form>
    <a href='test_forgot_password.php' class='btn btn-success'>Go to Password Reset Test</a>
    <a href='Admin/Log_in/index.php' class='btn btn-primary'>Go to Login Page</a>
</div>";

// Instructions
echo "<div class='section info'>
    <h2>📖 Instructions</h2>
    <h3>For Gmail Setup:</h3>
    <ol>
        <li>Enable 2-Factor Authentication on your Gmail account</li>
        <li>Go to <a href='https://myaccount.google.com/apppasswords' target='_blank'>Google App Passwords</a></li>
        <li>Generate a new app password for 'Mail'</li>
        <li>Copy the 16-character password (no spaces)</li>
        <li>Update the password in the Gmail configuration above</li>
        <li>Switch to Gmail configuration using the form above</li>
    </ol>
    
    <h3>For Other Providers:</h3>
    <ul>
        <li><strong>Outlook/Hotmail:</strong> Use your regular email and password</li>
        <li><strong>Yahoo:</strong> Requires app password (similar to Gmail)</li>
        <li><strong>Local XAMPP:</strong> Requires XAMPP mail server to be configured</li>
        <li><strong>File-based:</strong> Logs emails to files (good for testing)</li>
    </ul>
    
    <h3>Testing:</h3>
    <ul>
        <li>Use 'File-based' configuration for testing without actual email sending</li>
        <li>Check the email logs to see what would be sent</li>
        <li>Use the test email form to simulate password reset requests</li>
    </ul>
</div>";

echo "</div></body></html>";
?>

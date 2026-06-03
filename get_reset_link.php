<?php
// Get the latest password reset link from logs
$logFile = 'Admin/Log_in/email_logs.txt';

if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $lines = explode("\n", $content);
    
    $latestUrl = '';
    $latestEmail = '';
    $latestTime = '';
    
    // Find the latest reset URL
    for ($i = count($lines) - 1; $i >= 0; $i--) {
        if (strpos($lines[$i], 'Reset URL:') !== false) {
            $latestUrl = trim(str_replace('Reset URL:', '', $lines[$i]));
            // Get the email from a few lines above
            for ($j = $i - 5; $j < $i; $j++) {
                if (isset($lines[$j]) && strpos($lines[$j], 'Email:') !== false) {
                    $latestEmail = trim(str_replace('Email:', '', $lines[$j]));
                    break;
                }
            }
            // Get the time from a few lines above
            for ($j = $i - 10; $j < $i; $j++) {
                if (isset($lines[$j]) && strpos($lines[$j], ' - Password Reset Request') !== false) {
                    $latestTime = trim(str_replace(' - Password Reset Request (File-based)', '', $lines[$j]));
                    break;
                }
            }
            break;
        }
    }
    
    if ($latestUrl) {
        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Latest Password Reset Link</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .info { background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .link { background: #e9ecef; padding: 15px; border-radius: 4px; margin: 15px 0; word-break: break-all; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #1e7e34; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔗 Latest Password Reset Link</h1>
        
        <div class='info'>
            <h3>Reset Request Details:</h3>
            <p><strong>Time:</strong> $latestTime</p>
            <p><strong>Email:</strong> $latestEmail</p>
            <p><strong>Status:</strong> Ready to use</p>
        </div>
        
        <div class='link'>
            <h3>Reset Link:</h3>
            <p><a href='$latestUrl' target='_blank'>$latestUrl</a></p>
        </div>
        
        <div style='text-align: center; margin: 30px 0;'>
            <a href='$latestUrl' class='btn btn-success' target='_blank'>🔐 Use Reset Link</a>
            <a href='Admin/Log_in/index.php' class='btn'>🏠 Back to Login</a>
        </div>
        
        <div class='info'>
            <h3>📝 Instructions:</h3>
            <ol>
                <li>Click the 'Use Reset Link' button above</li>
                <li>Enter your new password</li>
                <li>Confirm your new password</li>
                <li>Click 'Reset Password'</li>
                <li>Go back to login page and use your new password</li>
            </ol>
        </div>
    </div>
</body>
</html>";
    } else {
        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>No Reset Links Found</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>⚠️ No Reset Links Found</h1>
        
        <div class='warning'>
            <h3>No password reset requests found in the logs.</h3>
            <p>To get a reset link:</p>
            <ol>
                <li>Go to the login page</li>
                <li>Click 'Forgot Password?'</li>
                <li>Enter your email address</li>
                <li>Come back to this page to get the reset link</li>
            </ol>
        </div>
        
        <div style='text-align: center; margin: 30px 0;'>
            <a href='Admin/Log_in/index.php' class='btn'>🔐 Go to Login Page</a>
        </div>
    </div>
</body>
</html>";
    }
} else {
    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>No Logs Found</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📁 No Email Logs Found</h1>
        
        <div class='warning'>
            <h3>The email log file doesn't exist yet.</h3>
            <p>This means no password reset requests have been made yet.</p>
        </div>
        
        <div style='text-align: center; margin: 30px 0;'>
            <a href='Admin/Log_in/index.php' class='btn'>🔐 Go to Login Page</a>
        </div>
    </div>
</body>
</html>";
}
?>

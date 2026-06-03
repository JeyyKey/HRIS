<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail Setup Guide - HRIS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .step { margin: 20px 0; padding: 20px; border-left: 4px solid #007bff; background: #f8f9fa; }
        .step h3 { color: #007bff; margin-top: 0; }
        .code { background: #e9ecef; padding: 10px; border-radius: 4px; font-family: monospace; margin: 10px 0; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .btn { padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #1e7e34; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-warning:hover { background: #e0a800; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Gmail Setup Guide for HRIS</h1>
        
        <div class="warning">
            <h3>⚠️ Important</h3>
            <p>To receive actual emails (not just file logs), you need to set up Gmail authentication. Follow these steps:</p>
        </div>

        <div class="step">
            <h3>Step 1: Enable 2-Factor Authentication</h3>
            <p>1. Go to your <a href="https://myaccount.google.com/security" target="_blank">Google Account Security</a></p>
            <p>2. Under "Signing in to Google", click on <strong>2-Step Verification</strong></p>
            <p>3. Follow the setup process to enable 2FA</p>
            <p><em>Note: This is required to generate app passwords</em></p>
        </div>

        <div class="step">
            <h3>Step 2: Generate App Password</h3>
            <p>1. Go to <a href="https://myaccount.google.com/apppasswords" target="_blank">Google App Passwords</a></p>
            <p>2. Select <strong>"Mail"</strong> as the app</p>
            <p>3. Select <strong>"Other (Custom name)"</strong> as the device</p>
            <p>4. Enter <strong>"HRIS System"</strong> as the name</p>
            <p>5. Click <strong>"Generate"</strong></p>
            <p>6. Copy the 16-character password (it will look like: <code>abcd efgh ijkl mnop</code>)</p>
        </div>

        <div class="step">
            <h3>Step 3: Update Configuration</h3>
            <p>1. Copy the app password (remove any spaces)</p>
            <p>2. Go to: <code>Admin/Account_creation/email_config.php</code></p>
            <p>3. Find the Gmail configuration section</p>
            <p>4. Replace the password with your app password:</p>
            <div class="code">
                'password' => 'YOUR_16_CHARACTER_APP_PASSWORD_HERE',
            </div>
        </div>

        <div class="step">
            <h3>Step 4: Test Email Sending</h3>
            <p>1. Save the configuration file</p>
            <p>2. Go to the login page and test "Forgot Password"</p>
            <p>3. Check your email inbox (and spam folder)</p>
        </div>

        <div class="success">
            <h3>✅ Current Status</h3>
            <p><strong>Configuration:</strong> Gmail (Real email sending)</p>
            <p><strong>Email:</strong> mercadoopaull@gmail.com</p>
            <p><strong>Status:</strong> Ready to send real emails (once app password is set)</p>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="email_test_and_manage.php" class="btn">📧 Email Test Tool</a>
            <a href="Admin/Log_in/index.php" class="btn btn-success">🔐 Test Login Page</a>
            <a href="Admin/Account_creation/email_config.php" class="btn btn-warning">⚙️ Edit Config</a>
        </div>

        <div class="warning">
            <h3>🔧 Alternative: Quick Test with File-based Mode</h3>
            <p>If you want to test the functionality without setting up Gmail:</p>
            <p>1. Go to <code>Admin/Account_creation/email_config.php</code></p>
            <p>2. Change line 91 to: <code>$selectedConfig = $fileConfig;</code></p>
            <p>3. Check <code>Admin/Log_in/email_logs.txt</code> for reset links</p>
        </div>

        <div class="step">
            <h3>📋 Troubleshooting</h3>
            <p><strong>If emails still don't arrive:</strong></p>
            <ul>
                <li>Check your spam/junk folder</li>
                <li>Verify the app password has no spaces</li>
                <li>Make sure 2FA is enabled on your Gmail account</li>
                <li>Try generating a new app password</li>
                <li>Check the email logs for error messages</li>
            </ul>
        </div>
    </div>
</body>
</html>

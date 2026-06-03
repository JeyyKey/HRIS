<?php
// Configure session before starting
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();
require_once __DIR__ . '/database_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fuji Philippines Corporation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="Admin/Log_in/index.css">
    <link rel="icon" type="image/x-icon" href="icon.png">
</head>

<body>
    <div class="container">
        <main class="login-container">
            <!-- Welcome Section -->
            <section class="welcome-section">
                <div class="welcome-content">
                    <div class="welcome-text">
                        <h2>Welcome to Fuji Philippines Corporation</h2>
                        <p>Your Trusted Partner in Industrial Automation and Innovation.</p>
                    </div>
                </div>
            </section>

            <!-- Login Form Section -->
            <section class="login-section">
                <div class="login-wrapper">
                    <div class="login-header">
                        <h2>Sign In</h2>
                        <p>Access your account to continue</p>
                    </div>

                    <div class="login-form-container">
                        <form action="Admin/Log_in/check_login.php" method="POST" id="loginForm">
                            <div class="form-group">
                                <label for="username">
                                    <i class="fas fa-user"></i> Email
                                </label>
                                <input type="text" id="username" name="username" required 
                                       placeholder="Enter your username or email"
                                       aria-describedby="usernameError">
                                <span class="error-message" id="usernameError"></span>
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <div class="password-input">
                                    <input type="password" id="password" name="password" required 
                                           placeholder="Enter your password"
                                           aria-describedby="passwordError">
                                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                </div>
                                <span class="error-message" id="passwordError"></span>
                            </div>

                            <div class="form-options">
                                <a href="#" id="forgotPassword" class="forgot-link">Forgot Password?</a>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="loginBtn">
                                    <i class="fas fa-sign-in-alt"></i> Sign In
                                </button>
                            </div>
                        </form>

                        <div class="login-footer">
                            <div class="help-section">
                                <p>Need help? <a href="#" id="contactSupportLink">Contact Support</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer>
            <p>&copy; 2025 Fuji Philippines Corporation. All rights reserved.</p>
        </footer>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal" id="forgotPasswordModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-key"></i> Reset Password</h3>
                <span class="close-modal" id="closeModal">&times;</span>
            </div>
            <div class="modal-body">
                <p>Enter your email address and we'll send you instructions to reset your password.</p>
                
                <form id="resetPasswordForm">
                    <div class="form-group">
                        <label for="resetEmail">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="resetEmail" name="resetEmail" required 
                               placeholder="Enter your email address"
                               aria-describedby="resetEmailError">
                        <span class="error-message" id="resetEmailError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                <button type="submit" form="resetPasswordForm" class="btn btn-primary reset-btn">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Support Modal -->
    <div class="modal" id="contactSupportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-headset"></i> Contact Support</h3>
                <span class="close-modal" id="closeContactModal">&times;</span>
            </div>
            <div class="modal-body">
                <p>Need assistance? Our support team is here to help.</p>
                
                <form id="contactSupportForm">
                    <div class="form-group">
                        <label for="supportName">
                            <i class="fas fa-user"></i> Full Name
                        </label>
                        <input type="text" id="supportName" name="supportName" required 
                               placeholder="Enter your full name"
                               aria-describedby="supportNameError">
                        <span class="error-message" id="supportNameError"></span>
                    </div>

                    <div class="form-group">
                        <label for="supportEmail">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="supportEmail" name="supportEmail" required 
                               placeholder="Enter your email address"
                               aria-describedby="supportEmailError">
                        <span class="error-message" id="supportEmailError"></span>
                    </div>

                    <div class="form-group">
                        <label for="supportSubject">
                            <i class="fas fa-tag"></i> Subject
                        </label>
                        <input type="text" id="supportSubject" name="supportSubject" required 
                               placeholder="What do you need help with?"
                               aria-describedby="supportSubjectError">
                        <span class="error-message" id="supportSubjectError"></span>
                    </div>

                    <div class="form-group">
                        <label for="supportMessage">
                            <i class="fas fa-comment"></i> Message
                        </label>
                        <textarea id="supportMessage" name="supportMessage" required 
                                  placeholder="Describe your issue in detail"
                                  aria-describedby="supportMessageError"
                                  rows="5"></textarea>
                        <span class="error-message" id="supportMessageError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                <button type="submit" form="contactSupportForm" class="btn btn-primary support-submit-btn">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </div>
        </div>
    </div>

    <script src="Admin/Log_in/index.js"></script>
</body>
</html>

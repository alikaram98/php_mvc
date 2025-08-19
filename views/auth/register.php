<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Sign up to your account</p>
        </div>
        <form class="login-form" id="registerForm" method="post" action="<?= $router->urlFor('register.store') ?>">
            <div class="form-group">
                <div class="input-wrapper">
                    <input type="name" id="name" name="name" required autocomplete="name">
                    <label for="name">Name</label>
                    <span class="focus-border"></span>
                </div>
                <?= @showError($errors['name']) ?>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" required autocomplete="email">
                    <label for="email">Email Address</label>
                    <span class="focus-border"></span>
                </div>
                <?= @showError($errors['email']) ?>
            </div>

            <div class="form-group">
                <div class="input-wrapper password-wrapper">
                    <input type="password" name="password" required autocomplete="current-password">
                    <label for="password">Password</label>
                    <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                        <span class="eye-icon"></span>
                    </button>
                    <span class="focus-border"></span>
                </div>
                <?= @showError($errors['password']) ?>
            </div>
            
            <div class="form-group">
                <div class="input-wrapper password-wrapper">
                    <input type="password" name="confirm_password" required autocomplete="current-password">
                    <label for="password">Confirm Password</label>
                    <button type="button" class="password-toggle" aria-label="Toggle password visibility">
                        <span class="eye-icon"></span>
                    </button>
                    <span class="focus-border"></span>
                </div>
                <span class="error-message" id="passwordError"></span>
            </div>

            <button type="submit" class="login-btn btn">
                <span class="btn-text">Sign Up</span>
                <span class="btn-loader"></span>
            </button>
        </form>

        <div class="divider">
            <span>or continue with</span>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn google-btn">
                <span class="social-icon google-icon"></span>
                Google
            </button>
            <button type="button" class="social-btn github-btn">
                <span class="social-icon github-icon"></span>
                GitHub
            </button>
        </div>

        <div class="signup-link">
            <p>Don't have an account? <a href="<?= $router->urlFor('login') ?>">Sign in</a></p>
        </div>

        <div class="success-message" id="successMessage">
            <div class="success-icon">✓</div>
            <h3>Login Successful!</h3>
            <p>Redirecting to your dashboard...</p>
        </div>
    </div>
</div>
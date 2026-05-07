<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - LU StudyVerse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/auth_style.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-left">
        <div class="brand">
            <i class="fa-solid fa-book-open"></i>
            <span>LU StudyVerse</span>
        </div>
        <h1>Elevate Your Academic Journey.</h1>
        <p>Access a curated ecosystem of research materials, lecture notes, and collaborative study tools designed for excellence.</p>
        
        <div class="testimonial-card">
            <div class="status-dot"></div>
            <span class="active-text">ACTIVE COMMUNITY</span>
            <p>"The most efficient way to organize my research papers and collaborate with my lab team."</p>
            <div class="user-info">
                <img src="https://ui-avatars.com/api/?name=Julian+Vance" alt="User">
                <div>
                    <strong>Dr. Julian Vance</strong><br>
                    <span>Senior Fellow</span>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="form-container">
            <h2>Create Account</h2>
            <p class="subtitle">Join the community of scholars today.</p>

            <div class="tab-menu">
                <a href="login.php">Login</a>
                <a href="register.php" class="active">Register</a>
            </div>

            <form action="register_action.php" method="POST">
                <div class="input-group">
                    <label>Full Name</label>
                    <div class="input-box">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" name="fullname" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Academic Email</label>
                    <div class="input-box">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" placeholder="name@university.edu" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="input-box">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" name="register" class="btn-primary">Sign Up</button>
            </form>

            <div class="divider"><span>Or continue with</span></div>

            <div class="social-btns">
                <button class="social-btn"><img src="https://www.google.com/favicon.ico" width="16"> Google</button>
                <button class="social-btn"><i class="fa-solid fa-id-card"></i> SSO</button>
            </div>

            <p class="terms">By signing up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
        </div>
    </div>
</div>

</body>
</html>
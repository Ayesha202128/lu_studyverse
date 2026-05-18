<?php
function render_layout($section, $page_title = "LU StudyVerse") {


    if ($section === 'header') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<header class="header">
    <div class="container">
        <div class="header-wrapper">
            
            <div class="header-logo-area">
                <a href="../index.php" class="logo">LU StudyVerse</a>
            </div>
            
            <div class="header-menu-area">
                <a href="../index.php" class="menu-link active">Browse</a>
                <a href="dashboard.php" class="menu-link">Dashboard</a>
                <a href="upload.php" class="menu-link">Upload</a>
            </div>
            
            <div class="header-user-area">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <div class="profile-card-trigger" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            
                            <div class="avatar-circle-frame">
                                <?php if(!empty($_SESSION['user_image'])): ?>
                                    <img src="../assets/img/<?php echo $_SESSION['user_image']; ?>" alt="Profile">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['fullname']); ?>&background=0066cc&color=fff" alt="Profile">
                                <?php endif; ?>
                            </div>
                            
                            <div class="user-name-label">
                                <span><?php echo explode(' ', trim($_SESSION['fullname']))[0]; ?></span>
                                <i class="bi bi-chevron-down"></i>
                            </div>
                            
                        </div>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow custom-header-dropdown" aria-labelledby="profileMenu">
                            <li>
                                <a class="dropdown-item py-2" href="profile.php">
                                    <i class="bi bi-person-circle me-2"></i> My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="../auth/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="../auth/login.php" class="signin-btn">Sign In</a>
                    <a href="../auth/register.php" class="getstarted-btn">Get Started</a>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</header>
<?php
    } 
    // ==========================================================
    // ২. ফুটার পার্ট (FOOTER PART)
    // ==========================================================
    else if ($section === 'footer') {
?>

<footer class="footer">
    <div class="container">
        <div class="row">
            
            <div class="col-md-6">
                <h5 class="footer-title">LU StudyVerse</h5>
                <p style="color: #627D98; font-size: 14px;">© 2024 LU StudyVerse. Empowering Academic Excellence.</p>
            </div>
            
            <div class="col-md-3">
                <h6 class="footer-title">Platform</h6>
                <div class="mb-2"><a href="#" class="footer-link">About</a></div>
                <div><a href="#" class="footer-link">Contact</a></div>
            </div>

            <div class="col-md-3">
                <h6 class="footer-title">Legal</h6>
                <div class="mb-2"><a href="#" class="footer-link">Terms</a></div>
                <div><a href="#" class="footer-link">Privacy</a></div>
            </div>
            
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
    }
}
?>
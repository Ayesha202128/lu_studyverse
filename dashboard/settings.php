<?php
session_start();

// ইউজার লগইন না থাকলে ইনডেক্স পেজে পাঠিয়ে দেওয়া হবে
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// ডাটাবেজ কানেকশন ফাইল কানেক্ট করা (প্রয়োজনে অ্যাক্টিভিটি লগ রাখার জন্য)
require_once '../config/db.php'; 

$user_id = $_SESSION['user_id'];

// ইউজারের প্রোফাইল ইনফো তুলে আনা (সাইডবার এবং হেডার সিঙ্কের জন্য)
$user_query = "SELECT fullname, email, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - LU StudyVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>

<script>
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
</script>

<div class="app-layout">
    
    <aside class="app-sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-book-half brand-icon"></i>
            <span class="brand-text">LU StudyVerse</span>
        </div>
        
        <div class="sidebar-user-card">
            <img src="<?php echo !empty($user_data['profile_pic']) ? '../assets/img/'.$user_data['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($user_data['fullname']).'&background=0066cc&color=fff'; ?>" alt="User" class="sidebar-avatar">
            <div class="sidebar-user-info">
                <h6><?php echo htmlspecialchars($user_data['fullname']); ?></h6>
                <p>Academic Member</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="../index.php" class="menu-item"><i class="bi bi-search"></i> Browse</a>
            <a href="dashboard.php" class="menu-item"><i class="bi bi-grid"></i> Dashboard</a>
            <a href="upload.php" class="menu-item"><i class="bi bi-cloud-arrow-up"></i> Upload</a>
            <a href="profile.php" class="menu-item"><i class="bi bi-person"></i> Profile</a>
            <a href="settings.php" class="menu-item active"><i class="bi bi-gear-fill"></i> Settings</a>
        </nav>
    </aside>

    <main class="app-main-content">
        <div class="container-fluid py-4 px-4">
            
            <div class="main-header-block mb-4">
                <h1 class="page-title-text">Account Settings</h1>
                <p class="page-subtitle-text">Manage your application preferences, display modes, and log configurations.</p>
            </div>

            <div class="row g-4">
                <div class="col-xl-8 col-lg-10">
                    
                    <div class="figma-uploads-panel p-4 mb-4 settings-card">
                        <h5 class="panel-title mb-3"><i class="bi bi-palette me-2"></i> Interface Preferences</h5>
                        <p class="text-muted fs-7">Customize the interface presentation according to your system environment or comfort.</p>
                        <hr class="my-3" style="color: var(--border-color);">

                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                            <div>
                                <h6 class="mb-1 font-semibold" style="font-size: 15px;">Dark Theme Configuration</h6>
                                <small class="text-muted fs-8">Switch between traditional bright palette and low-light visual rendering.</small>
                            </div>
                            
                            <button class="btn" id="themeToggleBtn" onclick="toggleDarkMode()" style="font-weight: 600; padding: 8px 16px; border-radius: 8px; transition: all 0.2s;">
                                <i class="bi bi-moon-fill" id="themeIcon"></i> <span id="themeText">Enable Dark Mode</span>
                            </button>
                        </div>
                    </div>

                    <div class="figma-uploads-panel p-4 settings-card">
                        <h5 class="panel-title mb-3"><i class="bi bi-shield-lock me-2"></i> System Information & Logs</h5>
                        <p class="text-muted fs-7">Overview of your account scope and verification flags active within LU StudyVerse.</p>
                        <hr class="my-3" style="color: var(--border-color);">

                        <div class="row g-3 fs-7">
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3" style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                                    <span class="text-muted d-block mb-1">Registered Account Email</span>
                                    <strong><?php echo htmlspecialchars($user_data['email']); ?></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 rounded-3" style="background-color: var(--bg-color); border: 1px solid var(--border-color);">
                                    <span class="text-muted d-block mb-1">Authentication Session Status</span>
                                    <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i> Active Session</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </main>
</div>

<footer class="profile-layout-footer text-center py-3 bg-dark text-white-50" style="margin-left: 260px; font-size: 13px;">
    © 2026 LU StudyVerse. Empowering Academic Excellence.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ১. পেজ রেন্ডার হওয়ার সাথে সাথে রানিং থিম রিড করে বাটন সিঙ্ক করা
    const savedTheme = localStorage.getItem('theme') || 'light';
    updateButtonUI(savedTheme);
});

function toggleDarkMode() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    let targetTheme = 'light';

    if (currentTheme === 'light' || !currentTheme) {
        targetTheme = 'dark';
    }

    // ব্রাউজারের HTML নোডে থিম অ্যাট্রিবিউট পুশ করা এবং লোকাল মেমরিতে লক করা
    document.documentElement.setAttribute('data-theme', targetTheme);
    localStorage.setItem('theme', targetTheme);
    
    // বাটন UI ইন্টারেক্টিভ পরিবর্তন করা
    updateButtonUI(targetTheme);
}

function updateButtonUI(theme) {
    const themeIcon = document.getElementById('themeIcon');
    const themeText = document.getElementById('themeText');
    const btn = document.getElementById('themeToggleBtn');
    
    if(!themeIcon || !themeText || !btn) return;

    if (theme === 'dark') {
        themeIcon.className = "bi bi-sun-fill me-2";
        themeText.innerText = "Disable Dark Mode";
        btn.className = "btn btn-light text-dark"; // ডার্ক মোডে বাটন রিভার্স ব্রাইটনেস রিড করবে
        btn.style.border = "1px solid #ffffff";
    } else {
        themeIcon.className = "bi bi-moon-fill me-2";
        themeText.innerText = "Enable Dark Mode";
        btn.className = "btn btn-outline-primary"; // লাইট মোডে ব্রিলিয়ান্ট ব্লু থিম
    }
}
</script>

</body>
</html>
<?php
session_start();

// ইউজার লগইন না থাকলে ইনডেক্স পেজে পাঠিয়ে দেওয়া হবে
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// ডাটাবেজ কানেকশন ফাইল কানেক্ট করা
require_once '../config/db.php'; 

$user_id = $_SESSION['user_id'];
$message = "";
$error_message = "";

// ==========================================================
// ক. ইউজারের বর্তমান প্রোফাইল ডেটা তুলে আনা (READ)
// ==========================================================
$user_query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();

// ==========================================================
// খ. প্রোফাইল ইনফরমেশন আপডেট করা (UPDATE)
// ==========================================================
if (isset($_POST['update_profile'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    
    // প্রোফাইল পিকচার আপলোড হ্যান্ডলিং
    $profile_pic_name = $user_data['profile_pic']; // ডিফল্ট বা বর্তমান ছবি
    if (!empty($_FILES['profile_pic']['name'])) {
        $target_dir = "../assets/img/";
        $file_extension = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
        $new_file_name = "user_" . $user_id . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $profile_pic_name = $new_file_name;
            $_SESSION['user_image'] = $new_file_name; // সেশন ইমেজ আপডেট
        }
    }

    $update_query = "UPDATE users SET fullname=?, department=?, student_id=?, phone=?, bio=?, profile_pic=? WHERE id=?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssssi", $fullname, $department, $student_id, $phone, $bio, $profile_pic_name, $user_id);
    
    if ($update_stmt->execute()) {
        $_SESSION['fullname'] = $fullname; // সেশন নাম আপডেট
        $message = "Profile updated successfully!";
        // রিফ্রেশ করে নতুন ডেটা দেখানো
        header("Refresh:0");
    } else {
        $error_message = "Something went wrong. Please try again.";
    }
}

// ==========================================================
// গ. ইউজার অ্যাকাউন্ট ডিলিট করা (DELETE)
// ==========================================================
if (isset($_POST['delete_account'])) {
    // ইউজারের ফাইলগুলো আগে ডিলিট করা (অপশনাল কিন্তু ক্লিন কোডিং)
    $del_materials = "DELETE FROM materials WHERE user_id = ?";
    $stmt_m = $conn->prepare($del_materials);
    $stmt_m->bind_param("i", $user_id);
    $stmt_m->execute();

    // ইউজার ডিলিট কুয়েরি
    $delete_user_query = "DELETE FROM users WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_user_query);
    $delete_stmt->bind_param("i", $user_id);
    
    if ($delete_stmt->execute()) {
        session_destroy();
        header("Location: ../auth/register.php?account_deleted=true");
        exit();
    }
}

// ==========================================================
// ঘ. ইউজারের আপলোড করা মেটেরিয়ালস নিয়ে আসা (READ - Materials)
// ==========================================================
$materials_query = "SELECT * FROM materials WHERE user_id = ? ORDER BY upload_date DESC";
$m_stmt = $conn->prepare($materials_query);
$m_stmt->bind_param("i", $user_id);
$m_stmt->execute();
$materials_result = $m_stmt->get_result();
$total_materials = $materials_result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management - LU StudyVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>

<div class="app-layout">
    
    <aside class="app-sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-book-half brand-icon"></i>
            <span class="brand-text">LU StudyVerse</span>
        </div>
        
        <div class="sidebar-user-card">
            <img src="<?php echo !empty($user_data['profile_pic']) ? '../assets/img/'.$user_data['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($user_data['fullname']).'&background=0066cc&color=fff'; ?>" alt="User" class="sidebar-avatar">
            <div class="sidebar-user-info">
                <h6>Academic Member</h6>
                <p>LU StudyVerse</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="../index.php" class="menu-item"><i class="bi bi-search"></i> Browse</a>
            <a href="dashboard.php" class="menu-item"><i class="bi bi-grid"></i> Dashboard</a>
            <a href="upload.php" class="menu-item"><i class="bi bi-cloud-arrow-up"></i> Upload</a>
            <a href="profile.php" class="menu-item active"><i class="bi bi-person-fill"></i> Profile</a>
            <a href="settings.php" class="menu-item"><i class="bi bi-gear"></i> Settings</a>
        </nav>
    </aside>

    <main class="app-main-content">
        <div class="container-fluid py-4 px-4">
            
            <div class="main-header-block mb-4">
                <h1 class="page-title-text">Profile Management</h1>
                <p class="page-subtitle-text">Oversee your academic contributions and update your personal information.</p>
            </div>

            <?php if(!empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                
                <div class="col-xl-4 col-lg-5">
                    
                    <div class="figma-profile-card text-center mb-4">
                        <div class="card-hero-banner"></div>
                        <div class="profile-avatar-container">
                            <img src="<?php echo !empty($user_data['profile_pic']) ? '../assets/img/'.$user_data['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($user_data['fullname']).'&background=0066cc&color=fff'; ?>" alt="Profile Photo" class="main-profile-img">
                        </div>
                        
                        <h3 class="u-display-name"><?php echo htmlspecialchars($user_data['fullname']); ?></h3>
                        <p class="u-meta-major text-uppercase"><?php echo !empty($user_data['department']) ? htmlspecialchars($user_data['department']) : 'Department Not Set'; ?></p>
                        <p class="u-meta-email"><?php echo htmlspecialchars($user_data['email']); ?></p>
                        
                        <div class="profile-completion-box px-4 my-4">
                            <div class="d-flex justify-content-between mb-1 fs-7 font-semibold">
                                <span class="text-muted">Profile Completion</span>
                                <span class="text-primary-blue">85%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" role="progressbar" style="width: 85%; background-color: #0066cc;"></div>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <button class="btn edit-profile-btn w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil me-2"></i> Edit Profile
                            </button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-counter-card text-center">
                                <h2><?php echo $total_materials; ?></h2>
                                <p>Materials</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-counter-card text-center">
                                <h2>1.2k</h2>
                                <p>Downloads</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8 col-lg-7">
                    
                    <div class="figma-uploads-panel p-4 mb-4">
                        <div class="panel-header d-flex justify-content-between align-items-center mb-4">
                            <h5 class="panel-title"><i class="bi bi-cloud-check me-2"></i> My Uploads</h5>
                            <a href="upload.php" class="btn-new-upload-link"><i class="bi bi-plus-lg"></i> New Upload</a>
                        </div>

                        <div class="uploads-list-wrapper">
                            <?php if($total_materials > 0): ?>
                                <?php while($row = $materials_result->fetch_assoc()): ?>
                                    <div class="upload-list-item d-flex align-items-center justify-content-between p-3 mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="file-icon-box">
                                                <i class="bi bi-file-earmark-text-fill"></i>
                                            </div>
                                            <div class="file-meta-details">
                                                <h6><?php echo htmlspecialchars($row['title']); ?></h6>
                                                <p>Uploaded: <?php echo date('M d, Y', strtotime($row['upload_date'])); ?> • <?php echo htmlspecialchars($row['category']); ?></p>
                                            </div>
                                        </div>
                                        <div class="action-buttons-box">
                                            <a href="../assets/materials/<?php echo $row['file_name']; ?>" class="btn btn-light btn-sm mx-1" download><i class="bi bi-download"></i></a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                <div class="text-center mt-3">
                                    <a href="#" class="view-all-uploads-btn">View All <?php echo $total_materials; ?> Uploads</a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-folder-x fs-2"></i>
                                    <p class="mt-2">No files uploaded yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="growth-stats-card p-4 text-white">
                                <span class="stats-label"><i class="bi bi-graph-up-arrow"></i> GROWTH</span>
                                <h3>+24%</h3>
                                <p>increase in resource engagement this month.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="reputation-stats-card p-4 text-white">
                                <span class="stats-label"><i class="bi bi-star"></i> REPUTATION</span>
                                <h3>4.9</h3>
                                <p>Average rating across all contributed materials.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content custom-modal-box">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel"><i class="bi bi-person-gear me-2"></i> Update Profile Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <div class="col-md-12 text-center mb-3">
                            <div class="modal-avatar-preview mb-2">
                                <img src="<?php echo !empty($user_data['profile_pic']) ? '../assets/img/'.$user_data['profile_pic'] : 'https://ui-avatars.com/api/?name='.urlencode($user_data['fullname']); ?>" id="avatarPreview" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 2px solid #0066cc;">
                            </div>
                            <label class="btn btn-sm btn-outline-primary">
                                Change Image
                                <input type="file" name="profile_pic" accept="image/*" id="imageInput" hidden>
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control custom-input" value="<?php echo htmlspecialchars($user_data['fullname']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email (Read Only)</label>
                            <input type="email" class="form-control custom-input bg-light" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control custom-input" placeholder="e.g. Computer Science" value="<?php echo htmlspecialchars($user_data['department']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Student ID</label>
                            <input type="text" name="student_id" class="form-control custom-input" placeholder="e.g. 2112020001" value="<?php echo htmlspecialchars($user_data['student_id']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control custom-input" placeholder="e.g. 017XXXXXXXX" value="<?php echo htmlspecialchars($user_data['phone']); ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control custom-input" rows="3" placeholder="Tell us about yourself..."><?php echo htmlspecialchars($user_data['bio']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" name="delete_account" class="btn delete-account-btn" onclick="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone!');">
                        <i class="bi bi-trash3 me-1"></i> Delete Account
                    </button>
                    <div>
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_profile" class="btn save-changes-btn">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="profile-layout-footer text-center py-3 bg-dark text-white-50" style="margin-left: 260px; font-size: 13px;">
    © 2024 LU StudyVerse. Empowering Academic Excellence.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ক্লায়েন্ট সাইড ইমেজ প্রিভিউ স্ক্রিপ্ট
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files;
        if (file) {
            document.getElementById('avatarPreview').src = URL.createObjectURL(file);
        }
    }
</script>
</body>
</html>
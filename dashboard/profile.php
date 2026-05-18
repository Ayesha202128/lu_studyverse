<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - LU StudyVerse</title>

    <link rel="stylesheet" href="../assets/css/profile.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="logo">
            <h2>📘 LU StudyVerse</h2>
        </div>

        <ul class="menu">
            <li>
                <a href="../index.php">
                    <i class="fa-solid fa-house"></i>
                    Home
                </a>
            </li>

            <li class="active">
                <a href="#">
                    <i class="fa-solid fa-user"></i>
                    Profile
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa-solid fa-book"></i>
                    Materials
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa-solid fa-gear"></i>
                    Settings
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>
        </ul>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <div class="profile-card">

            <h1>My Profile</h1>
            <p>Manage your academic profile information.</p>

            <!-- Profile Image -->
            <div class="profile-photo-section">

                <img src="../assets/img/default-user.png"
                class="profile-photo">

                <label class="upload-btn">
                    Upload Photo
                    <input type="file" hidden>
                </label>

            </div>

            <!-- Form -->
            <form class="profile-form">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text"
                    placeholder="Enter full name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email"
                    placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label>Department</label>
                    <input type="text"
                    placeholder="Department">
                </div>

                <div class="form-group">
                    <label>Student ID</label>
                    <input type="text"
                    placeholder="Student ID">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text"
                    placeholder="Phone Number">
                </div>

                <div class="form-group full-width">
                    <label>Bio</label>
                    <textarea rows="5"
                    placeholder="Write something about yourself"></textarea>
                </div>

                <div class="btn-group">

                    <button type="submit"
                    class="save-btn">

                        Save Changes
                    </button>

                    <button type="button"
                    class="delete-btn">

                        Delete Account
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>
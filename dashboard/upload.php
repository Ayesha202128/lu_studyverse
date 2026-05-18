<?php
session_start();

include '../config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$message = "";
$message_class = "";

if(isset($_POST['upload'])){

    $user_id = $_SESSION['user_id'];

    $title = trim($_POST['title']);
    $subject_name = trim($_POST['subject_name']);
    $course_code = trim($_POST['course_code']);
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';

    // স্ক্রিনশটের ডিজাইন অনুযায়ী Subject এবং Course Code একসাথে জোড়া লাগিয়ে ডাটাবেজে রাখার জন্য
    $full_subject_name = $subject_name . " (" . $course_code . ")";

    // FILE
    $file = $_FILES['file_name'];

    $fileName = $file['name'];
    $tmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // extension check
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['pdf'];

    if(empty($title) || empty($subject_name) || empty($course_code) || empty($category) || empty($fileName)){
        $message = "All fields and file are required!";
        $message_class = "error-msg";
    }
    elseif(!in_array($fileExt, $allowed)){
        $message = "Only PDF file allowed!";
        $message_class = "error-msg";
    }
    elseif($fileSize > 10000000){ // 10MB
        $message = "File size max 10MB";
        $message_class = "error-msg";
    }
    elseif($fileError !== 0){
        $message = "Upload Error!";
        $message_class = "error-msg";
    }
    else{
        // unique file name
        $newFileName = time() . "_" . $fileName;
        $uploadDir = "../uploads/";

        // আপলোড ডিরেক্টরি না থাকলে তৈরি করবে
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadPath = $uploadDir . $newFileName;

        if(move_uploaded_file($tmpName, $uploadPath)){

            // এখানে ডাটাবেজ ইনসার্ট করার সময় তোমার টেবিল ফিল্ড subject_name এ $full_subject_name যাচ্ছে
            $sql = "INSERT INTO materials (user_id, title, subject_name, category, file_name, upload_date) 
                    VALUES ('$user_id', '$title', '$full_subject_name', '$category', '$newFileName', NOW())";

            if(mysqli_query($conn, $sql)){
                $message = "Material Uploaded Successfully!";
                $message_class = "success-msg";
            }else{
                $message = "Database Error: " . mysqli_error($conn);
                $message_class = "error-msg";
            }
        }else{
            $message = "File Upload Failed!";
            $message_class = "error-msg";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Material</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/upload.css">
</head>
<body>

    <div class="upload-container">
        <div class="upload-card">
            <h2>Upload Academic Material</h2>
            <p class="subtitle">Share your knowledge with the LU community. Contribution helps everyone excel.</p>

            <?php if(!empty($message)): ?>
                <div class="alert-box <?php echo $message_class; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="upload-form">
                
                <div class="form-group">
                    <label for="title">Material Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g., Introduction to Microeconomics Midterm Notes" required>
                    <span class="input-hint">Use a descriptive title to help others find your resource.</span>
                </div>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label for="subject_name">Subject</label>
                        <select id="subject_name" name="subject_name" required>
                            <option value="" disabled selected>Select a subject</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Economics">Economics</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Business Administration">Business Administration</option>
                        </select>
                    </div>
                    <div class="form-group flex-1">
                        <label for="course_code">Course Code</label>
                        <input type="text" id="course_code" name="course_code" placeholder="e.g., ECON201" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <div class="category-pills">
                        <label class="pill-container">
                            <input type="radio" name="category" value="Notes" checked>
                            <span class="pill">Notes</span>
                        </label>
                        <label class="pill-container">
                            <input type="radio" name="category" value="Exam Prep">
                            <span class="pill">Exam Prep</span>
                        </label>
                        <label class="pill-container">
                            <input type="radio" name="category" value="Lab Report">
                            <span class="pill">Lab Report</span>
                        </label>
                        <label class="pill-container">
                            <input type="radio" name="category" value="Question Paper">
                            <span class="pill">Question Paper</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload File</label>
                    <div class="drag-drop-zone" id="drop-zone">
                        <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                        <h4 id="file-status-text">Drop your file here</h4>
                        <p>or <label for="file-upload" class="browse-link">browse files</label> from your computer</p>
                        <span class="file-hint">Maximum file size 10MB. PDF files only.</span>
                        <input type="file" id="file-upload" name="file_name" accept=".pdf" required style="display:none;">
                    </div>
                </div>

                <hr class="divider">

                <div class="form-actions">
                    <button type="button" class="btn-draft">Save as Draft</button>
                    <button type="submit" name="upload" class="btn-publish">Publish Material</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('file-upload');
        const statusText = document.getElementById('file-status-text');
        const dropZone = document.getElementById('drop-zone');

        // ফাইল সিলেক্ট করা হলে টেক্সট আপডেট হবে
        fileInput.addEventListener('change', function(){
            if(this.files.length > 0) {
                statusText.innerText = "Selected: " + this.files[0].name;
                statusText.style.color = "#0046af";
            }
        });

        // ড্র্যাগ অ্যান্ড ড্রপ ফিচার
        dropZone.addEventListener('dragover', (e) => { 
            e.preventDefault(); 
            dropZone.style.borderColor = '#0046af'; 
            dropZone.style.background = '#f0f4ff';
        });
        
        dropZone.addEventListener('dragleave', () => { 
            dropZone.style.borderColor = '#cbd5e1'; 
            dropZone.style.background = '#fafafa';
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#cbd5e1';
            dropZone.style.background = '#fafafa';
            if(e.dataTransfer.files.length > 0){
                fileInput.files = e.dataTransfer.files;
                statusText.innerText = "Selected: " + e.dataTransfer.files[0].name;
                statusText.style.color = "#0046af";
            }
        });
    </script>
</body>
</html>
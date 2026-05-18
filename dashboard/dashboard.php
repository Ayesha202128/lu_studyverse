<?php
session_start();

// Security check: If the user is not logged in, redirect them back to the index page
if(!isset($_SESSION['user_id'])){
    header("Location: ../index.php"); 
    exit();
}

// Include the master layout engine file
include '../includes/layout.php';

// Render the structural header layout and pass the dynamic tab title
render_layout('header', 'LU StudyVerse - Dashboard');
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<section class="hero-container">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-md-6">
                <span class="hero-badge">Academic Excellence Redefined</span>
                
                <h1 class="hero-title">Master Your Studies with<br>Verified Resources</h1>
                
                <p class="hero-desc">Access a comprehensive library of lecture notes, lab reports, and assignments shared by top-performing students at LU.</p>
                
                <form action="search.php" method="GET" class="search-wrapper">
                    <input type="text" name="query" class="search-input" placeholder="Search for courses, materials, or topics..." required>
                    <button type="submit" class="search-btn">Search</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <div class="hero-image-box">
                    
                    <img src="../assets/img/dash_hero_image.png" alt="Hero Workspace" class="hero-main-img">
                    
                    <div class="hero-float-card">
                        <span class="float-tag">New Today</span>
                        <p class="float-title">Advanced Thermodynamics Notes</p>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="category-section">
    <div class="container">
        
        <div class="category-header">
            <h2 class="category-section-title">Browse by Category</h2>
            <a href="#" class="category-view-all">View All &gt;</a>
        </div>
        
        <div class="category-grid">
            
            <div class="category-card">
                <div class="category-icon-box">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <span class="category-card-title">Notes</span>
            </div>
            
            <div class="category-card">
    <div class="category-icon-box">
        <i class="bi bi-funnel"></i> 
    </div>
    <span class="category-card-title">Lab Reports</span>
</div>
            
            <div class="category-card">
                <div class="category-icon-box">
                    <i class="bi bi-clipboard"></i>
                </div>
                <span class="category-card-title">Assignments</span>
            </div>
            
            <div class="category-card">
                <div class="category-icon-box">
                    <i class="bi bi-question-circle"></i>
                </div>
                <span class="category-card-title">Questions</span>
            </div>
            
        </div>
        
    </div>
</section>


<section class="trending-section">
    <div class="container">
        
        <div class="trending-header">
            <h2 class="trending-title">Trending Materials</h2>
            <div class="filter-dropdown">
                <button class="filter-btn">Most Recent <i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        
        <div class="trending-grid">
            
            <div class="card-featured">
                <div class="feat-badge">Featured</div>
                <div class="feat-rating"><i class="bi bi-star-fill"></i> 4.9</div>
                
                <div class="feat-img-box">
                    <div class="placeholder-doc-view">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                    </div>
                </div>
                
                <div class="feat-content">
                    <h3 class="feat-title-text">Organic Chemistry II: Complete Semester Digest</h3>
                    <p class="feat-desc-text">Comprehensive 120-page guide covering synthesis pathways, mechanism detailed drawings, and laboratory safety protocols...</p>
                    
                    <div class="feat-footer-row">
                        <div class="author-info">
                            <span class="avatar-circle">JD</span>
                            <span class="author-name">Dr. Jane Doe</span>
                        </div>
                        <a href="#" class="btn-download-action">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="sub-cards-grid">
                
                <div class="material-mini-card">
                    <div class="mini-card-header">
                        <span class="badge-type">Notes</span>
                        <button class="btn-bookmark-save"><i class="bi bi-bookmark"></i></button>
                    </div>
                    <h4 class="mini-card-title">Intro to Macroeconomics</h4>
                    <p class="mini-card-body">Detailed lecture notes from Week 1-12. Includes key definitions and exam tips.</p>
                    <div class="mini-card-footer">
                        <span class="meta-info-text">12.4 MB • PDF</span>
                        <i class="bi bi-download download-icon-accent"></i>
                    </div>
                </div>
                
                <div class="material-mini-card">
                    <div class="mini-card-header">
                        <span class="badge-type">Report</span>
                        <button class="btn-bookmark-save"><i class="bi bi-bookmark"></i></button>
                    </div>
                    <h4 class="mini-card-title">Physics Lab: Pendulum Oscillation</h4>
                    <p class="mini-card-body">Full lab report with data tables, error analysis, and final conclusion. Grade A.</p>
                    <div class="mini-card-footer">
                        <span class="meta-info-text">2.1 MB • DOCX</span>
                        <i class="bi bi-download download-icon-accent"></i>
                    </div>
                </div>
                
                <div class="material-mini-card">
                    <div class="mini-card-header">
                        <span class="badge-type">Question</span>
                        <button class="btn-bookmark-save"><i class="bi bi-bookmark"></i></button>
                    </div>
                    <h4 class="mini-card-title">Linear Algebra Practice Exam</h4>
                    <p class="mini-card-body">Collection of previous mid-term questions with step-by-step solutions.</p>
                    <div class="mini-card-footer">
                        <span class="meta-info-text">4.5 MB • PDF</span>
                        <i class="bi bi-download download-icon-accent"></i>
                    </div>
                </div>
                
                <div class="material-mini-card">
                    <div class="mini-card-header">
                        <span class="badge-type">Assignment</span>
                        <button class="btn-bookmark-save"><i class="bi bi-bookmark"></i></button>
                    </div>
                    <h4 class="mini-card-title">Modern History Essay Outline</h4>
                    <p class="mini-card-body">Thematic analysis of industrial revolution impacts on European urban centers.</p>
                    <div class="mini-card-footer">
                        <span class="meta-info-text">1.2 MB • PDF</span>
                        <i class="bi bi-download download-icon-accent"></i>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="pagination-row">
            <button class="btn-load-more">Load More Materials</button>
        </div>
        
    </div>
</section>

<section class="contribute-cta-section">
    <div class="container">
        <div class="cta-blue-banner">
            
            <h2 class="cta-main-title">Contribute to the StudyVerse</h2>
            <p class="cta-subtitle-desc">Share your high-quality study materials and earn recognition within the LU academic community. Helping others has never been easier.</p>
            
            <div class="cta-buttons-row">
                <a href="#" class="btn-cta-primary">
                    <i class="bi bi-file-earmark-arrow-up"></i> Start Uploading
                </a>
                <a href="#" class="btn-cta-secondary">Learn More</a>
            </div>
            
        </div>
    </div>
</section>


<?php 
// Render the structural footer layout sheet
render_layout('footer'); 
?>
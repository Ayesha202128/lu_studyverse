<?php include 'includes/header.php'; ?>

<header class="hero">
    <div class="hero-inner">
        <span class="badge">Academic Excellence Hub</span>
        <h1>Your Academic Universe</h1>
        <p>Find Notes, Lab Reports, and Assignments in One Place. Empower your learning with verified university resources.</p>
        
        <div class="hero-search">
            <i class="fa fa-search icon-gray"></i>
            <input type="text" placeholder="Search by subject or course code (e.g., CSE101)">
            <button class="btn-search">Search Resources</button>
        </div>
    </div>
</header>

<section class="section-categories">
    <div class="container-small">
        <h2>Explore Categories</h2>
        <p class="subtitle">Quick access to the most requested materials.</p>
        
        <div class="grid-categories">
            <div class="card-cat">
                <div class="icon-box"><i class="fa-regular fa-file-lines"></i></div>
                <h3>Notes</h3>
                <p>Lecture summaries & handwritten guides.</p>
            </div>
            <div class="card-cat">
                <div class="icon-box"><i class="fa-solid fa-flask"></i></div>
                <h3>Lab Reports</h3>
                <p>Practical results & experimental analysis.</p>
            </div>
            <div class="card-cat">
                <div class="icon-box"><i class="fa-solid fa-pen-nib"></i></div>
                <h3>Assignments</h3>
                <p>Sample solutions & research templates.</p>
            </div>
            <div class="card-cat">
                <div class="icon-box"><i class="fa-regular fa-file-alt"></i></div>
                <h3>Question Papers</h3>
                <p>Past exams & mock practice sets.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured High-Quality Resources Section -->
<section class="featured-resources">
    <div class="container-small">
        <h2>Featured High-Quality Resources</h2>
        <p class="subtitle">Top-rated materials curated by high-performing students.</p>
        
        <div class="resource-grid">
            <!-- Card 1 -->
            <div class="resource-card">
                <div class="card-img-container">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=400" alt="CS">
                    <span class="category-tag">Computer Science</span>
                </div>
                <div class="card-content">
                    <div class="title-row">
                        <h3>Data Structures Notes</h3>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p>Comprehensive guide covering Trees, Graphs, and Hash Tables with complexity analysis.</p>
                    <div class="author-info">
                        <span class="avatar">JD</span>
                        <span class="author-name">By John Doe • CSE201</span>
                    </div>
                    <button class="btn-view">View Details</button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="resource-card">
                <div class="card-img-container">
                   <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=400" alt="CS">
                    <span class="category-tag tag-chem">Chemistry</span>
                </div>
                <div class="card-content">
                    <div class="title-row">
                        <h3>Organic Synthesis Lab</h3>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p>Detailed report on alcohol oxidation with experimental data and spectral analysis.</p>
                    <div class="author-info">
                        <span class="avatar avatar-blue">AS</span>
                        <span class="author-name">By Alice Smith • CHE102</span>
                    </div>
                    <button class="btn-view">View Details</button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="resource-card">
                <div class="card-img-container">
                   <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=400" alt="CS">
                    <span class="category-tag tag-econ">Economics</span>
                </div>
                <div class="card-content">
                    <div class="title-row">
                        <h3>Macroeconomics Case Study</h3>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p>Assignment on fiscal policy impacts with comprehensive statistical charts and graphs.</p>
                    <div class="author-info">
                        <span class="avatar avatar-purple">MR</span>
                        <span class="author-name">By Mike Ross • ECO301</span>
                    </div>
                    <button class="btn-view">View Details</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose LU StudyVerse Section -->
<section class="why-choose">
    <div class="container-small">
        <h2 class="center-text">Why Choose LU StudyVerse?</h2>
        <p class="subtitle center-text">We streamline your academic journey by providing a high-quality ecosystem for knowledge sharing.</p>
        
        <div class="features-row">
            <div class="feature-item">
                <div class="feature-icon icon-dark"><i class="fa-solid fa-network-wired"></i></div>
                <h4>Centralized Platform</h4>
                <p>Stop searching across multiple groups. Every lecture note and report you need is organized right here.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon icon-blue"><i class="fa-solid fa-bolt"></i></div>
                <h4>Easy Access</h4>
                <p>Our intuitive search and category system ensures you find specific course materials in seconds, not hours.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon icon-light-blue"><i class="fa-regular fa-face-smile"></i></div>
                <h4>Student-Friendly</h4>
                <p>Designed by students, for students. A clean interface that respects your time and academic focus.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="cta-card">
        <h2>Ready to upgrade your study game?</h2>
        <p>Join thousands of students sharing knowledge and excelling in their courses every day.</p>
        <div class="cta-btns">
            <button class="btn-white">Get Started for Free</button>
            <button class="btn-outline">Browse Materials</button>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
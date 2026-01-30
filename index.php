<?php
$conn = mysqli_connect("localhost", "root", "", "ideocollege");

// 1. Filtering Logic
$stream = $_GET['stream'] ?? 'All';
$fee = $_GET['fee'] ?? 'All';
$scholarship = $_GET['scholarship'] ?? 'All';
$eca = $_GET['eca'] ?? 'All';

$sql = "SELECT * FROM colleges WHERE 1=1";
if ($stream != 'All') $sql .= " AND streams LIKE '%$stream%'";
if ($fee != 'All') $sql .= " AND fee_range = '$fee'";
if ($scholarship != 'All') $sql .= " AND scholarship_available LIKE '%$scholarship%'";
if ($eca != 'All') $sql .= " AND activities LIKE '%$eca%'";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEOCOLLEGE | Navigate Your Future</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

<header>
<div class="logo" onclick="window.location.href='index.php'">
  <img src="logo_horizontal.png" alt="IDEOCOLLEGE" height="60">
</div>
    <nav class="modern-nav">
    <a href="#top" class="nav-item">
        <span class="nav-text">Home</span>
        <div class="nav-dot"></div>
    </a>
    <a href="#discover" class="nav-item">
        <span class="nav-text">Colleges</span>
        <div class="nav-dot"></div>
    </a>
    <a href="#about" class="nav-item">
        <span class="nav-text">About</span>
        <div class="nav-dot"></div>
    </a>
</nav>
    <button class="btn-nav-explore" onclick="scrollToId('discover')">Explore Colleges</button>
</header>

<section class="hero">
    <div class="hero-badge" onclick="triggerGlow(this)">
    ✨ Your Future Starts Here
</div>
    <h1>Find Your Perfect <br><span class="accent-text">+2 College in Kathmandu Valley</span></h1>
    <p>Compare fees, ECA, and Scholarship tiers (Upto 100%) instantly.</p>
    </section>

<section id="discover" class="discover-section">
    <div class="filter-container">
        <div class="search-box">
            <i data-lucide="search"></i>
            <input type="text" id="mainSearch" placeholder="Search by name or location..." onkeyup="instantSearch()">
        </div>

        <div class="advanced-filters">
            <div class="filter-group">
                <h4>Stream</h4>
                <button class="pill <?php echo $stream=='All'?'active':''; ?>" onclick="applyFilter('stream', 'All')">All</button>
                <button class="pill <?php echo $stream=='Science'?'active':''; ?>" onclick="applyFilter('stream', 'Science')">Science</button>
                <button class="pill <?php echo $stream=='Management'?'active':''; ?>" onclick="applyFilter('stream', 'Management')">Management</button>
            </div>

            <div class="filter-group">
                <h4>Scholarship Tiers</h4>
                <button class="pill <?php echo $scholarship=='20'?'active':''; ?>" onclick="applyFilter('scholarship', '20')">20%</button>
                <button class="pill <?php echo $scholarship=='40'?'active':''; ?>" onclick="applyFilter('scholarship', '40')">40%</button>
                <button class="pill <?php echo $scholarship=='60'?'active':''; ?>" onclick="applyFilter('scholarship', '60')">60%</button>
                <button class="pill <?php echo $scholarship=='80'?'active':''; ?>" onclick="applyFilter('scholarship', '80')">80%</button>
                <button class="pill <?php echo $scholarship=='100'?'active':''; ?>" onclick="applyFilter('scholarship', '100')">Full</button>
            </div>

            <div class="filter-group">
                <h4>Fee Range</h4>
                <button class="pill <?php echo $fee=='under_1'?'active':''; ?>" onclick="applyFilter('fee', 'under_1')">Under 1L</button>
                <button class="pill <?php echo $fee=='1_1.2'?'active':''; ?>" onclick="applyFilter('fee', '1_1.2')">1-1.2L</button>
                <button class="pill <?php echo $fee=='above_1.5'?'active':''; ?>" onclick="applyFilter('fee', 'above_1.5')">1.5L+</button>
            </div>
        </div>
    </div>

    <div class="college-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="college-card">
            <div class="card-header">
                <span class="short-tag"><?php echo $row['short_name']; ?></span>
                <h3><?php echo $row['name']; ?></h3>
            </div>
            <div class="card-body">
                <p><i data-lucide="map-pin"></i> <?php echo $row['location']; ?></p>
                <p><i data-lucide="clock"></i> <?php echo $row['timing']; ?></p>
                
                <button class="btn-enroll-pink" onclick="openEnroll('<?php echo $row['name']; ?>', <?php echo $row['id']; ?>)">Enroll Now <i data-lucide="arrow-right"></i></button>
                <button class="btn-details-ghost" onclick="toggleDetails(this)">View Details <i data-lucide="chevron-down"></i></button>
                
                <div class="details-pane">
                    <hr>
                    <h5>Fee Details:</h5><p><?php echo $row['fee_details']; ?></p>
                    <h5>Scholarships:</h5><p><?php echo $row['scholarships_text']; ?></p>
                    <h5>Activities:</h5><p><?php echo $row['activities']; ?></p>
                    <div class="contact-box">
                        <small>📞 <?php echo $row['phone']; ?> | ✉️ <?php echo $row['email']; ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<section id="about" class="about-section">
    <h2>About <span>IDEOCOLLEGE</span></h2>
    <div class="about-grid">
        <div class="about-card">Mission: Simplifying selection.</div>
        <div class="about-card">Values: Transparency & Accuracy.</div>
        <div class="about-card">Impact: Helping 10,000+ students.</div>
    </div>
</section>

<div id="enrollModal" class="modal">
    <div class="modal-content">
        <h2 id="m-title">Enroll</h2>
        <form action="submit.php" method="POST">
            <input type="hidden" name="college_id" id="m-id">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="text" name="gpa" placeholder="SEE GPA" required>
            <textarea name="skills" placeholder="ECA Interests"></textarea>
            <p>Select Appointment Date:</p>
            <div class="date-grid">
                <?php for($i=1;$i<5;$i++) { $d=date('Y-m-d', strtotime("+$i days")); echo "<label class='date-pill'><input type='radio' name='date' value='$d' required> ".date('M d', strtotime($d))."</label>"; } ?>
            </div>
            <button type="submit" class="btn-enroll-pink">Submit Request</button>
            <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>

<script src="script.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>

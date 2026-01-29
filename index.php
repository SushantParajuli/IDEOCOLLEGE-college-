<?php
$conn = mysqli_connect("localhost", "root", "", "ideocollege");

$stream = isset($_GET['stream']) ? $_GET['stream'] : 'All';
$sch = isset($_GET['scholarship']) ? $_GET['scholarship'] : 'All';


$sql = "SELECT * FROM colleges WHERE 1=1";
if ($stream != 'All') $sql .= " AND streams LIKE '%$stream%'";
if ($sch != 'All') $sql .= " AND scholarship_available >= $sch";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en" id="top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEOCOLLEGE | Future Starts Here</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

<header>
    <div class="logo">
        <img src="logo_horizontal.png" alt="IDEOCOLLEGE" height="80" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
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
    <div class="hero-badge" onclick="triggerGlow(this)">✨ Your Future Starts Here</div>
    <h1>Compare Top <span class="accent-text">+2 Colleges</span> <br>in Kathmandu Valley</h1>
    <p>Filtered by College Merit & Metro Entrance Quotas.</p>
</section>

<section id="discover" class="filter-container">
    <div class="search-box">
        <i data-lucide="search"></i>
        <input type="text" id="mainSearch" placeholder="Search college name or location..." onkeyup="instantSearch()">
    </div>

    <div class="filter-group">
        <strong>Streams:</strong>
        <button class="pill <?php echo $stream=='All'?'active':''; ?>" onclick="applyFilter('stream', 'All')">All</button>
        <button class="pill <?php echo $stream=='Science'?'active':''; ?>" onclick="applyFilter('stream', 'Science')">Science</button>
        <button class="pill <?php echo $stream=='Management'?'active':''; ?>" onclick="applyFilter('stream', 'Management')">Management</button>
    </div>

    <div class="filter-group">
        <strong>Min Scholarship:</strong>
        <button class="pill <?php echo $sch=='20'?'active':''; ?>" onclick="applyFilter('scholarship', '20')">20%+</button>
        <button class="pill <?php echo $sch=='80'?'active':''; ?>" onclick="applyFilter('scholarship', '80')">80%+</button>
        <button class="pill <?php echo $sch=='100'?'active':''; ?>" onclick="applyFilter('scholarship', '100')">Full</button>
    </div>
</section>

<div class="college-grid">
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="college-card">
        <div class="card-header">
            <span class="short-tag"><?php echo $row['short_name']; ?></span>
            <h3><?php echo $row['name']; ?></h3>
        </div>
        <div class="card-body">
            <p>📍 <?php echo $row['location']; ?></p>
            <p>🎓 <strong>College Merit:</strong> <?php echo ($row['scholarship_available'] == 0) ? "No merit scholarship" : "Up to " . $row['scholarship_available'] . "%"; ?></p>
            
            <button class="btn-enroll-pink">Enroll Now →</button>
            <button class="btn-details-ghost" onclick="toggleDetails(this)">View Details</button>
            
            <div class="details-pane">
                <div class="contact-box">
                    <strong>Scholarship Info:</strong> <?php echo $row['scholarship_text']; ?><br><br>
                    <strong>Fees:</strong> <?php echo $row['fee_details']; ?><br>
                    <strong>Activities:</strong> <?php echo $row['activities']; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<section id="about" style="padding: 100px 8%; text-align: center;">
    <h2>About IDEOCOLLEGE</h2>
    <p>We provide accurate information for students looking to pursue Higher Secondary education in Nepal.</p>
</section>

<script src="script.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>
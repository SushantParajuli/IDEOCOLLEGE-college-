<?php
$conn = mysqli_connect("localhost", "root", "", "ideocollege");

$stream = $_GET['stream'] ?? 'All';
$fee = $_GET['fee'] ?? 'All';
$sch = $_GET['scholarship'] ?? 'All';

$sql = "SELECT * FROM colleges WHERE 1=1";

if ($stream != 'All') $sql .= " AND streams LIKE '%$stream%'";
if ($sch != 'All') $sql .= " AND scholarship_available >= $sch";

if ($fee != 'All') {
    if ($fee == 'below_1.5') $sql .= " AND total_fee < 150000";
    elseif ($fee == '1.5_2') $sql .= " AND total_fee BETWEEN 150000 AND 200000";
    elseif ($fee == '2_2.5') $sql .= " AND total_fee BETWEEN 200000 AND 250000";
    elseif ($fee == '2.5_3') $sql .= " AND total_fee BETWEEN 250000 AND 300000";
    elseif ($fee == '3_4')   $sql .= " AND total_fee BETWEEN 300000 AND 400000";
    elseif ($fee == 'above_4') $sql .= " AND total_fee > 400000";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en" id="top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEOCOLLEGE | Search Filter</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

<header>
    <div class="logo" onclick="scrollToId('top')">
        <img src="image.png" alt="IDEOCOLLEGE" height="60">
    </div>
    <nav class="modern-nav">
        <a href="#top" class="nav-item"><span class="nav-text">Home</span><div class="nav-dot"></div></a>
        <a href="#discover" class="nav-item"><span class="nav-text">Colleges</span><div class="nav-dot"></div></a>
        <a href="#about" class="nav-item"><span class="nav-text">About</span><div class="nav-dot"></div></a>
    </nav>
    <button class="btn-nav-explore" onclick="scrollToId('discover')">Explore Colleges</button>
</header>

<section class="hero">
    <div class="hero-badge" onclick="triggerGlow(this)">✨ Your Future Starts Here</div>
    <h1>Find Your Perfect <br><span class="accent-text">+2 College in Nepal</span></h1>
</section>

<section id="discover" class="filter-container">
    <div class="search-box">
        <i data-lucide="search"></i>
        <input type="text" id="mainSearch" placeholder="Search by name or location..." onkeyup="instantSearch()">
    </div>

    <div class="advanced-filters">
        <div class="filter-group">
            <button class="pill <?php echo $stream=='All'?'active':''; ?>" onclick="applyFilter('stream', 'All')">All Streams</button>
            <button class="pill <?php echo $stream=='Science'?'active':''; ?>" onclick="applyFilter('stream', 'Science')">Science</button>
            <button class="pill <?php echo $stream=='Management'?'active':''; ?>" onclick="applyFilter('stream', 'Management')">Management</button>
            <button class="pill <?php echo $stream=='Law'?'active':''; ?>" onclick="applyFilter('stream', 'Law')">Law</button>
        </div>

        <div class="filter-group">
            <button class="pill <?php echo $fee=='All'?'active':''; ?>" onclick="applyFilter('fee', 'All')">Any Fee</button>
            <button class="pill <?php echo $fee=='below_1.5'?'active':''; ?>" onclick="applyFilter('fee', 'below_1.5')">Below 1.5L</button>
            <button class="pill <?php echo $fee=='1.5_2'?'active':''; ?>" onclick="applyFilter('fee', '1.5_2')">1.5L - 2L</button>
            <button class="pill <?php echo $fee=='2_2.5'?'active':''; ?>" onclick="applyFilter('fee', '2_2.5')">2L - 2.5L</button>
            <button class="pill <?php echo $fee=='2.5_3'?'active':''; ?>" onclick="applyFilter('fee', '2.5_3')">2.5L - 3L</button>
            <button class="pill <?php echo $fee=='above_4'?'active':''; ?>" onclick="applyFilter('fee', 'above_4')">4L+</button>
        </div>
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
            <div class="info-block">
                <p><strong>Fee:</strong> <?php echo $row['fee_details']; ?></p>
                <p><strong>Scholarships:</strong> <?php echo $row['scholarship_text']; ?></p>
            </div>
            <button class="btn-enroll-pink" onclick="openEnroll('<?php echo $row['name']; ?>', <?php echo $row['id']; ?>)">Enroll Now</button>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div id="enrollModal" class="modal">
    <div class="modal-content">
        <h2 id="m-title">Enroll</h2>
        <form action="submit.php" method="POST">
            <input type="hidden" name="college_id" id="m-id">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="text" name="gpa" placeholder="SEE GPA (e.g. 3.8)" required>
            <textarea name="skills" placeholder="ECA Interests (Music, Sports, etc.)"></textarea>
            
            <p style="margin-top:15px; font-weight:bold; font-size:0.9rem;">Select Appointment Date:</p>
            <div class="date-grid">
                <?php 
                for($i=1;$i<5;$i++) { 
                    $d=date('Y-m-d', strtotime("+$i days")); 
                    echo "<label class='date-pill'><input type='radio' name='date' value='$d' required> ".date('M d', strtotime($d))."</label>"; 
                } 
                ?>
            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn-enroll-pink">Submit Request</button>
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
<script>lucide.createIcons();</script>
</body>
</html>

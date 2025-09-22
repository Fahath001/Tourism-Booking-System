<?php
include_once('infop.php'); // Ensure this file has a valid database connection

// Initialize result variable to avoid undefined errors
$result = null;

if(isset($_POST['g'])) {
    $que = "SELECT * FROM `information` WHERE pname='Goa'";
} elseif(isset($_POST['kerala'])) {
    $que = "SELECT * FROM `information` WHERE pname='Kerala'";
} elseif(isset($_POST['mysore'])) {
    $que = "SELECT * FROM `information` WHERE pname='Mysore'";
} elseif(isset($_POST['ladakh'])) {
    $que = "SELECT * FROM `information` WHERE pname='Ladakh'";
} elseif(isset($_POST['agra'])) {
    $que = "SELECT * FROM `information` WHERE pname='Taj Mahal'";
} elseif(isset($_POST['india_gate'])) {
    $que = "SELECT * FROM `information` WHERE pname='India Gate'";
} elseif(isset($_POST['hampi'])) {
    $que = "SELECT * FROM `information` WHERE pname='Hampi'";
} elseif(isset($_POST['rajasthan'])) {
    $que = "SELECT * FROM `information` WHERE pname='Rajasthan'";
} elseif(isset($_POST['manali'])) {
    $que = "SELECT * FROM `information` WHERE pname='Manali'";
} elseif(isset($_POST['srinagar'])) {
    $que = "SELECT * FROM `information` WHERE pname='Srinagar'";
} elseif(isset($_POST['amritsar'])) {
    $que = "SELECT * FROM `information` WHERE pname='Amritsar'";
} elseif(isset($_POST['jogfalls'])) {
    $que = "SELECT * FROM `information` WHERE pname='Jog Falls'";
} elseif(isset($_POST['search_p'])) {
    $search = $_POST['search_p'];
    $que = "SELECT * FROM `information` WHERE pname='$search'";
}

// Execute the query only if it is set
if (isset($que)) {
    $result = mysqli_query($db, $que);
    if (!$result) {
        die("Query failed: " . mysqli_error($db)); // Display error if query fails
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/info.css">
    <title>Information</title>
</head>
<body>
    <div class="main">
        <ul>
            <ul class="list">
                <li class="logo"><a href="mainPage.html"><img src="earth-globe.png" alt="Logo" style="width:36px;height:36px"></a></li>
                <div class="search">
                    <form method="POST" action="info.php">
                        <input type="text" name="search_p" placeholder="Search.." size="50">
                        <input type="image" name="submit_p" src="search_icon.png" alt="Search image" style="width:22;height:22; margin-left: 35px;">
                    </form>
                </div>
            </ul>
            <ul class="list2">
                <li><a href="mainPage.html">Home</a></li>
                <li><a id="long" href="destination.html">Destination</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="feedback.html">Feedback</a></li>
                <li><a href="index.html">Logout</a></li>
            </ul>
        </ul>
    </div>
    <div class="hedder">
        <h1>Place Information</h1>
    </div>
    <div class="container">
        <div class="description-container" style="border: 1px solid black;">
            <div class="box1">
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while($rows = mysqli_fetch_assoc($result)) {
                ?>
                <img src="<?php echo htmlspecialchars($rows['pi_main']); ?>" alt="Image" style="width: auto;height: 302px;">
            </div>
            <div class="description">
                <h1><?php echo htmlspecialchars($rows['pname']); ?></h1>
                <p style="text-align: justify;"><?php echo htmlspecialchars($rows['pdescription']); ?></p>
                <p style="color:red; top: -10px;">Package: <?php echo htmlspecialchars($rows['package']); ?> Rs</p>
            </div>
            <a href="booking.html" style="top: -20px; float: right; margin-right: 27%;">Book Tour</a>
        </div>
        <div class="image-container" style="border: 1px solid black">
            <div class="box">
                <div class="imgBox">
                    <img src="<?php echo htmlspecialchars($rows['pi1']); ?>" alt="Image" style="width: auto;height: 270px;">
                </div>
            </div>
            <div class="box">
                <div class="imgBox">
                    <img src="<?php echo htmlspecialchars($rows['pi2']); ?>" alt="Image" style="width: auto;height: 270px;">
                </div>
            </div>
            <div class="box">
                <div class="imgBox">
                    <img src="<?php echo htmlspecialchars($rows['pi3']); ?>" alt="Image" style="width: auto;height: 270px;">
                </div>
                <?php
                    }
                } else {
                    echo "<p>No results found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

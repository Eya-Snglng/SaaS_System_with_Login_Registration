<?php 
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <div class="left">
            <a href="index.php">Return to Home</a>
        </div>
        <div class="right">
            <a href="core/handleForms.php?logoutAUser=1">Logout</a>
        </div>
    </div>
    <?php $getUserByID = getUserByID($pdo, $_GET['user_id']); ?>
    <h1>First Name: <?php echo $getUserByID['first_name']; ?></h1>
    <h1>Last Name: <?php echo $getUserByID['last_name']; ?></h1>
    <h1>Address: <?php echo $getUserByID['address']; ?></h1>
    <h1>Age: <?php echo $getUserByID['age']; ?></h1>
    <h1>Phone Number: <?php echo $getUserByID['phone_number']; ?></h1>
    <h1>Date Joined: <?php echo $getUserByID['date_added']; ?></h1>
</body>
</html>

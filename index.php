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
    <title>SaaS Vendor Company</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateVendorForm() {
            var vendorName = document.forms["vendorForm"]["vendorName"].value;
            var contactEmail = document.forms["vendorForm"]["contactEmail"].value;
            var serviceType = document.forms["vendorForm"]["serviceType"].value;
            var websiteUrl = document.forms["vendorForm"]["websiteUrl"].value;
            if (vendorName == "" || contactEmail == "" || serviceType == "" || websiteUrl == "") {
                alert("All fields must be filled out");
                return false;
            }
        }
    </script>
</head>
<body>
    <div class="header">
        <div class="right">
            <a href="core/handleForms.php?logoutAUser=1" class="logoutBtn">Logout</a>
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <h3>User List</h3>
            <ul>
                <?php $getAllUsers = getAllUsers($pdo); ?>
                <?php foreach ($getAllUsers as $user) { ?>
                    <li><a href="viewuser.php?user_id=<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="main-content">
            <h1>Welcome To SaaS Vendor Management System. Add new Vendors!</h1>
            <form name="vendorForm" action="core/handleForms.php" method="POST" onsubmit="return validateVendorForm()">
                <p>
                    <label for="vendorName">Vendor Name</label> 
                    <input type="text" name="vendorName">
                </p>
                <p>
                    <label for="contactEmail">Contact Email</label> 
                    <input type="email" name="contactEmail">
                </p>
                <p>
                    <label for="serviceType">Service Type</label> 
                    <input type="text" name="serviceType">
                </p>
                <p>
                    <label for="websiteUrl">Website URL</label> 
                    <input type="url" name="websiteUrl"><br><br>
                    <input type="submit" name="insertVendorBtn">
                </p>
            </form>
            <?php $getAllVendors = getAllVendors($pdo); ?>
            <?php foreach ($getAllVendors as $row) { ?>
            <div class="vendor-box">
                <h3>Vendor Name: <?php echo $row['vendor_name']; ?></h3>
                <h3>Contact Email: <?php echo $row['contact_email']; ?></h3>
                <h3>Service Type: <?php echo $row['service_type']; ?></h3>
                <h3>Website URL: <?php echo $row['website_url']; ?></h3>
                <h3>Date Added: <?php echo $row['date_added']; ?></h3>
                <h3>Added By: <?php echo getUserByID($pdo, $row['added_by'])['username']; ?></h3>
                <h3>Last Updated: <?php echo $row['last_updated']; ?></h3>
                <h3>Last Updated By: <?php echo getUserByID($pdo, $row['last_updated_by'])['username']; ?></h3>

                <div class="editAndDelete">
                    <a href="viewclients.php?vendor_id=<?php echo $row['vendor_id']; ?>">View Clients</a>
                    <a href="editvendor.php?vendor_id=<?php echo $row['vendor_id']; ?>">Edit</a>
                    <a href="deletevendor.php?vendor_id=<?php echo $row['vendor_id']; ?>">Delete</a>
                </div>
            </div> 
            <?php } ?>
        </div>
    </div>
</body>
</html>

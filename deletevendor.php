<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vendor</title>
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
    <h1>Are you sure you want to delete this vendor?</h1>
    <?php $getVendorByID = getVendorByID($pdo, $_GET['vendor_id']); ?>
    <div class="vendor-box">
        <h2>Vendor Name: <?php echo $getVendorByID['vendor_name']; ?></h2>
        <h2>Contact Email: <?php echo $getVendorByID['contact_email']; ?></h2>
        <h2>Service Type: <?php echo $getVendorByID['service_type']; ?></h2>
        <h2>Website URL: <?php echo $getVendorByID['website_url']; ?></h2>
        <h2>Date Added: <?php echo $getVendorByID['date_added']; ?></h2>

        <div class="editAndDelete">
            <form action="core/handleForms.php?vendor_id=<?php echo $_GET['vendor_id']; ?>" method="POST"><br><br>
                <input type="submit" name="deleteVendorBtn" value="Delete">
            </form>            
        </div>    
    </div>
</body>
</html>

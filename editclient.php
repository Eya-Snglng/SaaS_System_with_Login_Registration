<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
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
    <a href="viewclients.php?vendor_id=<?php echo $_GET['vendor_id']; ?>">View The Clients</a>
    <h1>Edit the client!</h1>
    <?php $getClientByID = getClientByID($pdo, $_GET['client_id']); ?>
    <form action="core/handleForms.php?client_id=<?php echo $_GET['client_id']; ?>&vendor_id=<?php echo $_GET['vendor_id']; ?>" method="POST">
        <p>
            <label for="clientName">Client Name</label> 
            <input type="text" name="clientName" value="<?php echo $getClientByID['client_name']; ?>">
        </p>
        <p>
            <label for="email">Email</label> 
            <input type="email" name="email" value="<?php echo $getClientByID['email']; ?>">
        </p>
        <p>
            <label for="subscriptionPlan">Subscription Plan</label> 
            <input type="text" name="subscriptionPlan" value="<?php echo $getClientByID['subscription_plan']; ?>"><br><br>
            <input type="submit" name="editClientBtn">
        </p>
    </form>
</body>
</html>

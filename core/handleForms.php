<?php  
require_once 'models.php';
require_once 'dbConfig.php';

function validateFields($fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return false;
        }
    }
    return true;
}

if (isset($_POST['registerUserBtn'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $phone_number = $_POST['phone_number'];

    if (validateFields([$username, $password, $first_name, $last_name, $address, $age, $phone_number])) {
        $insertQuery = insertNewUser($pdo, $username, $password, $first_name, $last_name, $address, $age, $phone_number);
        if ($insertQuery) {
            header("Location: ../login.php");
        } else {
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure all input fields are filled out for registration!";
        header("Location: ../register.php");
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (validateFields([$username, $password])) {
        $loginQuery = loginUser($pdo, $username, $password);
        if ($loginQuery) {
            header("Location: ../index.php");
        } else {
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure all input fields are filled out for login!";
        header("Location: ../login.php");
    }
}

if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['insertVendorBtn'])) {
    $fields = [$_POST['vendorName'], $_POST['contactEmail'], $_POST['serviceType'], $_POST['websiteUrl']];
    if (validateFields($fields)) {
        $query = insertVendor($pdo, $_POST['vendorName'], $_POST['contactEmail'], $_POST['serviceType'], $_POST['websiteUrl'], $_SESSION['user_id']);
        if ($query) {
            header("Location: ../index.php");
        } else {
            echo "Insertion failed";
        }
    } else {
        echo "All fields must be filled out";
    }
}

if (isset($_POST['editVendorBtn'])) {
    $fields = [$_POST['vendorName'], $_POST['contactEmail'], $_POST['serviceType'], $_POST['websiteUrl']];
    if (validateFields($fields)) {
        $query = updateVendor($pdo, $_POST['vendorName'], $_POST['contactEmail'], $_POST['serviceType'], $_POST['websiteUrl'], $_GET['vendor_id'], $_SESSION['user_id']);
        if ($query) {
            header("Location: ../index.php");
        } else {
            echo "Edit failed";
        }
    } else {
        echo "All fields must be filled out";
    }
}

if (isset($_POST['deleteVendorBtn'])) {
    $query = deleteVendor($pdo, $_GET['vendor_id']);
    if ($query) {
        header("Location: ../index.php");
    } else {
        echo "Deletion failed";
    }
}

if (isset($_POST['insertClientBtn'])) {
    $fields = [$_POST['clientName'], $_POST['email'], $_POST['subscriptionPlan']];
    if (validateFields($fields)) {
        $query = insertClient($pdo, $_POST['clientName'], $_POST['email'], $_POST['subscriptionPlan'], $_GET['vendor_id'], $_SESSION['user_id']);
        if ($query) {
            header("Location: ../viewclients.php?vendor_id=" . $_GET['vendor_id']);
        } else {
            echo "Insertion failed";
        }
    } else {
        echo "All fields must be filled out";
    }
}

if (isset($_POST['editClientBtn'])) {
    $fields = [$_POST['clientName'], $_POST['email'], $_POST['subscriptionPlan']];
    if (validateFields($fields)) {
        $query = updateClient($pdo, $_POST['clientName'], $_POST['email'], $_POST['subscriptionPlan'], $_GET['client_id'], $_SESSION['user_id']);
        if ($query) {
            header("Location: ../viewclients.php?vendor_id=" . $_GET['vendor_id']);
        } else {
            echo "Update failed";
        }
    } else {
        echo "All fields must be filled out";
    }
}

if (isset($_POST['deleteClientBtn'])) {
    $query = deleteClient($pdo, $_GET['client_id']);
    if ($query) {
        header("Location: ../viewclients.php?vendor_id=" . $_GET['vendor_id']);
    } else {
        echo "Deletion failed";
    }
}
?>

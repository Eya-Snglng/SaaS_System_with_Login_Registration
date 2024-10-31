<?php  
require_once 'dbConfig.php';

function insertNewUser($pdo, $username, $password, $first_name, $last_name, $address, $age, $phone_number) {
    $checkUserSql = "SELECT * FROM USER WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {
        $sql = "INSERT INTO USER (username, password, first_name, last_name, address, age, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $password, $first_name, $last_name, $address, $age, $phone_number]);

        if ($executeQuery) {
            $_SESSION['message'] = "User successfully registered";
            return true;
        } else {
            $_SESSION['message'] = "An error occurred during registration";
        }
    } else {
        $_SESSION['message'] = "Username already exists";
    }
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM USER WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username']; 
        $passwordFromDB = $userInfoRow['password'];

        if (password_verify($password, $passwordFromDB)) {
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['user_id'] = $userInfoRow['user_id'];
            $_SESSION['message'] = "Login successful!";
            return true;
        } else {
            $_SESSION['message'] = "Password is invalid, but user exists";
        }
    } else {
        $_SESSION['message'] = "Username doesn't exist in the database. You may consider registering first";
    }
}

function insertVendor($pdo, $vendor_name, $contact_email, $service_type, $website_url, $user_id) {
    $sql = "INSERT INTO SaaS_Vendor (vendor_name, contact_email, service_type, website_url, date_added, added_by, last_updated_by) VALUES (?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$vendor_name, $contact_email, $service_type, $website_url, $user_id, $user_id]);

    if ($executeQuery) {
        return true;
    }
}

function updateVendor($pdo, $vendor_name, $contact_email, $service_type, $website_url, $vendor_id, $user_id) {
    $sql = "UPDATE SaaS_Vendor SET vendor_name = ?, contact_email = ?, service_type = ?, website_url = ?, last_updated = NOW(), last_updated_by = ? WHERE vendor_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$vendor_name, $contact_email, $service_type, $website_url, $user_id, $vendor_id]);

    if ($executeQuery) {
        return true;
    }
}

function deleteVendor($pdo, $vendor_id) {
    $deleteVendorClients = "DELETE FROM SaaS_Client WHERE vendor_id = ?";
    $deleteStmt = $pdo->prepare($deleteVendorClients);
    $executeDeleteQuery = $deleteStmt->execute([$vendor_id]);

    if ($executeDeleteQuery) {
        $sql = "DELETE FROM SaaS_Vendor WHERE vendor_id = ?";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$vendor_id]);

        if ($executeQuery) {
            return true;
        }
    }
}

function insertClient($pdo, $client_name, $email, $subscription_plan, $vendor_id, $user_id) {
    $sql = "INSERT INTO SaaS_Client (client_name, email, subscription_plan, vendor_id, date_added, added_by, last_updated_by) VALUES (?, ?, ?, ?, NOW(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_name, $email, $subscription_plan, $vendor_id, $user_id, $user_id]);

    if ($executeQuery) {
        return true;
    }
}

function updateClient($pdo, $client_name, $email, $subscription_plan, $client_id, $user_id) {
    $sql = "UPDATE SaaS_Client SET client_name = ?, email = ?, subscription_plan = ?, last_updated = NOW(), last_updated_by = ? WHERE client_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_name, $email, $subscription_plan, $user_id, $client_id]);

    if ($executeQuery) {
        return true;
    }
}

function deleteClient($pdo, $client_id) {
    $sql = "DELETE FROM SaaS_Client WHERE client_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_id]);

    if ($executeQuery) {
        return true;
    }
}

function getAllUsers($pdo) {
    $sql = "SELECT * FROM USER";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getUserByID($pdo, $user_id) {
    $sql = "SELECT * FROM USER WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getAllVendors($pdo) {
    $sql = "SELECT * FROM SaaS_Vendor";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getVendorByID($pdo, $vendor_id) {
    $sql = "SELECT * FROM SaaS_Vendor WHERE vendor_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$vendor_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

function getClientsByVendor($pdo, $vendor_id) {
    $sql = "SELECT SaaS_Client.client_id AS client_id, SaaS_Client.client_name AS client_name, SaaS_Client.email AS email, SaaS_Client.subscription_plan AS subscription_plan, SaaS_Client.date_added AS date_added, SaaS_Vendor.vendor_name AS vendor_name, SaaS_Client.added_by AS added_by, SaaS_Client.last_updated AS last_updated, SaaS_Client.last_updated_by AS last_updated_by FROM SaaS_Client JOIN SaaS_Vendor ON SaaS_Client.vendor_id = SaaS_Vendor.vendor_id WHERE SaaS_Client.vendor_id = ? GROUP BY SaaS_Client.client_name";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$vendor_id]);

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

function getClientByID($pdo, $client_id) {
    $sql = "SELECT SaaS_Client.client_id AS client_id, SaaS_Client.client_name AS client_name, SaaS_Client.email AS email, SaaS_Client.subscription_plan AS subscription_plan, SaaS_Client.date_added AS date_added, SaaS_Vendor.vendor_name AS vendor_name, SaaS_Client.added_by AS added_by, SaaS_Client.last_updated AS last_updated, SaaS_Client.last_updated_by AS last_updated_by FROM SaaS_Client JOIN SaaS_Vendor ON SaaS_Client.vendor_id = SaaS_Vendor.vendor_id WHERE SaaS_Client.client_id = ? GROUP BY SaaS_Client.client_name";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$client_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}
?>

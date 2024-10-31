-- Table for Users
CREATE TABLE USER (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    address VARCHAR(255),
    age INT,
    phone_number VARCHAR(15),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Modified Table for SaaS Vendors
CREATE TABLE SaaS_Vendor (
    vendor_id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_name VARCHAR(100) NOT NULL,
    contact_email VARCHAR(100) NOT NULL UNIQUE,
    service_type VARCHAR(50) NOT NULL,
    website_url VARCHAR(100),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    added_by INT,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_updated_by INT,
    FOREIGN KEY (added_by) REFERENCES USER(user_id),
    FOREIGN KEY (last_updated_by) REFERENCES USER(user_id)
);

-- Modified Table for SaaS Clients
CREATE TABLE SaaS_Client (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    subscription_plan VARCHAR(50) NOT NULL,
    vendor_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    added_by INT,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_updated_by INT,
    FOREIGN KEY (vendor_id) REFERENCES SaaS_Vendor(vendor_id),
    FOREIGN KEY (added_by) REFERENCES USER(user_id),
    FOREIGN KEY (last_updated_by) REFERENCES USER(user_id)
);

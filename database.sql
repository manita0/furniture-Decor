-- Furniture & Decor Database

CREATE DATABASE IF NOT EXISTS furniture;
USE furniture;

CREATE TABLE tbl_admin (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'admin'
);

CREATE TABLE tbl_users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(50)
);

CREATE TABLE tbl_product (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_name VARCHAR(255),
    image_hash VARCHAR(32),
    featured ENUM('yes','no') DEFAULT 'no',
    stock INT(11) NOT NULL DEFAULT 0
);

CREATE TABLE tbl_cart (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES tbl_users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES tbl_product(id) ON DELETE CASCADE
);

CREATE TABLE tbl_order (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    qty INT(11) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_contact VARCHAR(20) NOT NULL,
    customer_email VARCHAR(100),
    customer_address VARCHAR(50) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('ordered','pending','shipped','delivered','cancelled') DEFAULT 'ordered',
    FOREIGN KEY (user_id) REFERENCES tbl_users(id)
);

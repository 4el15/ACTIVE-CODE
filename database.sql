CREATE DATABASE iptv_system;
USE iptv_system;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') NOT NULL
);

INSERT INTO users (user_id, password, role) VALUES
(2700, '01097699815', 'admin'),
(1160, '01222741403', 'client'),
(6680, '01225416886', 'client');

CREATE TABLE points (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    points INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE boxes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    status ENUM('green', 'red') DEFAULT 'green',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE DATABASE IF NOT EXISTS meditrust_db;
USE meditrust_db;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dokter') NOT NULL
);

CREATE TABLE patients (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    nik VARCHAR(255) NOT NULL,
    diagnosis TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed data untuk testing mahasiswa
INSERT INTO users (username, password, role) VALUES ('dr_ade', '$2y$10$Veua8ZcwX4xa9KfLljGm7e8s6BPGK4ZRkz88e1N/f0YD7avhZ3uxW', 'dokter');
INSERT INTO patients (name, nik, diagnosis) VALUES ('Budi Santoso', 'le2Rlo9ALWgEJJaMF6vzpbY5PyxIwTIT3bwQ1qDYqJo=', 'Flu Burung');
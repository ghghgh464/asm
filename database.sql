-- Database setup for MMO Services
-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS mmo;
USE mmo;

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(100),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO products (name, description, price, image, category, stock) VALUES
('Netflix Premium', 'Tài khoản Netflix Premium 4K, không giới hạn thiết bị', 150000, 'netflix.png', 'Streaming', 50),
('Spotify Premium', 'Tài khoản Spotify Premium không quảng cáo', 120000, 'spotify premium.png', 'Music', 30),
('Microsoft 365', 'Gói Microsoft 365 Family với Word, Excel, PowerPoint', 800000, 'microsoft 365.png', 'Office', 20),
('Canva Pro', 'Tài khoản Canva Pro cho thiết kế đồ họa', 200000, 'canva pro.png', 'Design', 25),
('CapCut Pro', 'Tài khoản CapCut Pro cho chỉnh sửa video', 180000, 'capcut pro.png', 'Video', 15),
('Xbox Game Pass Ultimate', 'Tài khoản Xbox Game Pass Ultimate 3 tháng', 450000, 'xbox gamepass ultimate.png', 'Gaming', 40),
('Google Drive', 'Google Drive 2TB lưu trữ đám mây', 300000, 'google drive.png', 'Storage', 35),
('MB Bank', 'Tài khoản MB Bank với các tiện ích', 100000, 'mb bank.png', 'Banking', 10),
('MoMo', 'Tài khoản MoMo với ví điện tử', 80000, 'momo.png', 'Payment', 60),
('Tích Xanh', 'Tài khoản Tích Xanh cho doanh nghiệp', 250000, 'tichxanh.png', 'Business', 12); 
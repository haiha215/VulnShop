CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    avatar VARCHAR(255) DEFAULT 'default.jpg'
);

-- Insert dữ liệu mẫu (Password ở đây đang để dạng plain text để dễ test lỗi)
INSERT INTO users (username, password, role) VALUES 
('admin', 'admin123', 'admin'),
('victim', '123456', 'user');

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2)
);

INSERT INTO products (name, description, price) VALUES 
('iPhone 15 Fake', 'Điện thoại giống thật 99%', 150.00),
('Laptop Gaming Cũ', 'Máy nóng nhưng chạy nhanh', 500.00);
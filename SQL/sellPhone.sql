-- Create brands table
CREATE TABLE IF NOT EXISTS brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create phone_models table
CREATE TABLE IF NOT EXISTS phone_models (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand_id INT NOT NULL,
    model_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(id)
);

-- Update phones table to include new fields
CREATE TABLE IF NOT EXISTS phones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand_id INT,
    model_id INT,
    phone_name VARCHAR(255) NOT NULL,
    phone_price DECIMAL(10, 2) NOT NULL,
    phone_storage VARCHAR(50),
    phone_color VARCHAR(50),
    phone_condition INT NOT NULL,
    phone_details TEXT,
    image_paths TEXT NOT NULL,
    seller_name VARCHAR(100) NOT NULL,
    seller_email VARCHAR(100) NOT NULL,
    seller_phone VARCHAR(50) NOT NULL,
    seller_location VARCHAR(100) NOT NULL,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (brand_id) REFERENCES brands(id),
    FOREIGN KEY (model_id) REFERENCES phone_models(id)
);

-- Insert sample brands
INSERT INTO brands (name, logo) VALUES 
('Apple', 'apple-logo.png'),
('Samsung', 'samsung-logo.png'),
('Google', 'google-logo.png'),
('Xiaomi', 'xiaomi-logo.png'),
('OnePlus', 'oneplus-logo.png'),
('Huawei', 'huawei-logo.png'),
('Motorola', 'motorola-logo.png'),
('Sony', 'sony-logo.png'),
('Nokia', 'nokia-logo.png'),
('LG', 'lg-logo.png');

-- Insert sample phone models for Apple
INSERT INTO phone_models (brand_id, model_name) VALUES
(1, 'iPhone 15 Pro Max'),
(1, 'iPhone 15 Pro'),
(1, 'iPhone 15'),
(1, 'iPhone 15 Plus'),
(1, 'iPhone 14 Pro Max'),
(1, 'iPhone 14 Pro'),
(1, 'iPhone 14'),
(1, 'iPhone 14 Plus'),
(1, 'iPhone 13 Pro Max'),
(1, 'iPhone 13 Pro'),
(1, 'iPhone 13'),
(1, 'iPhone 13 Mini'),
(1, 'iPhone 12 Pro Max'),
(1, 'iPhone 12 Pro'),
(1, 'iPhone 12'),
(1, 'iPhone 12 Mini'),
(1, 'iPhone SE (2022)'),
(1, 'iPhone 11 Pro Max'),
(1, 'iPhone 11 Pro'),
(1, 'iPhone 11');

-- Insert sample phone models for Samsung
INSERT INTO phone_models (brand_id, model_name) VALUES
(2, 'Galaxy S23 Ultra'),
(2, 'Galaxy S23+'),
(2, 'Galaxy S23'),
(2, 'Galaxy S22 Ultra'),
(2, 'Galaxy S22+'),
(2, 'Galaxy S22'),
(2, 'Galaxy S21 FE'),
(2, 'Galaxy Z Fold 5'),
(2, 'Galaxy Z Flip 5'),
(2, 'Galaxy Z Fold 4'),
(2, 'Galaxy Z Flip 4'),
(2, 'Galaxy A54'),
(2, 'Galaxy A53'),
(2, 'Galaxy A34'),
(2, 'Galaxy A33'),
(2, 'Galaxy A23'),
(2, 'Galaxy A14'),
(2, 'Galaxy M53'),
(2, 'Galaxy M33'),
(2, 'Galaxy M23');

-- Insert sample phone models for Google
INSERT INTO phone_models (brand_id, model_name) VALUES
(3, 'Pixel 8 Pro'),
(3, 'Pixel 8'),
(3, 'Pixel 7 Pro'),
(3, 'Pixel 7'),
(3, 'Pixel 7a'),
(3, 'Pixel 6 Pro'),
(3, 'Pixel 6'),
(3, 'Pixel 6a'),
(3, 'Pixel 5'),
(3, 'Pixel 5a');

-- Insert sample phone models for Xiaomi
INSERT INTO phone_models (brand_id, model_name) VALUES
(4, 'Xiaomi 13 Pro'),
(4, 'Xiaomi 13'),
(4, 'Xiaomi 12 Pro'),
(4, 'Xiaomi 12'),
(4, 'Xiaomi 12T Pro'),
(4, 'Xiaomi 12T'),
(4, 'Redmi Note 12 Pro+'),
(4, 'Redmi Note 12 Pro'),
(4, 'Redmi Note 12'),
(4, 'Redmi 12');

-- Insert sample phone models for OnePlus
INSERT INTO phone_models (brand_id, model_name) VALUES
(5, 'OnePlus 11'),
(5, 'OnePlus 10 Pro'),
(5, 'OnePlus 10T'),
(5, 'OnePlus Nord 3'),
(5, 'OnePlus Nord 2T'),
(5, 'OnePlus Nord CE 3'),
(5, 'OnePlus Nord CE 2'),
(5, 'OnePlus 9 Pro'),
(5, 'OnePlus 9'),
(5, 'OnePlus 8T');


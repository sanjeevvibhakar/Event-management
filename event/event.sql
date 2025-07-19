
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    name VARCHAR(50),
    email VARCHAR(100),
    registration_no VARCHAR(50),
    gender ENUM('Male', 'Female', 'Other'),
    mobile_no VARCHAR(15),
    password VARCHAR(255)
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('block', 'individual', 'gamezone'),
    poster VARCHAR(255),
    price DECIMAL(10, 2),
    description TEXT
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    event_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

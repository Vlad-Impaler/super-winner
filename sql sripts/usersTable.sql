CREATE TABLE `users` (
                         `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         `username` VARCHAR(50) NOT NULL UNIQUE,
                         `email` VARCHAR(100) NOT NULL UNIQUE,
                         `password` VARCHAR(255) NOT NULL,
                         `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
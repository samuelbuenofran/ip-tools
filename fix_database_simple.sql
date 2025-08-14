-- Simple Database Fix - Add user_id columns without breaking existing functionality
-- This will make your existing tools work with the new MVC system

-- 1. Add user_id column to geo_links table (if it doesn't exist)
ALTER TABLE `geo_links` 
ADD COLUMN IF NOT EXISTS `user_id` int(11) DEFAULT NULL AFTER `id`;

-- 2. Add user_id column to geo_logs table (if it doesn't exist)
ALTER TABLE `geo_logs` 
ADD COLUMN IF NOT EXISTS `user_id` int(11) DEFAULT NULL AFTER `id`;

-- 3. Create users table if it doesn't exist
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL UNIQUE,
    `email` varchar(100) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `first_name` varchar(50) DEFAULT NULL,
    `last_name` varchar(50) DEFAULT NULL,
    `role` enum('user', 'admin') DEFAULT 'user',
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `last_login` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 4. Insert admin user if it doesn't exist
INSERT IGNORE INTO `users` (`username`, `email`, `password`, `first_name`, `last_name`, `role`) 
VALUES ('admin', 'admin@keizai-tech.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', 'admin');

-- 5. Update existing geo_links to have user_id = 1 (admin)
UPDATE `geo_links` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- 6. Update existing geo_logs to have user_id = 1 (admin)
UPDATE `geo_logs` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- 7. Add missing columns to geo_logs for tracking to work properly
ALTER TABLE `geo_logs` 
ADD COLUMN IF NOT EXISTS `location_type` enum('IP','GPS','Manual') DEFAULT 'IP' AFTER `longitude`;

-- 8. Update existing geo_logs to have location_type = 'IP' if it's NULL
UPDATE `geo_logs` SET `location_type` = 'IP' WHERE `location_type` IS NULL;

-- Done! Your existing tools should now work without errors.

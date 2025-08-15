-- Fix Heatmap Database Issues
-- This will add all missing columns needed for the heatmap to work

-- 1. Add missing columns to geo_links table
ALTER TABLE `geo_links` 
ADD COLUMN IF NOT EXISTS `click_count` int(11) DEFAULT 0 AFTER `clicks`,
ADD COLUMN IF NOT EXISTS `user_id` int(11) DEFAULT NULL AFTER `id`;

-- 2. Add missing columns to geo_logs table  
ALTER TABLE `geo_logs` 
ADD COLUMN IF NOT EXISTS `device_type` varchar(50) DEFAULT NULL AFTER `user_agent`,
ADD COLUMN IF NOT EXISTS `location_type` enum('IP','GPS','Manual') DEFAULT 'IP' AFTER `longitude`,
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

-- 5. Update existing records to have user_id = 1 (admin)
UPDATE `geo_links` SET `user_id` = 1 WHERE `user_id` IS NULL;
UPDATE `geo_logs` SET `user_id` = 1 WHERE `user_id` IS NULL;

-- 6. Update existing geo_logs to have location_type = 'IP' if null
UPDATE `geo_logs` SET `location_type` = 'IP' WHERE `location_type` IS NULL;

-- 7. Update clicks column to match click_count values
UPDATE `geo_links` SET `clicks` = `click_count` WHERE `clicks` IS NULL OR `clicks` = 0;

-- 8. Add indexes for better performance
ALTER TABLE `geo_links` ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);
ALTER TABLE `geo_logs` ADD INDEX IF NOT EXISTS `idx_user_id` (`user_id`);
ALTER TABLE `geo_logs` ADD INDEX IF NOT EXISTS `idx_link_id` (`link_id`);
ALTER TABLE `geo_logs` ADD INDEX IF NOT EXISTS `idx_timestamp` (`timestamp`);

-- 9. Show current status
SELECT 
    'geo_links' as table_name,
    COUNT(*) as total_records,
    COUNT(CASE WHEN click_count > 0 THEN 1 END) as records_with_clicks
FROM geo_links
UNION ALL
SELECT 
    'geo_logs' as table_name,
    COUNT(*) as total_records,
    COUNT(CASE WHEN latitude IS NOT NULL AND longitude IS NOT NULL THEN 1 END) as records_with_coordinates
FROM geo_logs;

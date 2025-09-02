-- Users table for authentication system
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
    PRIMARY KEY (`id`),
    KEY `idx_username` (`username`),
    KEY `idx_email` (`email`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- Insert default admin user (password: admin123)
INSERT INTO `users` (
        `username`,
        `email`,
        `password`,
        `first_name`,
        `last_name`,
        `role`
    )
VALUES (
        'admin',
        'admin@keizai-tech.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Admin',
        'User',
        'admin'
    );
-- Update geo_links table to include user_id
ALTER TABLE `geo_links`
ADD COLUMN `user_id` int(11) DEFAULT NULL
AFTER `id`;
ALTER TABLE `geo_links`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE
SET NULL;
-- Update geo_logs table to include user_id
ALTER TABLE `geo_logs`
ADD COLUMN `user_id` int(11) DEFAULT NULL
AFTER `id`;
ALTER TABLE `geo_logs`
ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE
SET NULL;
-- Create user_sessions table for session management
CREATE TABLE IF NOT EXISTS `user_sessions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `session_id` varchar(255) NOT NULL,
    `ip_address` varchar(45) DEFAULT NULL,
    `user_agent` text,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `expires_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_session_id` (`session_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
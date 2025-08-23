-- Fix missing columns for heatmap functionality
-- This script adds the missing columns that are preventing heatmap data from being saved

-- 1. Add accuracy column to geo_logs table
ALTER TABLE `geo_logs` ADD COLUMN `accuracy` decimal(10,2) DEFAULT NULL AFTER `longitude`;

-- 2. Add location_type column to geo_logs table  
ALTER TABLE `geo_logs` ADD COLUMN `location_type` enum('IP','GPS','Manual') DEFAULT 'IP' AFTER `accuracy`;

-- 3. Update existing records to have location_type = 'IP'
UPDATE `geo_logs` SET `location_type` = 'IP' WHERE `location_type` IS NULL;

-- 4. Add indexes for better performance
ALTER TABLE `geo_logs` ADD INDEX `idx_latitude_longitude` (`latitude`, `longitude`);
ALTER TABLE `geo_logs` ADD INDEX `idx_location_type` (`location_type`);

-- 5. Verify the table structure
DESCRIBE `geo_logs`;

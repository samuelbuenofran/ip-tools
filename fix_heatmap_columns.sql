-- Fix missing columns for heatmap functionality
-- This script adds the missing columns that are preventing heatmap data from being saved

-- Note: accuracy column already exists, so we skip adding it

-- 1. Add location_type column to geo_logs table  
ALTER TABLE `geo_logs` ADD COLUMN `location_type` enum('IP','GPS','Manual') DEFAULT 'IP' AFTER `accuracy`;

-- 2. Update existing records to have location_type = 'IP'
UPDATE `geo_logs` SET `location_type` = 'IP' WHERE `location_type` IS NULL;

-- 3. Add indexes for better performance
ALTER TABLE `geo_logs` ADD INDEX `idx_latitude_longitude` (`latitude`, `longitude`);
ALTER TABLE `geo_logs` ADD INDEX `idx_location_type` (`location_type`);

-- 4. Verify the table structure
DESCRIBE `geo_logs`;

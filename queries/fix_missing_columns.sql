-- Fix Missing Columns - Only adds what the code expects
-- This script only adds columns that are missing from the existing structure

-- 1. Add clicks column to geo_links (the code expects 'clicks' but table has 'click_count')
ALTER TABLE `geo_links` ADD COLUMN `clicks` int(11) DEFAULT 0 AFTER `click_count`;

-- 2. Update clicks column to match click_count values
UPDATE `geo_links` SET `clicks` = `click_count` WHERE `clicks` IS NULL OR `clicks` = 0;

-- 3. Add location_type column to geo_logs if it doesn't exist
ALTER TABLE `geo_logs` ADD COLUMN `location_type` enum('IP','GPS','Manual') DEFAULT 'IP' AFTER `longitude`;

-- 4. Update existing geo_logs to have location_type = 'IP'
UPDATE `geo_logs` SET `location_type` = 'IP' WHERE `location_type` IS NULL;

-- Done! This should fix the missing columns issue.

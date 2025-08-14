-- Fix Only Missing Columns - Add only what's actually missing
-- Based on the test results, we only need to add the 'clicks' column

-- 1. Add clicks column to geo_links (the code expects 'clicks' but table has 'click_count')
ALTER TABLE `geo_links` ADD COLUMN `clicks` int(11) DEFAULT 0 AFTER `click_count`;

-- 2. Update clicks column to match click_count values
UPDATE `geo_links` SET `clicks` = `click_count` WHERE `clicks` IS NULL OR `clicks` = 0;

-- Done! This should fix the missing clicks column issue.

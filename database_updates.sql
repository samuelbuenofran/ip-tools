-- Add columns for precise GPS location tracking
ALTER TABLE geo_logs
ADD COLUMN accuracy DECIMAL(10, 2) NULL COMMENT 'GPS accuracy in meters',
    ADD COLUMN address TEXT NULL COMMENT 'Full street address from reverse geocoding',
    ADD COLUMN location_type ENUM('IP', 'GPS') DEFAULT 'IP' COMMENT 'Source of location data';
-- Add index for better performance on location queries
CREATE INDEX idx_location_type ON geo_logs(location_type);
CREATE INDEX idx_accuracy ON geo_logs(accuracy);
-- Update existing records to have location_type = 'IP'
UPDATE geo_logs
SET location_type = 'IP'
WHERE location_type IS NULL;
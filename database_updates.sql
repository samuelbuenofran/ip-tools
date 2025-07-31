-- Enhanced precise location tracking
ALTER TABLE geo_logs
ADD COLUMN accuracy DECIMAL(10, 2) NULL COMMENT 'GPS accuracy in meters',
    ADD COLUMN address TEXT NULL COMMENT 'Full street address from reverse geocoding',
    ADD COLUMN location_type ENUM('IP', 'GPS') DEFAULT 'IP' COMMENT 'Source of location data',
    ADD COLUMN street VARCHAR(255) NULL COMMENT 'Street name',
    ADD COLUMN house_number VARCHAR(20) NULL COMMENT 'House/building number',
    ADD COLUMN postcode VARCHAR(20) NULL COMMENT 'Postal/ZIP code',
    ADD COLUMN state VARCHAR(100) NULL COMMENT 'State/Province';
CREATE INDEX idx_location_type ON geo_logs(location_type);
CREATE INDEX idx_accuracy ON geo_logs(accuracy);
CREATE INDEX idx_street ON geo_logs(street);
CREATE INDEX idx_postcode ON geo_logs(postcode);
UPDATE geo_logs
SET location_type = 'IP'
WHERE location_type IS NULL;
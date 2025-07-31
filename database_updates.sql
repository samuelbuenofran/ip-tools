-- Database is already fully set up for precise location tracking!
-- All required columns exist: accuracy, address, location_type, street, house_number, postcode, state
-- Just update any existing records to have location_type = 'IP' if it's NULL
UPDATE geo_logs
SET location_type = 'IP'
WHERE location_type IS NULL;
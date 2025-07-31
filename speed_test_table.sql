-- Speed Test Database Table
-- Table for storing speed test results
CREATE TABLE speed_tests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL COMMENT 'User IP address',
    download_speed DECIMAL(10, 2) NOT NULL COMMENT 'Download speed in Mbps',
    upload_speed DECIMAL(10, 2) NOT NULL COMMENT 'Upload speed in Mbps',
    ping DECIMAL(8, 2) NOT NULL COMMENT 'Ping time in milliseconds',
    jitter DECIMAL(8, 2) DEFAULT 0 COMMENT 'Jitter in milliseconds',
    country VARCHAR(100) DEFAULT 'Unknown' COMMENT 'Country from IP geolocation',
    city VARCHAR(100) DEFAULT 'Unknown' COMMENT 'City from IP geolocation',
    user_agent TEXT COMMENT 'Browser/device information',
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'When test was performed',
    INDEX idx_ip_address (ip_address),
    INDEX idx_timestamp (timestamp),
    INDEX idx_download_speed (download_speed),
    INDEX idx_upload_speed (upload_speed),
    INDEX idx_ping (ping),
    INDEX idx_country (country)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- Add some sample data for testing
INSERT INTO speed_tests (
        ip_address,
        download_speed,
        upload_speed,
        ping,
        jitter,
        country,
        city,
        user_agent
    )
VALUES (
        '192.168.1.100',
        85.5,
        12.3,
        15.2,
        2.1,
        'United States',
        'New York',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ),
    (
        '10.0.0.50',
        120.8,
        25.7,
        8.9,
        1.5,
        'Canada',
        'Toronto',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36'
    ),
    (
        '172.16.0.25',
        45.2,
        8.1,
        32.4,
        4.2,
        'Brazil',
        'São Paulo',
        'Mozilla/5.0 (Linux; Android 11; SM-G991B) AppleWebKit/537.36'
    ),
    (
        '203.0.113.10',
        200.1,
        50.3,
        5.2,
        0.8,
        'Japan',
        'Tokyo',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ),
    (
        '198.51.100.75',
        75.3,
        15.8,
        18.7,
        3.1,
        'Germany',
        'Berlin',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36'
    );
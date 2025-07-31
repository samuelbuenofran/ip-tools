-- Phone Tracking Database Tables
-- Table for storing SMS tracking information
CREATE TABLE phone_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(20) NOT NULL COMMENT 'Phone number with country code',
    message_text TEXT NOT NULL COMMENT 'SMS message content',
    original_url TEXT NOT NULL COMMENT 'Original URL to redirect to',
    tracking_code VARCHAR(8) NOT NULL UNIQUE COMMENT 'Unique tracking code',
    tracking_link TEXT NOT NULL COMMENT 'Generated tracking URL',
    status ENUM('pending', 'clicked') DEFAULT 'pending' COMMENT 'Tracking status',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'When tracking was created',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last update time',
    INDEX idx_tracking_code (tracking_code),
    INDEX idx_phone_number (phone_number),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- Table for storing click events
CREATE TABLE phone_clicks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_code VARCHAR(8) NOT NULL COMMENT 'Reference to tracking code',
    ip_address VARCHAR(45) NOT NULL COMMENT 'Visitor IP address',
    user_agent TEXT COMMENT 'Browser/device information',
    referrer TEXT COMMENT 'Where the visitor came from',
    country VARCHAR(100) DEFAULT 'Unknown' COMMENT 'Country from IP geolocation',
    city VARCHAR(100) DEFAULT 'Unknown' COMMENT 'City from IP geolocation',
    device_type ENUM('Mobile', 'Desktop', 'Tablet') DEFAULT 'Desktop' COMMENT 'Device type',
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'When click occurred',
    INDEX idx_tracking_code (tracking_code),
    INDEX idx_ip_address (ip_address),
    INDEX idx_timestamp (timestamp),
    INDEX idx_device_type (device_type),
    FOREIGN KEY (tracking_code) REFERENCES phone_tracking(tracking_code) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- Add some sample data for testing
INSERT INTO phone_tracking (
        phone_number,
        message_text,
        original_url,
        tracking_code,
        tracking_link,
        status
    )
VALUES (
        '+1234567890',
        'Check out this amazing deal!',
        'https://example.com/deal',
        'ABC123XY',
        'https://keizai-tech.com/projects/ip-tools/phone-tracker/track.php?code=ABC123XY',
        'pending'
    ),
    (
        '+9876543210',
        'Your order is ready for pickup',
        'https://example.com/order',
        'DEF456ZW',
        'https://keizai-tech.com/projects/ip-tools/phone-tracker/track.php?code=DEF456ZW',
        'clicked'
    ),
    (
        '+1122334455',
        'New message from your friend',
        'https://example.com/message',
        'GHI789AB',
        'https://keizai-tech.com/projects/ip-tools/phone-tracker/track.php?code=GHI789AB',
        'pending'
    );
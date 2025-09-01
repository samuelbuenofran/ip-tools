# IP Tools Suite - API Reference

## 🚀 **API Overview**

The IP Tools Suite API provides programmatic access to all features, allowing you to integrate geolocation tracking, network analysis, and digital forensics capabilities into your applications.

**Base URL:** `https://your-domain.com/projects/ip-tools/public/api/v1`

**Authentication:** Bearer Token (JWT) or API Key

**Rate Limits:** 1000 requests per hour per API key

## 🔐 **Authentication**

### **Getting an API Key**

1. **Login to your account**
2. **Navigate to Profile Settings → API Keys**
3. **Generate a new API key**
4. **Copy the key and keep it secure**

### **Using Your API Key**

Include your API key in the request headers:

```http
Authorization: Bearer YOUR_API_KEY_HERE
Content-Type: application/json
```

### **API Key Permissions**

- **Read Access**: View data and analytics
- **Write Access**: Create and modify resources
- **Admin Access**: Full system access (admin users only)

## 📡 **API Endpoints**

### **Authentication Endpoints**

#### **POST /auth/login**
Authenticate a user and receive an access token.

**Request Body:**
```json
{
  "username": "user@example.com",
  "password": "secure_password"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
      "id": 123,
      "username": "user@example.com",
      "role": "user",
      "permissions": ["read", "write"]
    }
  }
}
```

#### **POST /auth/register**
Register a new user account.

**Request Body:**
```json
{
  "username": "newuser",
  "email": "newuser@example.com",
  "password": "secure_password",
  "first_name": "John",
  "last_name": "Doe"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "user_id": 124,
    "message": "Account created successfully"
  }
}
```

#### **POST /auth/logout**
Invalidate the current access token.

**Response:**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### **Geolocation Tracking Endpoints**

#### **POST /geolocation/links**
Create a new tracking link.

**Request Body:**
```json
{
  "destination_url": "https://example.com",
  "name": "Marketing Campaign A",
  "expires_at": "2024-12-31T23:59:59Z",
  "stealth_mode": "normal",
  "custom_parameters": {
    "campaign_id": "Q1_2024",
    "source": "email"
  }
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "tracking_link": "https://your-domain.com/track/abc123",
    "tracking_code": "abc123",
    "qr_code_url": "https://your-domain.com/qr/abc123.png",
    "expires_at": "2024-12-31T23:59:59Z",
    "created_at": "2024-01-15T10:30:00Z"
  }
}
```

#### **GET /geolocation/links**
Retrieve all tracking links for the authenticated user.

**Query Parameters:**
- `page` (optional): Page number for pagination (default: 1)
- `limit` (optional): Items per page (default: 20, max: 100)
- `status` (optional): Filter by status (active, expired, all)
- `search` (optional): Search by link name or destination

**Response:**
```json
{
  "success": true,
  "data": {
    "links": [
      {
        "id": 1,
        "tracking_code": "abc123",
        "name": "Marketing Campaign A",
        "destination_url": "https://example.com",
        "tracking_link": "https://your-domain.com/track/abc123",
        "clicks_count": 45,
        "unique_visitors": 32,
        "status": "active",
        "created_at": "2024-01-15T10:30:00Z",
        "expires_at": "2024-12-31T23:59:59Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "total_pages": 3,
      "total_items": 67,
      "items_per_page": 20
    }
  }
}
```

#### **GET /geolocation/links/{tracking_code}**
Get detailed information about a specific tracking link.

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "tracking_code": "abc123",
    "name": "Marketing Campaign A",
    "destination_url": "https://example.com",
    "tracking_link": "https://your-domain.com/track/abc123",
    "qr_code_url": "https://your-domain.com/qr/abc123.png",
    "stealth_mode": "normal",
    "custom_parameters": {
      "campaign_id": "Q1_2024",
      "source": "email"
    },
    "clicks_count": 45,
    "unique_visitors": 32,
    "status": "active",
    "created_at": "2024-01-15T10:30:00Z",
    "expires_at": "2024-12-31T23:59:59Z"
  }
}
```

#### **DELETE /geolocation/links/{tracking_code}**
Delete a tracking link and all associated data.

**Response:**
```json
{
  "success": true,
  "message": "Tracking link deleted successfully"
}
```

#### **GET /geolocation/links/{tracking_code}/logs**
Get tracking logs for a specific link.

**Query Parameters:**
- `page` (optional): Page number for pagination
- `limit` (optional): Items per page (default: 50, max: 200)
- `start_date` (optional): Filter logs from this date (ISO 8601)
- `end_date` (optional): Filter logs until this date (ISO 8601)
- `device_type` (optional): Filter by device type (mobile, desktop, tablet)
- `country` (optional): Filter by country code

**Response:**
```json
{
  "success": true,
  "data": {
    "logs": [
      {
        "id": 1,
        "ip_address": "192.168.1.1",
        "country": "United States",
        "city": "New York",
        "state": "NY",
        "latitude": 40.7128,
        "longitude": -74.0060,
        "device_type": "mobile",
        "browser": "Chrome",
        "operating_system": "Android",
        "user_agent": "Mozilla/5.0...",
        "referrer": "https://google.com",
        "clicked_at": "2024-01-15T14:30:00Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "total_pages": 2,
      "total_items": 45,
      "items_per_page": 50
    }
  }
}
```

#### **GET /geolocation/links/{tracking_code}/analytics**
Get analytics summary for a tracking link.

**Query Parameters:**
- `period` (optional): Time period (day, week, month, year, custom)
- `start_date` (optional): Start date for custom period
- `end_date` (optional): End date for custom period

**Response:**
```json
{
  "success": true,
  "data": {
    "summary": {
      "total_clicks": 45,
      "unique_visitors": 32,
      "click_through_rate": 0.71,
      "average_clicks_per_visitor": 1.41
    },
    "geographic_distribution": [
      {
        "country": "United States",
        "clicks": 25,
        "percentage": 55.6
      },
      {
        "country": "Canada",
        "clicks": 12,
        "percentage": 26.7
      }
    ],
    "device_breakdown": [
      {
        "device_type": "mobile",
        "clicks": 28,
        "percentage": 62.2
      },
      {
        "device_type": "desktop",
        "clicks": 17,
        "percentage": 37.8
      }
    ],
    "hourly_distribution": [
      {
        "hour": 9,
        "clicks": 5
      },
      {
        "hour": 10,
        "clicks": 8
      }
    ]
  }
}
```

### **Phone Tracking Endpoints**

#### **POST /phone-tracking/sms**
Send SMS messages with tracking links.

**Request Body:**
```json
{
  "phone_numbers": ["+1234567890", "+0987654321"],
  "message": "Check out our new product: {tracking_link}",
  "campaign_name": "Product Launch SMS",
  "tracking_link_id": "abc123"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "campaign_id": "sms_789",
    "messages_sent": 2,
    "delivery_status": "sent",
    "estimated_delivery_time": "2-5 minutes"
  }
}
```

#### **GET /phone-tracking/campaigns**
Get all SMS campaigns.

**Query Parameters:**
- `page` (optional): Page number for pagination
- `limit` (optional): Items per page
- `status` (optional): Filter by status (sent, delivered, failed)

**Response:**
```json
{
  "success": true,
  "data": {
    "campaigns": [
      {
        "id": "sms_789",
        "name": "Product Launch SMS",
        "phone_numbers_count": 2,
        "messages_sent": 2,
        "delivery_status": "delivered",
        "click_through_rate": 0.5,
        "created_at": "2024-01-15T10:30:00Z"
      }
    ]
  }
}
```

#### **GET /phone-tracking/campaigns/{campaign_id}/analytics**
Get analytics for a specific SMS campaign.

**Response:**
```json
{
  "success": true,
  "data": {
    "campaign_id": "sms_789",
    "name": "Product Launch SMS",
    "summary": {
      "total_recipients": 2,
      "messages_delivered": 2,
      "clicks_received": 1,
      "click_through_rate": 0.5
    },
    "recipient_analytics": [
      {
        "phone_number": "+1234567890",
        "delivery_status": "delivered",
        "clicked_at": "2024-01-15T14:30:00Z",
        "device_type": "mobile",
        "location": "New York, NY"
      }
    ]
  }
}
```

### **Speed Test Endpoints**

#### **POST /speed-test/run**
Run a new speed test.

**Request Body:**
```json
{
  "test_type": "detailed",
  "server_location": "auto",
  "custom_parameters": {
    "download_size": "100MB",
    "upload_size": "50MB"
  }
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "test_id": "speed_456",
    "status": "running",
    "estimated_completion": "2-3 minutes",
    "progress_url": "/api/v1/speed-test/speed_456/progress"
  }
}
```

#### **GET /speed-test/{test_id}**
Get speed test results.

**Response:**
```json
{
  "success": true,
  "data": {
    "test_id": "speed_456",
    "status": "completed",
    "results": {
      "download_speed": 85.5,
      "upload_speed": 12.3,
      "ping": 15,
      "jitter": 2.1,
      "packet_loss": 0.0
    },
    "server_info": {
      "location": "New York, NY",
      "isp": "Comcast",
      "distance": "25 km"
    },
    "test_metadata": {
      "started_at": "2024-01-15T10:30:00Z",
      "completed_at": "2024-01-15T10:32:30Z",
      "duration": "2 minutes 30 seconds"
    }
  }
}
```

#### **GET /speed-test/history**
Get speed test history.

**Query Parameters:**
- `page` (optional): Page number for pagination
- `limit` (optional): Items per page
- `period` (optional): Time period (day, week, month, year)
- `min_download_speed` (optional): Minimum download speed filter
- `max_ping` (optional): Maximum ping filter

**Response:**
```json
{
  "success": true,
  "data": {
    "tests": [
      {
        "test_id": "speed_456",
        "download_speed": 85.5,
        "upload_speed": 12.3,
        "ping": 15,
        "test_date": "2024-01-15T10:30:00Z",
        "rating": "excellent"
      }
    ],
    "statistics": {
      "average_download": 82.1,
      "average_upload": 11.8,
      "average_ping": 18,
      "total_tests": 45
    }
  }
}
```

### **User Management Endpoints**

#### **GET /user/profile**
Get current user profile information.

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 123,
    "username": "user@example.com",
    "first_name": "John",
    "last_name": "Doe",
    "role": "user",
    "permissions": ["read", "write"],
    "account_created": "2024-01-01T00:00:00Z",
    "last_login": "2024-01-15T10:00:00Z",
    "preferences": {
      "theme": "dark",
      "language": "en",
      "timezone": "America/New_York"
    }
  }
}
```

#### **PUT /user/profile**
Update user profile information.

**Request Body:**
```json
{
  "first_name": "John",
  "last_name": "Smith",
  "preferences": {
    "theme": "light",
    "language": "en"
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Profile updated successfully"
}
```

#### **POST /user/change-password**
Change user password.

**Request Body:**
```json
{
  "current_password": "old_password",
  "new_password": "new_secure_password"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Password changed successfully"
}
```

### **Admin Endpoints (Admin Users Only)**

#### **GET /admin/users**
Get all users in the system.

**Query Parameters:**
- `page` (optional): Page number for pagination
- `limit` (optional): Items per page
- `role` (optional): Filter by user role
- `status` (optional): Filter by account status

**Response:**
```json
{
  "success": true,
  "data": {
    "users": [
      {
        "id": 123,
        "username": "user@example.com",
        "role": "user",
        "status": "active",
        "created_at": "2024-01-01T00:00:00Z",
        "last_login": "2024-01-15T10:00:00Z"
      }
    ]
  }
}
```

#### **POST /admin/users**
Create a new user account.

**Request Body:**
```json
{
  "username": "newadmin@example.com",
  "password": "secure_password",
  "first_name": "Admin",
  "last_name": "User",
  "role": "admin"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "user_id": 125,
    "message": "User created successfully"
  }
}
```

## 📊 **Data Models**

### **Tracking Link Object**
```json
{
  "id": "integer",
  "tracking_code": "string",
  "name": "string",
  "destination_url": "string",
  "tracking_link": "string",
  "qr_code_url": "string",
  "stealth_mode": "string (normal|stealth|ultimate)",
  "custom_parameters": "object",
  "clicks_count": "integer",
  "unique_visitors": "integer",
  "status": "string (active|expired|deleted)",
  "created_at": "datetime (ISO 8601)",
  "expires_at": "datetime (ISO 8601)"
}
```

### **Tracking Log Object**
```json
{
  "id": "integer",
  "ip_address": "string",
  "country": "string",
  "city": "string",
  "state": "string",
  "latitude": "float",
  "longitude": "float",
  "device_type": "string (mobile|desktop|tablet)",
  "browser": "string",
  "operating_system": "string",
  "user_agent": "string",
  "referrer": "string",
  "clicked_at": "datetime (ISO 8601)"
}
```

### **Speed Test Object**
```json
{
  "test_id": "string",
  "status": "string (running|completed|failed)",
  "results": {
    "download_speed": "float (Mbps)",
    "upload_speed": "float (Mbps)",
    "ping": "integer (ms)",
    "jitter": "float (ms)",
    "packet_loss": "float (%)"
  },
  "server_info": {
    "location": "string",
    "isp": "string",
    "distance": "string"
  },
  "test_metadata": {
    "started_at": "datetime (ISO 8601)",
    "completed_at": "datetime (ISO 8601)",
    "duration": "string"
  }
}
```

## 🔧 **Error Handling**

### **Error Response Format**
```json
{
  "success": false,
  "error": {
    "code": "ERROR_CODE",
    "message": "Human readable error message",
    "details": "Additional error details",
    "timestamp": "2024-01-15T10:30:00Z"
  }
}
```

### **Common Error Codes**

| Code | HTTP Status | Description |
|------|-------------|-------------|
| `AUTH_REQUIRED` | 401 | Authentication required |
| `INVALID_TOKEN` | 401 | Invalid or expired token |
| `PERMISSION_DENIED` | 403 | Insufficient permissions |
| `RESOURCE_NOT_FOUND` | 404 | Requested resource not found |
| `VALIDATION_ERROR` | 422 | Request validation failed |
| `RATE_LIMIT_EXCEEDED` | 429 | Rate limit exceeded |
| `INTERNAL_ERROR` | 500 | Internal server error |

### **Validation Errors**
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Validation failed",
    "details": {
      "destination_url": ["The destination URL field is required"],
      "name": ["The name field must be at least 3 characters"]
    }
  }
}
```

## 📈 **Rate Limiting**

### **Rate Limit Headers**
```http
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 999
X-RateLimit-Reset: 1642248000
```

### **Rate Limit Rules**
- **Standard Users**: 1000 requests per hour
- **Premium Users**: 5000 requests per hour
- **Admin Users**: 10000 requests per hour

### **Rate Limit Exceeded Response**
```json
{
  "success": false,
  "error": {
    "code": "RATE_LIMIT_EXCEEDED",
    "message": "Rate limit exceeded. Try again in 3600 seconds.",
    "retry_after": 3600
  }
}
```

## 🔐 **Security Considerations**

### **HTTPS Required**
All API endpoints require HTTPS connections. HTTP requests will be redirected to HTTPS.

### **API Key Security**
- Keep your API key secure and don't share it
- Rotate your API key regularly
- Use environment variables for API keys in production
- Monitor API key usage for suspicious activity

### **Data Privacy**
- All data is encrypted in transit (TLS 1.2+)
- Personal data is anonymized where possible
- GDPR compliance for European users
- Data retention policies are enforced

## 📚 **SDK Libraries**

### **Official SDKs**
- **JavaScript/Node.js**: `npm install ip-tools-sdk`
- **Python**: `pip install ip-tools-sdk`
- **PHP**: `composer require ip-tools/sdk`
- **Ruby**: `gem install ip-tools-sdk`

### **Community SDKs**
- **Go**: `go get github.com/community/ip-tools-go`
- **Java**: Available on Maven Central
- **C#**: Available on NuGet

## 🧪 **Testing & Development**

### **Sandbox Environment**
- **Base URL**: `https://sandbox.your-domain.com/projects/ip-tools/public/api/v1`
- **Test Data**: Pre-populated with sample data
- **No Rate Limits**: Unlimited requests for testing
- **Reset Daily**: Data resets every 24 hours

### **Postman Collection**
Download our Postman collection for easy API testing:
[IP Tools Suite API Collection](https://your-domain.com/api/postman-collection.json)

### **API Documentation**
Interactive API documentation available at:
`https://your-domain.com/projects/ip-tools/public/api/docs`

## 📞 **Support & Contact**

### **API Support**
- **Email**: api-support@your-domain.com
- **Documentation**: [API Docs](https://your-domain.com/api/docs)
- **Status Page**: [API Status](https://status.your-domain.com)
- **Community**: [GitHub Discussions](https://github.com/your-username/ip-tools/discussions)

### **Developer Resources**
- **GitHub Repository**: [https://github.com/your-username/ip-tools](https://github.com/your-username/ip-tools)
- **Issue Tracker**: [GitHub Issues](https://github.com/your-username/ip-tools/issues)
- **Changelog**: [Release Notes](https://github.com/your-username/ip-tools/releases)
- **Contributing Guide**: [CONTRIBUTING.md](https://github.com/your-username/ip-tools/CONTRIBUTING.md)

---

**This API reference provides comprehensive access to all IP Tools Suite features. For additional help or questions, please contact our support team.**

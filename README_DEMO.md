# IP Tools Suite - Demo Mode

## Current Status

The IP Tools Suite is currently running in **Demo Mode** due to database connection issues. This allows you to test all the functionality without requiring a MySQL database setup.

## Quick Start

### 1. Start the Development Server

```bash
cd public
php -S localhost:8000
```

### 2. Access the Application

Open your browser and go to: `http://localhost:8000`

### 3. Login with Demo Credentials

- **Username:** `admin`
- **Password:** `admin123`

## Available Features in Demo Mode

### ✅ Working Features

1. **User Authentication**

   - Login/Register pages
   - Demo login (admin/admin123)
   - Session management

2. **Dashboard**

   - User statistics (demo data)
   - Recent activity (demo data)
   - User links (demo data)

3. **Link Management**

   - View tracking links (demo data)
   - Link analytics (demo data)

4. **Logs & Analytics**

   - View tracking logs (demo data)
   - Location data (demo data)
   - Device information (demo data)

5. **Navigation**
   - Responsive navigation
   - Theme switching
   - Language switching (Portuguese/English)

### 🔧 Technical Features

- **MVC Architecture**: Properly structured with Models, Views, Controllers
- **Responsive Design**: Works on desktop and mobile
- **macOS Aqua Theme**: Beautiful modern interface
- **Portuguese Default**: Application is in Portuguese by default
- **Error Handling**: Graceful handling of database connection issues

## Demo Data

The application provides realistic demo data including:

- **User Stats**: 5 total links, 127 total clicks, 89 total logs, 3 active links
- **Sample Links**:
  - `abc123` → https://example.com (45 clicks)
  - `def456` → https://google.com (82 clicks)
- **Sample Logs**:
  - GPS location data from São Paulo
  - IP-based location from Rio de Janeiro
  - Device information and user agents

## Database Setup (Optional)

If you want to set up the full database functionality:

### Option 1: Automatic Setup

```bash
php setup_database.php
```

_Requires MySQL root access_

### Option 2: Manual Setup

1. Create MySQL database: `techeletric_ip_tools`
2. Create user: `techeletric_ip_tools` with password: `zsP2rDZDaTea2YEhegmH`
3. Import the SQL files:
   - `users_table.sql`
   - `techeletric_ip_tools.sql`
   - `database_updates.sql`

### Option 3: Update Credentials

Edit `app/Config/Database.php` with your database credentials.

## File Structure

```
ip-tools/
├── app/                    # MVC Application
│   ├── Config/            # Configuration files
│   ├── Controllers/       # Controller classes
│   ├── Core/             # Core framework classes
│   ├── Models/           # Model classes
│   └── Views/            # View templates
├── public/               # Web root directory
│   ├── assets/          # CSS, JS, images
│   └── index.php        # Application entry point
├── geologger/           # Legacy geologger module
├── phone-tracker/       # Phone tracking module
├── utils/               # Utility tools
└── assets/              # Global assets
```

## Development Notes

### Database Connection Issues

The application gracefully handles database connection failures by:

- Logging errors instead of crashing
- Providing demo data when database is unavailable
- Showing appropriate error messages to users

### Demo Mode Detection

The application detects demo mode through:

- `$_SESSION['demo_mode']` flag
- Database connection status
- Fallback to demo data when needed

### Authentication Flow

1. User visits login page
2. Enters demo credentials (admin/admin123)
3. System sets demo mode flag
4. User is redirected to dashboard with demo data
5. All subsequent requests use demo data

## Next Steps

1. **Test the Application**: Use the demo mode to explore all features
2. **Set up Database**: If you have MySQL access, run the setup script
3. **Customize**: Modify themes, translations, or add new features
4. **Deploy**: Upload to your web server when ready

## Support

If you encounter any issues:

1. Check the browser console for JavaScript errors
2. Check the PHP error logs
3. Verify the development server is running
4. Ensure all files are in the correct locations

The application is designed to be robust and user-friendly, even when the database is not available.

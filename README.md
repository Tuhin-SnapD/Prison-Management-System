# Prison Management System

A comprehensive web-based prison management system built with PHP and MySQL.

## Features

- **Admin Management**: Add and manage officers, jailors, and visitors
- **Officer Dashboard**: Manage prisoners, crimes, and prison operations
- **Jailor Dashboard**: View and manage prisoners and sections
- **Visitor Management**: Handle visitor registrations and visits
- **Prisoner Management**: Track prisoner information, crimes, and status

## Setup Instructions

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Web browser

### Installation

1. **Clone/Download** the project to your XAMPP htdocs folder:
   ```
   C:\xampp\htdocs\PMS\Prison-Management-System\
   ```

2. **Database Setup**:
   - Start XAMPP and ensure Apache and MySQL are running
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the database schema from `config/database.sql`
   - The database will be created as `prisondb`

3. **Configuration**:
   - Database configuration is in `config/config.php`
   - Default settings:
     - Host: localhost
     - Database: prisondb
     - Username: root
     - Password: (empty)

4. **Access the Application**:
   - Navigate to: `http://localhost/PMS/Prison-Management-System/`
   - The application will automatically redirect to the public directory

## User Accounts

### Admin Login
- Username: `admin`
- Password: `password`

### Officer Login
- Username: `officer1`
- Password: `officer1`

### Jailor Login
- Username: `jailor1`
- Password: `jailor1`

## Routing System

The application uses a centralized routing system located in `public/index.php`. All pages are accessed through the `?page=` parameter:

- `?page=home` - Home/About page
- `?page=signin-admin` - Admin login
- `?page=signin-officer` - Officer login
- `?page=signin-jailor` - Jailor login
- `?page=admin` - Admin dashboard
- `?page=officer-dashboard` - Officer dashboard
- `?page=jailor-dashboard` - Jailor dashboard

## File Structure

```
Prison-Management-System/
├── config/                 # Configuration files
│   ├── config.php         # Main configuration
│   └── database.sql       # Database schema
├── public/                # Public entry point
│   ├── index.php         # Main routing file
│   ├── .htaccess         # URL rewriting rules
│   └── assets/           # Static assets
├── src/                   # Application source
│   ├── controllers/      # Controller files
│   ├── includes/         # Database and auth includes
│   └── views/            # View templates
└── README.md             # This file
```

## Database Views

The system includes several database views that provide organized and filtered data for different user roles and reporting needs.

### Dashboard_Stats View
**Purpose**: Provides key statistics for the admin dashboard
**Columns**:
- `Total_Prisoners` - Count of all active prisoners
- `Active_Jailors` - Count of active jailors
- `Active_Officers` - Count of active officers
- `Total_Sections` - Count of prison sections
- `Today_Visits` - Number of visits scheduled for today
- `Violent_Criminals` - Count of prisoners with violent crime categories
- `High_Risk_Prisoners` - Count of prisoners with high risk levels

**Usage**: Perfect for admin dashboard widgets and overview statistics

### Section_Overview View
**Purpose**: Provides comprehensive section information with occupancy data
**Columns**:
- `Section_id` - Section identifier
- `Section_name` - Name of the section (A, B, C, etc.)
- `Capacity` - Maximum capacity of the section
- `Current_population` - Current number of prisoners
- `Security_level` - Security classification (Minimum, Medium, Maximum, Super Maximum)
- `Jailor_Name` - Full name of the assigned jailor
- `Jailor_phone` - Contact number of the jailor
- `Occupancy_Percentage` - Calculated occupancy percentage

**Usage**: Ideal for jailor dashboards and section management screens

### Prisoner_Details View
**Purpose**: Comprehensive prisoner information with associated crimes and jailor details
**Columns**:
- `Prisoner_id` - Unique prisoner identifier
- `Full_Name` - Complete name of the prisoner
- `Date_in` - Date of admission
- `Date_out` - Expected release date
- `Status_inout` - Current status (in, out, transferred, etc.)
- `Crime_category` - Category of crimes committed
- `Risk_level` - Security risk assessment
- `Section_name` - Assigned section
- `Jailor_Name` - Responsible jailor
- `Crimes` - Comma-separated list of all crimes
- `Days_Remaining` - Days left until release

**Usage**: Perfect for prisoner management screens and detailed prisoner reports

### Visit_Schedule View
**Purpose**: Organized visit information with visitor and prisoner details
**Columns**:
- `Visit_id` - Unique visit identifier
- `Date_visit` - Scheduled visit date
- `Time_slot` - Time slot for the visit
- `Status` - Visit status (Scheduled, Completed, Cancelled, No-Show)
- `Visitor_Name` - Full name of the visitor
- `Visitor_Phone` - Visitor's contact number
- `Relationship_with_prisoner` - Relationship to the prisoner
- `Prisoner_Name` - Full name of the prisoner being visited
- `Section_name` - Section where the prisoner is located

**Usage**: Essential for visit management and scheduling screens

## Recent Fixes

### Routing Issues Fixed
- ✅ Centralized routing system implemented
- ✅ Fixed hardcoded relative paths in all controllers
- ✅ Updated form actions to use proper routing
- ✅ Fixed authentication redirects
- ✅ Updated navigation links to use routing system
- ✅ Fixed database connection paths
- ✅ Added proper logout functionality

### Security Improvements
- ✅ Centralized database connection
- ✅ Proper session management
- ✅ Input sanitization functions
- ✅ CSRF protection ready
- ✅ Secure file access restrictions

## Troubleshooting

### Common Issues

1. **Database Connection Error**:
   - Ensure MySQL is running in XAMPP
   - Check database credentials in `config/config.php`
   - Verify database `prisondb` exists

2. **Page Not Found**:
   - Ensure you're accessing through `public/index.php`
   - Check that Apache mod_rewrite is enabled
   - Verify `.htaccess` file is present

3. **Login Issues**:
   - Use the provided default credentials
   - Check session configuration
   - Clear browser cookies if needed

## Development

### Adding New Pages
1. Add route in `public/index.php`
2. Create controller file in `src/controllers/`
3. Update navigation links to use `?page=your-page`

### Database Changes
1. Update `config/database.sql`
2. Modify relevant includes in `src/includes/database/`
3. Update controllers as needed

## License

This project is for educational purposes.

## Contributors

- Ayuj
- Tuhin
- Anish
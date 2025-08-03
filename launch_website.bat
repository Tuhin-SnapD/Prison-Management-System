@echo off
title Prison Management System - Advanced Launcher
color 0B

echo ========================================
echo   Prison Management System Launcher
echo   Advanced Version
echo ========================================
echo.

:: Check if XAMPP is installed
if not exist "C:\xampp\xampp-control.exe" (
    echo ERROR: XAMPP not found at C:\xampp\
    echo Please install XAMPP first from: https://www.apachefriends.org/
    echo.
    pause
    exit /b 1
)

:: Check if we're in the right directory
if not exist "config\config.php" (
    echo ERROR: Configuration file not found!
    echo Please run this batch file from the Prison-Management-System directory.
    echo.
    pause
    exit /b 1
)

echo Starting XAMPP services...
echo.

:: Kill any existing Apache/MySQL processes
taskkill /f /im httpd.exe >nul 2>&1
taskkill /f /im mysqld.exe >nul 2>&1
timeout /t 2 /nobreak >nul

:: Start Apache
echo [1/4] Starting Apache...
start /B "Apache" "C:\xampp\apache_start.bat"
timeout /t 5 /nobreak >nul

:: Start MySQL
echo [2/4] Starting MySQL...
start /B "MySQL" "C:\xampp\mysql_start.bat"
timeout /t 5 /nobreak >nul

:: Wait for services to fully start
echo [3/4] Waiting for services to initialize...
timeout /t 8 /nobreak >nul

:: Verify services are running
echo [4/4] Verifying services...
echo.

:: Check Apache
netstat -an | findstr ":80" >nul
if %errorlevel% equ 0 (
    echo [OK] Apache is running on port 80
) else (
    echo [ERROR] Apache is not running on port 80
    echo   Please check XAMPP Control Panel manually
)

:: Check MySQL
netstat -an | findstr ":3306" >nul
if %errorlevel% equ 0 (
    echo [OK] MySQL is running on port 3306
) else (
    echo [ERROR] MySQL is not running on port 3306
    echo   Please check XAMPP Control Panel manually
)

echo.
echo ========================================
echo   Database Setup Check
echo ========================================
echo.

:: Check if database exists
echo Checking if database 'prisondb' exists...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "USE prisondb;" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Database 'prisondb' exists
    echo.
) else (
    echo [WARNING] Database 'prisondb' not found
    echo.
    echo Would you like to set up the database now? (Y/N)
    set /p setup_db=
    if /i "%setup_db%"=="Y" (
        echo.
        echo ========================================
        echo   Setting Up Database
        echo ========================================
        echo.
        
        :: Check if database.sql exists
        if not exist "database.sql" (
            echo [ERROR] database.sql file not found in current directory
            echo Please make sure database.sql is in the same folder as this batch file
            echo.
            pause
            exit /b 1
        )
        
        echo [OK] Found database.sql file
        echo.
        
        :: Prompt for MySQL password
        set /p mysql_password="Enter MySQL root password (press Enter if no password): "
        
        :: Create database if it doesn't exist
        echo Creating database 'prisondb' if it doesn't exist...
        if "%mysql_password%"=="" (
            "C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS prisondb;" 2>nul
        ) else (
            "C:\xampp\mysql\bin\mysql.exe" -u root -p%mysql_password% -e "CREATE DATABASE IF NOT EXISTS prisondb;" 2>nul
        )
        if %errorlevel% neq 0 (
            echo [WARNING] Could not create database (might already exist)
            echo.
        )
        
        :: Import the database.sql file
        echo Importing database schema and data...
        if "%mysql_password%"=="" (
            "C:\xampp\mysql\bin\mysql.exe" -u root prisondb < database.sql
        ) else (
            "C:\xampp\mysql\bin\mysql.exe" -u root -p%mysql_password% prisondb < database.sql
        )
        
        if %errorlevel% equ 0 (
            echo.
            echo ========================================
            echo [SUCCESS] Database setup completed!
            echo ========================================
            echo.
            echo Database 'prisondb' has been created and populated
            echo You can now access the Prison Management System
            echo.
        ) else (
            echo.
            echo ========================================
            echo [ERROR] Database setup failed!
            echo ========================================
            echo.
            echo Possible issues:
            echo - MySQL service not running
            echo - Wrong MySQL credentials
            echo - database.sql file is corrupted
            echo - Insufficient permissions
            echo.
            echo Please check:
            echo 1. XAMPP MySQL service is running
            echo 2. You can access phpMyAdmin at http://localhost/phpmyadmin
            echo 3. database.sql file is valid
            echo.
            pause
            exit /b 1
        )
    ) else (
        echo Database setup skipped. You can run this launcher again to set up the database.
    )
)

echo.
echo ========================================
echo   Launching Website
echo ========================================
echo.
echo Opening Prison Management System...
echo Website URL: http://localhost/Prison-Management-System/public/
echo.

:: Open the website in default browser
start http://localhost/Prison-Management-System/public/

echo.
echo ========================================
echo   Quick Access Links
echo ========================================
echo.
echo Direct Links:
echo - Admin Login: http://localhost/Prison-Management-System/public/?page=signin-admin
echo - Officer Login: http://localhost/Prison-Management-System/public/?page=signin-officer
echo - Jailor Login: http://localhost/Prison-Management-System/public/?page=signin-jailor
echo - phpMyAdmin: http://localhost/phpmyadmin
echo.

echo ========================================
echo   Login Credentials
echo ========================================
echo.
echo Admin Login:
echo   Username: admin
echo   Password: password
echo.
echo Officer Login:
echo   Username: officer1
echo   Password: officer1
echo.
echo Jailor Login:
echo   Username: jailor1
echo   Password: jailor1
echo.

echo ========================================
echo   Troubleshooting
echo ========================================
echo.
echo If you encounter issues:
echo 1. Check XAMPP Control Panel
echo 2. Ensure Apache and MySQL are running (green)
echo 3. Check if database 'prisondb' exists
echo 4. Clear browser cache and cookies
echo 5. Try accessing: http://localhost/Prison-Management-System/public/
echo.

echo ========================================
echo.
echo Press any key to close this window...
pause >nul 
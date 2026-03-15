# Database Setup for PASF College WordPress

If you see "Error establishing a database connection", follow these steps:

## 1. Start MySQL in XAMPP

1. Open **XAMPP Control Panel**
2. Click **Start** next to **MySQL** (Apache should also be running)
3. Wait until MySQL shows green "Running"

## 2. Create the Database

1. Open **phpMyAdmin**: http://localhost/phpmyadmin
2. Click **New** (or "Databases" tab) to create a new database
3. Database name: **pasfanc**
4. Collation: **utf8mb4_general_ci**
5. Click **Create**

## 3. Verify wp-config.php

The file should have:
- **DB_NAME:** `pasfanc`
- **DB_USER:** `root`
- **DB_PASSWORD:** *(empty)*
- **DB_HOST:** `127.0.0.1`

If you use a different database name or MySQL user/password, update `wp-config.php` accordingly.

## 4. Retry

Visit: http://localhost/pasfanc.ac.in/

You should see the WordPress installation screen.

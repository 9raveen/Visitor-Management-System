# Visitor Management System

A web-based visitor management system built with PHP and MySQL, designed for institutional use (IIITN). It handles visitor registration, check-in/check-out tracking, QR code generation, and role-based access for admins, receptionists, and security personnel.

---

## Features

- Visitor self-registration with auto-generated unique IDs (e.g., `IIITN2111`)
- QR code generation per visitor entry
- Email notifications to visitors and hosts on check-in and check-out
- Real-time dashboard with live visitor stats (auto-refreshes every 10s)
- Role-based access control: Admin, Receptionist, Security
- Security personnel can mark visitor exits directly from their dashboard
- Full visitor log with arrival/departure timestamps

---

## Tech Stack

- Backend: PHP (procedural + OOP)
- Database: MySQL via MySQLi
- Frontend: HTML5, CSS3, Tailwind CSS, Bootstrap 5, Font Awesome
- QR Codes: [QR Server API](https://goqr.me/api/) + local `phpqrcode` library
- Email: PHP `mail()` function

### Frontend Details

**HTML5**
- Semantic elements (`<nav>`, `<footer>`, `<table>`, `<form>`) used throughout all pages
- Form validation attributes (`required`, `type="email"`, `type="tel"`) for client-side input control
- Modal dialogs for QR code previews built with native Bootstrap HTML5 structure

**CSS3**
- Custom keyframe animations (`@keyframes fadeIn`, `slideUp`, `float`) on dashboard cards and headings
- CSS transitions on buttons and table rows for smooth hover effects
- Flexbox and CSS Grid layouts for responsive card arrangements
- Box shadows, border-radius, and gradients for modern card-style UI
- Media queries for mobile-responsive tables and font scaling
- CSS variables and utility overrides layered on top of Bootstrap

**Tailwind CSS**
- Used in `admin_dashboard.php` via CDN with a custom `tailwind.config` for extended animations
- Utility-first classes handle spacing, typography, color gradients (`from-indigo-600 to-purple-600`), and responsive grid (`grid-cols-1 md:grid-cols-2`)
- Custom animation utilities (`animate-fade-in`, `animate-slide-up`, `pulse-slow`) defined inline via Tailwind's `keyframes` config extension

---

## Roles

| Role | Access |
|---|---|
| Admin | User management, analytics, full visitor report |
| Receptionist | Register visitors, view visitor list |
| Security | View visitors currently inside, mark exits |

---

## Project Structure

```
├── index.html              # Visitor registration portal (public)
├── login.html / login.php  # Staff login
├── entry.php               # Handles visitor check-in form submission
├── exit.php                # Handles visitor self check-out
├── display.php             # Full visitor records table with QR codes
├── dash.html               # Real-time visitor dashboard
├── get_dashboard_data.php  # JSON API for dashboard stats
├── admin_dashboard.php     # Admin control panel
├── receptionist_dashboard.php
├── security_dashboard.php
├── security_exit.php       # Security-triggered exit handler
├── register_user.php       # Admin: create staff accounts
├── connect.php             # DB connection
├── function.php            # Email helper functions
├── logout.php
├── phpqrcode/              # Local QR code generation library
├── qrcodes/                # Generated QR code images
├── images/                 # Static assets
└── css/                    # Custom stylesheets
```

---
<img width="1918" height="1048" alt="Screenshot 2026-03-18 185528" src="https://github.com/user-attachments/assets/c066b29d-e5aa-4ff9-af1e-1bf21583f745" />

<img width="1908" height="1024" alt="Screenshot 2026-03-18 185551" src="https://github.com/user-attachments/assets/7b3efffd-0f94-41ce-b6f5-856247eb4c55" />
<img width="1917" height="1046" a<img width="1880" height="923" alt="Screenshot 2026-03-18 185649" src="https://github.com/user-attachments/assets/8c03c492-db45-4a58-b96e-87abdc9f5e1a" /><img width="1893" height="1043" alt="Screenshot 2026-03-18 185732" src="https://github.com/user-attachments/assets/b383269f-be83-4892-8e56-64d3b8311aec" />
<img width="1903" height="1008" alt="Screenshot 2026-03-18 185918" src="https://github.com/user-attachments/assets/0981a2da-4a32-4787-9a93-aecf398b382f" />

lt="Screenshot 2026-03-18 185629" src="h<img width="307" height="776" alt="Screenshot 2026-03-18 185843" src="https://github.com/user-attachments/assets/5d2d08f9-91b2-4ada-955c-8cf7635f86de" />
## Setup
### Requirements

- PHP 7.4+
- MySQL 5.7+
- A local server like XAMPP or WAMP

### Steps

1. Clone or copy the project into your server's web root (e.g., `htdocs/DBMS/`).

2. Create the database:

```sql
CREATE DATABASE visitor_management;
```

3. Create the required tables:

```sql
CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    UserId VARCHAR(20),
    Username VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(15),
    HostName VARCHAR(100),
    HostEmail VARCHAR(100),
    HostPhone VARCHAR(15),
    PurposeOfVisit TEXT,
    Arrival DATETIME,
    Departure VARCHAR(50) DEFAULT 'Inside'
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'receptionist', 'security')
);
```

4. Update `connect.php` with your DB credentials if needed (defaults to `root` with no password on `localhost`).

5. Create the first admin account by running `register_user.php` via POST, or insert directly:

```sql
INSERT INTO users (name, username, email, password, role)
VALUES ('Admin', 'admin', 'admin@example.com', '<bcrypt_hash>', 'admin');
```

6. Access the app at `http://localhost/DBMS/`.

---

## Screenshots

| Page | Description |
|---|---|
| `index.html` | Visitor registration portal |
| `login.html` | Staff login |
| `dash.html` | Real-time visitor dashboard |
| `receptionist_dashboard.php` | Visitor list + registration |
| `security_dashboard.php` | Active visitors + exit marking |
| `admin_dashboard.php` | Admin control panel |
| `display.php` | Full visitor log with QR codes |

---

## Notes

- Email notifications require a configured mail server. On localhost, use a tool like [Mailtrap](https://mailtrap.io) or configure `sendmail`.
- The `Departure` field stores `'Inside'` while the visitor is on premises, and a timestamp once they exit.
- Visitor IDs are sequential starting from `IIITN2101`.

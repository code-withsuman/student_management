# ◈ StudentMS — Student Management System

A complete, beginner-friendly **Student Management System** built with PHP, MySQL, Bootstrap 5, and XAMPP. Features a dark-themed admin panel with full CRUD operations, session-based authentication, and responsive design.

---

## 📸 Features at a Glance

- 🔐 Admin Signup & Login with session management
- 📊 Dashboard with student stats and quick actions
- ➕ Add, ✏️ Edit, 🗑️ Delete student records
- 🔍 Search students by name, roll number, section, or email
- 📱 Fully responsive — works on mobile and desktop
- ✅ Frontend & backend validation on all forms
- 🎨 Modern dark UI (Syne + DM Sans fonts, amber accent)

---

## 🛠️ Tech Stack

| Layer      | Technology          |
|------------|---------------------|
| Backend    | PHP 8+              |
| Database   | MySQL               |
| Frontend   | HTML5, CSS3         |
| Framework  | Bootstrap 5.3       |
| Icons      | Bootstrap Icons     |
| Server     | XAMPP (Apache)      |
| Fonts      | Google Fonts        |

---

## 📁 Project Structure

```
student_management/
│
├── index.php               # Auto-redirect (login or dashboard)
├── signup.php              # Admin registration
├── login.php               # Admin login
├── logout.php              # Session destroy & redirect
├── dashboard.php           # Stats, recent students, quick actions
│
├── add_student.php         # Add new student form
├── view_students.php       # All students table with actions
├── edit_student.php        # Edit existing student record
├── delete_student.php      # Delete confirmation page
├── search_student.php      # Search by name / roll / section / email
│
├── includes/
│   ├── db.php              # MySQL database connection
│   ├── auth.php            # Session helpers (requireLogin, redirectIfLoggedIn)
│   ├── header.php          # Sidebar, topbar, HTML head
│   └── footer.php          # Closing tags, Bootstrap & JS scripts
│
├── css/
│   └── style.css           # Full custom stylesheet (dark theme)
│
├── js/
│   └── script.js           # Sidebar toggle, delete confirm, password meter
│
└── database/
    └── school_db.sql       # Database & table schema
```

---

## ⚙️ Installation & Setup

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) installed (PHP 8+ recommended)
- Web browser

### Step 1 — Place the project

Copy the `student_management/` folder into your XAMPP `htdocs` directory:

```
C:\xampp\htdocs\student_management\       (Windows)
/Applications/XAMPP/htdocs/student_management/   (macOS)
/opt/lampp/htdocs/student_management/     (Linux)
```

### Step 2 — Start XAMPP

Open XAMPP Control Panel and start:
- ✅ Apache
- ✅ MySQL

### Step 3 — Create the Database

1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click **New** and create a database named `school_db`
3. Select the `school_db` database
4. Click the **Import** tab
5. Choose `database/school_db.sql` and click **Go**

### Step 4 — Configure Database (if needed)

Open `includes/db.php` and update credentials if yours differ:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // your MySQL username
define('DB_PASS', '');           // your MySQL password
define('DB_NAME', 'school_db');
```

### Step 5 — Open the App

Navigate to:
```
http://localhost/student_management/
```

You'll be redirected to the login page. Click **Create Account** to register your admin.

---

## 🗄️ Database Schema

### `admins` table

| Column       | Type         | Description              |
|--------------|--------------|--------------------------|
| id           | INT (PK, AI) | Auto-increment ID        |
| username     | VARCHAR(100) | Admin display name       |
| email        | VARCHAR(150) | Unique login email       |
| password     | VARCHAR(255) | Bcrypt hashed password   |
| created_at   | TIMESTAMP    | Registration time        |

### `students` table

| Column       | Type         | Description              |
|--------------|--------------|--------------------------|
| id           | INT (PK, AI) | Auto-increment ID        |
| name         | VARCHAR(100) | Full student name        |
| roll_number  | VARCHAR(50)  | Unique roll number       |
| section      | VARCHAR(20)  | Class section (A–F)      |
| age          | INT          | Student age              |
| phone        | VARCHAR(20)  | Contact number           |
| email        | VARCHAR(150) | Student email            |
| created_at   | TIMESTAMP    | Record creation time     |
| updated_at   | TIMESTAMP    | Last updated time        |

---

## 📄 Pages Overview

### 🔐 Authentication
| Page | Description |
|------|-------------|
| `signup.php` | Register a new admin with username, email, and password. Includes password strength indicator and confirm-password matching. |
| `login.php` | Email + password login with session creation. Shows error on invalid credentials. |
| `logout.php` | Destroys the session and redirects to login. |

### 📊 Dashboard (`dashboard.php`)
- Total student count
- Active sections count
- Average students per section
- Quick action buttons (Add, View, Search, Logout)
- Table of the 5 most recently added students

### 👨‍🎓 Student Management
| Page | Description |
|------|-------------|
| `add_student.php` | Form to register a new student. Checks for duplicate roll numbers. |
| `view_students.php` | Paginated table of all students with Edit and Delete buttons. |
| `edit_student.php` | Pre-filled form to update student details. |
| `delete_student.php` | Confirmation page before permanently deleting a record. |
| `search_student.php` | Search bar using SQL `LIKE` on name, roll, section, and email. |

---

## 🔒 Security Notes

- Passwords are hashed with PHP's `password_hash()` (bcrypt)
- All user inputs are sanitized with `mysqli_real_escape_string()`
- All output is escaped with `htmlspecialchars()` to prevent XSS
- Pages are protected with session checks via `requireLogin()`
- Unauthenticated users are automatically redirected to `login.php`

> **Note:** For a production environment, consider using PDO with prepared statements for stronger SQL injection protection.

---

## 🎨 UI & Design

- **Theme:** Dark slate background with amber (`#f5a623`) accent
- **Fonts:** [Syne](https://fonts.google.com/specimen/Syne) for headings, [DM Sans](https://fonts.google.com/specimen/DM+Sans) for body
- **Layout:** Fixed sidebar (desktop) + collapsible topbar (mobile)
- **Responsive:** Sidebar collapses on screens under 768px with overlay toggle
- **Alerts:** Auto-dismiss after 4 seconds

---

## 🧩 Customization

**Add more sections:**
Edit the `<select>` in `add_student.php` and `edit_student.php`:
```php
foreach (['A','B','C','D','E','F','G','H'] as $s) { ... }
```

**Change accent color:**
In `css/style.css`, update the CSS variable:
```css
:root {
    --accent: #f5a623;   /* change to any color */
}
```

**Add more student fields:**
1. Add the column to `school_db.sql` and run `ALTER TABLE`
2. Add the `<input>` field in `add_student.php` and `edit_student.php`
3. Update the `INSERT` and `UPDATE` SQL queries accordingly
4. Add the column to the table in `view_students.php`

---

## 🐛 Troubleshooting

| Problem | Solution |
|---------|----------|
| "Database connection failed" | Make sure MySQL is running in XAMPP and `school_db` exists |
| Blank page after login | Check that `session_start()` is not called twice; `auth.php` handles it |
| Images/CSS not loading | Ensure you're accessing via `http://localhost/...`, not by opening the file directly |
| "Roll number already exists" | Each student must have a unique roll number |
| Page redirects to login | Your session expired — log in again |

---

## 📝 License

This project is open-source and free to use for educational purposes.

---

> Built with PHP + MySQL + Bootstrap 5 · Designed for XAMPP · Beginner Friendly

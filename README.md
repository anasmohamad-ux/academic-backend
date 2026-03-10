<p align="center">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 520 160" width="520" height="160">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#1E40AF"/>
      <stop offset="100%" style="stop-color:#0EA5E9"/>
    </linearGradient>
    <linearGradient id="gold" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" style="stop-color:#FCD34D"/>
      <stop offset="100%" style="stop-color:#F59E0B"/>
    </linearGradient>
  </defs>
  <rect width="520" height="160" rx="20" fill="url(#bg)"/>
  <!-- Mortarboard top -->
  <polygon points="100,44 150,66 100,74 50,66" fill="url(#gold)"/>
  <!-- Mortarboard brim -->
  <polygon points="62,66 138,66 128,84 72,84" fill="url(#gold)"/>
  <!-- Tassel -->
  <line x1="150" y1="66" x2="153" y2="90" stroke="#F59E0B" stroke-width="2.5" stroke-linecap="round"/>
  <circle cx="153" cy="93" r="4" fill="#F59E0B"/>
  <line x1="151" y1="95" x2="148" y2="108" stroke="#FCD34D" stroke-width="1.5" stroke-linecap="round"/>
  <line x1="153" y1="96" x2="153" y2="110" stroke="#FCD34D" stroke-width="1.5" stroke-linecap="round"/>
  <line x1="155" y1="95" x2="158" y2="108" stroke="#FCD34D" stroke-width="1.5" stroke-linecap="round"/>
  <!-- Books -->
  <rect x="64" y="84" width="66" height="10" rx="2" fill="#3B82F6"/>
  <rect x="67" y="95" width="60" height="10" rx="2" fill="#60A5FA"/>
  <rect x="70" y="106" width="54" height="10" rx="2" fill="#93C5FD"/>
  <!-- Spine lines -->
  <line x1="72" y1="84" x2="72" y2="94" stroke="white" stroke-width="1" opacity="0.35"/>
  <line x1="75" y1="95" x2="75" y2="105" stroke="white" stroke-width="1" opacity="0.35"/>
  <line x1="78" y1="106" x2="78" y2="116" stroke="white" stroke-width="1" opacity="0.35"/>
  <!-- Text -->
  <text x="185" y="88" font-family="Arial,sans-serif" font-size="50" font-weight="900" fill="white" letter-spacing="2">EZY</text>
  <text x="185" y="124" font-family="Arial,sans-serif" font-size="26" font-weight="700" fill="#FCD34D" letter-spacing="9">ACADEMY</text>
  <rect x="185" y="131" width="300" height="3" rx="2" fill="#FCD34D" opacity="0.55"/>
  <!-- Dots -->
  <circle cx="490" cy="28" r="3" fill="#FCD34D" opacity="0.7"/>
  <circle cx="476" cy="16" r="2" fill="#FCD34D" opacity="0.5"/>
  <circle cx="503" cy="20" r="2" fill="white" opacity="0.4"/>
</svg>
</p>

<p align="center">
  <strong>An online learning platform where students build custom course packages, teachers publish courses, and admins control pricing — all through a clean REST API.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel" />
  <img src="https://img.shields.io/badge/Auth-Sanctum-orange?style=flat-square" />
  <img src="https://img.shields.io/badge/Roles-Spatie-purple?style=flat-square" />
  <img src="https://img.shields.io/badge/Architecture-SOLID-green?style=flat-square" />
  <img src="https://img.shields.io/badge/Tests-9%20Passing-brightgreen?style=flat-square" />
</p>

---

## What is EZY Academy?

EZY Academy lets students pick any 3+ courses and automatically bundles them into a **package**. They then choose a **program** (College, Employee, or Complete Transformation), and the system calculates the final price dynamically:

```
Package Price = SUM(selected course prices) + Program Tax
```

No manual package creation. No hardcoded prices. Everything is dynamic.

---

## Three Roles, Three Experiences

### Student
- Browse and search all available courses
- Select 3+ courses to build a custom learning package
- See pricing across all 3 programs before enrolling
- Enroll in a package under a chosen program
- View all enrolled courses grouped by package
- Cancel any enrollment

### Teacher
- Create courses with title, description, and icon
- View all courses they have created

### Admin
- Set and update course prices
- Edit program tax amounts — controls all pricing instantly
- Rename packages
- Manage all users — edit roles, delete accounts, add teachers

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend API | Laravel 11 |
| Authentication | Laravel Sanctum |
| Authorization | Spatie Laravel Permission |
| Database | MySQL |

---

## Backend Setup

### 1. Install dependencies
```bash
cd backend
composer install
```

### 2. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install Sanctum and run migrations
```bash
php artisan install:api
php artisan migrate
php artisan db:seed
```

### 4. Start the server
```bash
php artisan serve
# http://127.0.0.1:8000
```

---

## Default Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ezy.com | password |
| Teacher | teacher@ezy.com | password |
| Student | student@ezy.com | password |

---

## API Reference

### Public — no token needed
```
GET  /api/popular-courses        Top 3 most enrolled courses
POST /api/register               Create account, returns token
POST /api/login                  Login, returns token
```

### Authenticated
```
GET  /api/me                     Current user info
POST /api/logout                 Invalidate token
```

### Student
```
GET    /api/student/courses                  Browse and search courses
GET    /api/student/basket                   Preview pricing for selected courses
POST   /api/student/enroll                   Enroll in package + program
GET    /api/student/my-courses               View enrolled packages and courses
DELETE /api/student/enrollment/{package}     Cancel enrollment
```

### Teacher
```
GET    /api/teacher/courses       View own courses
POST   /api/teacher/courses       Create a new course
```

### Admin
```
GET    /api/admin/users                   List all users
PUT    /api/admin/users/{user}            Update user or role
DELETE /api/admin/users/{user}            Delete user

GET    /api/admin/courses                 List all courses
PUT    /api/admin/courses/{course}        Update course price
DELETE /api/admin/courses/{course}        Delete course

GET    /api/admin/programs                List programs
PUT    /api/admin/programs/{program}      Update tax amount

GET    /api/admin/packages                List packages
PUT    /api/admin/packages/{package}      Rename package
```

---

## Pricing System

Pricing is fully dynamic — no stored package prices. Every calculation happens at request time.

```
Package Price = SUM(course.price) + program.tax_amount
```

| Program | Tax | Target |
|---------|-----|--------|
| College Program | $50 | Students |
| Employee Program | $75 | Working professionals |
| Complete Transformation | $100 | Full commitment learners |

Admin can update any tax amount at any time and all future enrollments reflect it instantly.

---

## Database Design

```
users           id, name, email, password, avatar
programs        id, name, tax_amount
courses         id, user_id (teacher), title, description, icon, price
packages        id, title, hash
course_package  course_id, package_id  (pivot)
enrollments     id, user_id, package_id, program_id, paid_price
```

---

## SOLID Architecture

| Principle | How it is applied |
|-----------|------------------|
| S — Single Responsibility | Each service does one job. Controllers only delegate. Models only define data. |
| O — Open/Closed | PricingStrategyInterface lets you add new pricing logic without touching existing code. |
| L — Liskov Substitution | Any PricingStrategyInterface implementation can replace PricingService transparently. |
| I — Interface Segregation | One FormRequest per action. One Policy per model. No fat interfaces. |
| D — Dependency Inversion | Controllers depend on the interface. Laravel IoC injects the concrete class. |

---

## Authentication Flow

```
POST /api/register  or  POST /api/login
          ↓
  { user: {...}, token: "1|abc123..." }
          ↓
  All requests → Authorization: Bearer 1|abc123...
```

---

## Tests

```bash
cd backend
php artisan test
```

```
✓ user can register
✓ user can login
✓ user can logout
✓ student can enroll
✓ student cannot enroll with less than 3 courses
✓ student can cancel enrollment
✓ price equals course sum plus tax
✓ the application returns a successful response
✓ that true is true

Tests: 9 passed
```

---

## Dependencies

| Package | Purpose |
|---------|---------|
| spatie/laravel-permission | Roles and permissions |
| spatie/laravel-query-builder | Filterable API queries |
| laravel/sanctum | Token authentication |

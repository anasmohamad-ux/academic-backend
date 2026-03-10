<p align="center">
  <img src="logo.svg" alt="EZY Academy Logo" width="500"/>
</p>

<p align="center">
  <strong>An online learning platform where students build custom course packages, teachers publish content, and admins control pricing — all through a clean REST API.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat-square&logo=laravel" />
  <img src="https://img.shields.io/badge/React-Vite-61DAFB?style=flat-square&logo=react" />
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
- See how many students enrolled in their courses

### Admin
- Set and update course prices
- Edit program tax amounts (controls all pricing instantly)
- Rename packages
- Manage all users — edit roles, delete accounts, add teachers

---

## Tech Stack

| Layer | Technology | Why |
|-------|-----------|-----|
| Backend API | Laravel 11 | Robust PHP framework |
| Authentication | Laravel Sanctum | Stateless token-based auth |
| Authorization | Spatie Permission | Role and permission management |
| Frontend (test) | React + Vite | Fast UI for testing the API |
| HTTP Client | Axios | API calls with auto token injection |
| Routing | React Router DOM | Client-side navigation |
| Database | MySQL | Relational data storage |

---

## Project Structure

```
lastcall/
├── backend/                        Laravel 11 REST API
│   ├── app/
│   │   ├── Contracts/              Interfaces (PricingStrategyInterface)
│   │   ├── Services/               Business logic
│   │   │   ├── PackageService      Auto-creates packages from selected courses
│   │   │   ├── PricingService      Calculates package price dynamically
│   │   │   └── EnrollmentService   Handles enroll and cancel flow
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Api/            Auth (register, login, logout)
│   │   │   │   ├── Admin/          Users, Courses, Programs, Packages
│   │   │   │   ├── Teacher/        Courses
│   │   │   │   └── Student/        Courses, Basket, Enrollment, MyCourses
│   │   │   ├── Requests/           One validation class per action
│   │   │   └── Resources/          JSON response formatting
│   │   ├── Models/                 User, Course, Package, Program, Enrollment
│   │   └── Policies/               Authorization per model
│   ├── database/
│   │   ├── migrations/             5 custom tables
│   │   ├── seeders/                Roles, programs, default users
│   │   └── factories/              Test data factories
│   ├── routes/api.php              All API routes
│   └── tests/                      9 passing tests
│
└── frontend/                       React + Vite test UI
    └── src/
        ├── api/axios.js            Axios instance with token interceptor
        └── pages/
            ├── Home.jsx            Popular courses and navbar
            ├── Login.jsx           Login form
            └── Register.jsx        Registration form
```

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

## Frontend Setup

```bash
cd frontend
npm install
npm run dev
# http://localhost:5173
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
packages        id, title, hash (fingerprint of course IDs)
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
  Store token in localStorage
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

### Backend
| Package | Purpose |
|---------|---------|
| spatie/laravel-permission | Roles and permissions |
| spatie/laravel-query-builder | Filterable API queries |
| laravel/sanctum | Token authentication |

### Frontend
| Package | Purpose |
|---------|---------|
| axios | HTTP requests to the API |
| react-router-dom | Client-side routing |

---

## Running Everything

```bash
# Terminal 1
cd backend && php artisan serve

# Terminal 2
cd frontend && npm run dev
```

Open `http://localhost:5173`

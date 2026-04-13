# TUK Ability Club Porta

> Disability Club Management System

Group Name: **The Three Muskateers**
- Margaret Wambui Nduta

- Mararo Emmanuel Igathe

---

## 1. Project Overview

### 1.1 Project Description

The TUK Ability Club Portal is a web-based platform built for the Technical University of Kenya Disability Club. It allows members to register, authenticate, track financial data, browse events, and read club blog posts. The goal is to improve communication, transparency, and engagement for all club participants.

### 1.2 Project Objectives

- Secure registration and login for club members.
- Role-based access control with Member, Executive, and Admin roles.
- Event management with calendar view, RSVP and reminders.
- Financial tracking for income, expenses and balances.
- Blog system for announcements, stories, and updates.
- Accessible, responsive and user-friendly UI.

---

## 2. Technology Stack

### Backend
- PHP 8+ and Laravel 11
- MySQL
- Composer

### Frontend
- HTML5
- CSS3 with Tailwind CSS
- JavaScript
- Alpine.js

### Tools
- XAMPP (local dev environment)
- npm (asset tooling)
- Git (version control)
- Visual Studio Code

---

## 3. Functional Requirements

### User Authentication
- Member registration with name, student ID, email, password.
- Login via email or student ID + password.
- Password reset via email links.
- Admin approval for new users before full access.
- Role-based permissions: Member, Executive, Admin.

### Event Management
- Executives can create/edit/delete events (title, date, time, location, description).
- Members view upcoming events and RSVP.
- Event reminders for RSVP participants.
- Archive past events for history.

### Financial Management
- Executives log income/expense transactions (amount, description, category, date).
- Members view summaries, history, and balances.
- Charts showing financial health over time.

### Blog Management
- Executives manage posts (create/edit/delete).
- Posts have author, date, category, title, content, optional media.
- Members read and comment on posts.
- Recent and featured posts on the homepage.

### Member Management
- Admins approve users and set roles.
- Directory of approved members for networking.

---

## 4. Non-functional Requirements

- WCAG 2.1 Level AA accessibility.
- Load time < 3 seconds.
- Security: bcrypt passwords, CSRF, XSS, SQL injection protections.
- Mobile-first responsive design.
- Cross-browser support (Chrome/Firefox/Safari/Edge).
- Data privacy and backups.

---

## 5. User Roles and Permissions

- **Guest**: view homepage, events, blogs, register account.
- **Member**: view events, RSVP, financial reports, blog reading/commenting, directory.
- **Executive**: member + manage events, blogs, transactions.
- **Admin**: executive + approve users, assign roles, manage settings.

---

## 6. Database Structure

Main tables:
- `users`: name, student_id, email, password_hash, role, is_approved, contact.
- `events`: title, description, date, time, location, capacity.
- `event_registrations`: user_id, event_id, status, registered_at.
- `transactions`: type, description, amount, date, category, receipt, created_by.
- `blog_posts`: title, body, author_id, category, published_at.
- `comments`: post_id, user_id, message, created_at.

---

## 7. Project Timeline

1. Requirements definition - 3 days
2. Database design & migrations - 2 days
3. Authentication module - 5 days
4. Event system - 5 days
5. Financial module - 5 days
6. Blog module - 4 days
7. Frontend integration - 6 days
8. Testing & debugging - 4 days
9. Deployment & documentation - 3 days

Total: 37 days

---

## 8. Deliverables

- Fully functional Laravel application.
- MySQL database schema and seeds.
- Responsive UI with Tailwind.
- Role-based authentication and admin approval.
- Event calendar with RSVP.
- Finance dashboard with charts.
- Blog with comments.
- User & technical documentation.
- Git repository with history.

---

## 9. How to Run Locally

1. Clone this repository.
2. Copy `.env.example` to `.env`.
3. Set MySQL credentials and DB name in `.env`.
4. Run `composer install`.
5. Run `npm install && npm run dev`.
6. Run `php artisan key:generate`.
7. Migrate `php artisan migrate --seed`.
8. Start server `php artisan serve`.

---

## 10. License

MIT

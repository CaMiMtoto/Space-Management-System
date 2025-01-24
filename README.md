# Space Management System

## Description

This is a simple space management system that allows users to book a space for a specific time period. The system is
built using Laravel and Vue.js.

## Installation

1. Clone the repository and navigate to the project directory.

  ```bash
    git clone https://github.com/CaMiMtoto/Space-Management-System.git
```

2. Install the composer dependencies.

  ```bash
    composer install
```

3. Install the npm dependencies.

  ```bash
    npm install
```

4. Create a new database and update the `.env` file with the database credentials.
5. Run the migrations.

  ```bash
    php artisan migrate
```

6. Seed the database.

  ```bash
    php artisan db:seed
```

7. Start the development server.

  ```bash
    php artisan serve
```

8. Visit `http://localhost:8000` in your browser.
9. You can login as an admin using the following credentials:

  ```bash
    email:admin@sms.rw
    password:password
```

## Features

- Users can book a space for a specific time period.
- Admins can manage spaces, bookings, and users.
- Admins can view all bookings and filter them by date.
- Admins can view all users and filter them by name or email.
- Admins can view all spaces and filter them by name or location.
- Admins can view all bookings for a specific space.
- Admins can view all bookings for a specific user.
- Admins can view all bookings for a specific date.
- Admins can view all bookings for a specific date range

## Technologies

- Laravel 11.x (PHP 8.2) - Backend
- Vue.js 3 - Frontend
- Tailwind CSS - Styling
- MySQL - Database
- Laravel Sanctum - Authentication
- Laravel Livewire - Frontend
- Laravel Jetstream - Frontend
- Laravel Telescope - Debugging
- Laravel Tinker - Debugging
- Laravel Seeder - Database seeding
- Laravel Migrations - Database migrations
- Laravel Eloquent - ORM

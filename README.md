# Gym Management Website (Laravel)

A simple **Gym Management System** built with **Laravel** to manage gym members, trainers, classes, and more. This project focuses on CRUD operations and a clean, user-friendly interface.

## Features

- ✅ Manage Gym Members (Create, Read, Update, Delete)
- ✅ View all members in a responsive table
- ✅ Easy to extend to Trainers, Classes, and Payments
- ✅ Built with Laravel 10, Blade, and Bootstrap/TailwindCSS
- ✅ Ready for deployment



## Requirements

- PHP >= 8.1  
- Composer  
- MySQL or MariaDB  
- Node.js & npm (if using front-end build tools)  

## Installation

1. Run this commandes:
```bash
cd sport
Install dependencies:

composer install
npm install
npm run dev


Update .env with your database credentials.

Generate application key:


php artisan key:generate
Run migrations:


php artisan migrate
Serve the application:


php artisan serve
Open http://127.0.0.1:8000/

Usage
Go to /members to see the list of gym members.

You can extend the app to add Trainers, Classes, Attendance, or Payments.

Contributing
Fork the repository

Create your feature branch (git checkout -b feature/new-feature)

Commit your changes (git commit -m 'Add new feature')

Push to the branch (git push origin feature/new-feature)

Open a Pull Request

License
This project is open-sourced under the MIT license.

# Backend Aplikasi Kasir

## Tech Stack
- PHP 7.4
- Laravel 8.x
- MySQL 8.0
- Composer 2.x

## Installation
- cd to this directory
- copy .env.example to .env
- configure database in .env
- run `composer install` on your terminal
- run `php artisan key:generate` on your terminal
- run `php artisan migrate:fresh --seed` on your terminal
- run `php artisan serve` on your terminal

## Default Admin Credentials
```
email: admin@admin.com
password: Admin123
```

## Database Design
![ERD](https://github.com/rullyafrizal/kasir-backend/blob/master/kasir-backend/erd.png)

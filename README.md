# Furniture & Decor

A simple e-commerce web app for a furniture store built with PHP, MySQL, and CSS/JS.

## Tech Stack
PHP . MySQL . HTML/CSS/JS . Font Awesome . Apache (XAMPP)

## Features
- Browse and search products
- User registration, login, forgot password
- Add to cart, update quantity, place orders
- Order history with status tracking
- Admin panel — manage products, orders, and admins
- Secret-key protected admin registration (first admin becomes superadmin)
- Real-time form validation

## Setup

1. Clone into your XAMPP `htdocs` folder
2. Create a database named `furniture` in phpMyAdmin and import the SQL from database.sql
3. Update `config/constants.php` with your DB credentials and port
4. Visit `http://localhost/furniture&Decor/user/furniture.php`

## Admin Access
Go to `http://localhost/furniture&Decor/admin/register.php` and use the secret key to register.  
The first person to register becomes **superadmin**.


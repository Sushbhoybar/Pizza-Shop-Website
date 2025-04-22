# 🍕 Pizza Shop Management System {http://mypizza-shop.byethost8.com/}

A full-featured Pizza Shop Management System built using **HTML**, **CSS**, **JavaScript**, **Bootstrap**, **PHP**, and **MySQL**. This project supports both **Customer** and **Admin** roles with separate dashboards, dynamic pizza management, cart system, fake payment integration, and real-time order tracking.

## 🚀 Features

### 👥 User Roles
- **Customer:**
  - View all available pizzas
  - Add/remove pizzas to/from cart
  - Place orders with address and fake payment
  - Track order status (Pending → Preparing → Out for Delivery → Delivered)
  - Cancel order within 3 minutes
  - View profile and order history
  - Upload profile picture

- **Admin:**
  - Add/Edit/Delete pizzas (image, price, category, toppings)
  - View/manage incoming orders
  - Accept or reject orders
  - Update order status dynamically
  - Receive cancel notifications
  - View profile and manage personal info

### ⚙️ System Functionality
- Single `login.html` for both Customer and Admin
- Redirect based on role after login:
  - Customers → `index.html`
  - Admins → `admin_index.html`
- Separate navigation menus for Customers and Admins
- Fake payment system (no real transaction)
- Secure role-based page access
- Orders automatically deleted 1 minute after cancelation
- Order notifications for both Admin and Customer
- Responsive design using Bootstrap



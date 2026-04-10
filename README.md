div align="center">

# 📦 LearnVentory-Hub
**School Cooperative Inventory & POS System**

[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/Frontend-HTML5_%7C_CSS3-E34F26?style=flat-square&logo=html5&logoColor=white)]()
[![License: MIT](https://img.shields.io/badge/License-MIT-success.svg?style=flat-square)](https://opensource.org/licenses/MIT)
</div>
<p align="center">
  A web-based Inventory Management and Point-of-Sale (POS) system  
  specifically designed for school cooperative stores.  
  Built with a focus on speed, reliability, and ease of use.
</p>

## 🎯 Overview

**LearnVentory-Hub** aims to transform traditional manual inventory tracking and sales processes in school cooperative stores into a modern digital system.

Instead of relying on handwritten records, this platform provides a robust web-based solution that allows administrators and staff to manage inventory, monitor stock levels, and process sales in real time.

---
## 🎥 Demo

<div align="center">
<p align="center"><video src = "https://github.com/user-attachments/assets/97003430-b919-4098-a99d-95fe26debd7e"</p>
</video>
</div>


## ✨ Key Features

### 🔐 Security & Access
- **Role-Based Authentication (RBAC):** Clearly defined access levels for `Admin` (full access) and `Staff` (sales only)
- **Secure Sessions:** Login protection using PHP sessions with password hashing

### 📦 Inventory Control
- **CRUD Operations:** Create, Read, Update, and Delete products and categories
- **Dynamic Filtering:** Quickly search products by name and category
- **Low Stock Monitoring:** Real-time display of remaining stock

### 🛒 Point of Sale (POS)
- **Fast Checkout:** User-friendly interface optimized for quick transactions
- **Automated Processing:** Automatically deducts stock after each sale

### 📊 Insights & Reporting
- **Sales Analytics:** Track transaction history and calculate total revenue

---
## 🛠 Tech Stack

**Frontend:**
- HTML5  
- CSS3 (Responsive Design)  
- Sarabun Font (optimized for readability)

**Backend:**
- PHP (running on Apache server)

**Database:**
- MySQL  
---

## 🚀 Installation Guide

You can easily run this project locally by following these steps:

### 1. Prerequisites
- Local server environment such as **XAMPP** or **Laragon**
- Web browser (Chrome, Edge, or Safari)

---

### 2. Setup Instructions

1. **Copy Project Files**  
   Place the `LearnVentory-Hub` folder into your server directory  
   - Example (Windows with XAMPP):  
     `C:\xampp\htdocs\LearnVentory-Hub`

2. **Configure Database**
   - Open: `http://localhost/phpmyadmin`  
   - Create a new database named **`pos_store`**  
   - Import the file **`pos_store.sql`**  

3. **Run the Application**
   - Open your browser and go to:  
     `http://localhost/LearnVentory-Hub`  

   - To access Admin features, register a new account or use existing credentials in the database  

---

## 📂 System Structure

```text
LearnVentory-Hub/
├── index.php               # Entry point (session handler)
├── login.php / logout.php  # Authentication system
├── register.php            # User registration
├── manage_products.php     # Inventory management (CRUD)
├── manage_categories.php   # Category management
├── sell.php                # POS interface (Staff/Admin)
├── process_payment.php     # Payment processing & stock update
├── sales_report.php        # Sales reporting dashboard
├── db.php                  # Database connection
└── pos_store.sql           # Database schema
```
## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

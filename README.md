# PHP Blog Engine

A simple but fully functional blog application built with **pure PHP**, **MySQL**, and **Smarty Template Engine**.

The project was developed as a technical assignment to demonstrate:

- clean PHP architecture;
- database design;
- secure database interaction;
- template-based rendering;
- maintainable project structure;
- modern development workflow without using a PHP framework.

---

# Features

## Categories

- Display categories containing published articles
- Category descriptions
- Category article listing

## Articles

- Article preview image
- Title
- Description
- Full content
- View counter
- Multiple category assignment

## Article Browsing

Implemented:

- latest articles by category;
- article sorting;
- pagination;
- related articles.

---

# Technology Stack

## Backend

- PHP 8.1+
- MySQL 8.x
- PDO
- Smarty Template Engine
- Composer

## Frontend

- HTML5
- SCSS
- CSS3
- Responsive layout

## Development Environment

- Docker
- Docker Compose
- Nginx
- PHP-FPM

---

# Architecture

The application follows a lightweight MVC-inspired architecture.

```
Browser
   |
   v
Front Controller
(public/index.php)
   |
   v
Router
   |
   v
Controller
   |
   +------------+
   |            |
   v            v
Model       Smarty
   |
   v
PDO
   |
   v
MySQL
```

Main principles:

- separation of concerns;
- single responsibility;
- clean dependency flow;
- maintainable project structure.

Detailed architecture documentation:

```
docs/ARCHITECTURE.md
```

---

# Requirements

Before running the project, install:

- Docker
- Docker Compose
- Git

No local PHP or MySQL installation is required.

---

# Installation

## 1. Clone repository

```bash
git clone https://github.com/<username>/php-blog-engine.git

cd php-blog-engine
```

---

## 2. Create environment file

Copy the example configuration:

```bash
cp .env.example .env
```

Update database settings if required.

Example:

```env
DB_HOST=mysql
DB_NAME=blog
DB_USER=root
DB_PASSWORD=root
```

---

## 3. Start Docker containers

Run:

```bash
docker compose up -d
```

The following services will be started:

- PHP-FPM
- Nginx
- MySQL

---

## 4. Install PHP dependencies

Run:

```bash
docker compose exec php composer install
```

---

## 5. Create database structure

Execute:

```bash
docker compose exec mysql mysql -u root -p blog < database/schema.sql
```

---

## 6. Generate sample data

Run the database seeder:

```bash
docker compose exec php php database/seeder.php
```

The database will be populated with:

- categories;
- articles;
- category relationships;
- sample metadata.

---

# Running Application

Open:

```
http://localhost
```

Available pages:

```
/
```

Home page

```
/category/{id}
```

Category page

```
/article/{id}
```

Article page

---

# Project Structure

```
project/

├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   ├── Database/
│   └── Helpers/
│
├── config/
│
├── database/
│   ├── schema.sql
│   └── seeder.php
│
├── public/
│   └── index.php
│
├── resources/
│   └── scss/
│
├── templates/
│   ├── layouts/
│   ├── components/
│   └── pages/
│
├── docs/
│   ├── TASK.md
│   ├── SPECIFICATION.md
│   ├── IMPLEMENTATION_PLAN.md
│   ├── ARCHITECTURE.md
│   └── DECISIONS.md
│
├── docker/
│
├── composer.json
├── docker-compose.yml
├── .env.example
└── README.md
```

---

# Database Structure

The application uses three main tables:

```
categories

articles

article_category
```

Relationship:

```
Category

    many-to-many

Article
```

An article can belong to multiple categories.

---

# Development Workflow

The project follows incremental development.

Changes are committed in logical steps:

Example:

```
feat: initialize project structure

feat: add database schema

feat: implement article model

feat: add category page

style: improve article layout
```

The commit history reflects the development process and implementation decisions.

---

# Code Quality

The project follows:

- PSR-12 coding style;
- PSR-4 autoloading;
- prepared SQL statements;
- environment-based configuration;
- separation of application layers.

---

# Security

Implemented protections:

- PDO prepared statements;
- SQL injection prevention;
- output escaping;
- input validation.

---

# SCSS Architecture

Styles are organized using SCSS modules.

Structure:

```
resources/scss/

├── abstracts/
│   ├── variables
│   └── mixins
│
├── base/
│   ├── reset
│   └── typography
│
├── components/
│
├── layout/
│
└── pages/
```

Benefits:

- reusable styles;
- better organization;
- easier maintenance.

---

# Docker Environment

Docker is used as the standard development environment.

Services:

| Service | Purpose |
|---------|---------|
| nginx | Web server |
| php-fpm | PHP runtime |
| mysql | Database |

Benefits:

- reproducible environment;
- simplified setup;
- dependency isolation.

---

# AI Usage

AI tools were used as a development assistant.

Usage examples:

- brainstorming implementation approaches;
- reviewing code structure;
- improving documentation;
- checking possible edge cases;
- validating technical decisions.

All architectural decisions, implementation choices, and final code were reviewed and finalized manually.

---

# Documentation

Additional documentation:

| Document | Description |
|-|-|
| TASK.md | Original assignment requirements |
| SPECIFICATION.md | Technical implementation specification |
| IMPLEMENTATION_PLAN.md | Development roadmap |
| ARCHITECTURE.md | Application architecture |
| DECISIONS.md | Engineering decisions and rationale |

---

# Future Improvements

Possible extensions:

- Admin dashboard
- User authentication
- REST API
- Article search
- Comments
- Tags
- Image upload management
- Automated tests
- CI/CD pipeline

---

# License

This project was created for demonstration and evaluation purposes.

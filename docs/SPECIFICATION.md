# Technical Specification

## Purpose

This document describes the technical implementation of the Blog application based on the requirements defined in `TASK.md`.

The goal is to build a lightweight, maintainable, and extensible application using plain PHP without any frameworks while following modern software engineering practices.

---

# Technology Stack

| Technology | Version |
|------------|---------|
| PHP | 8.1+ |
| MySQL | 8.x |
| Smarty | Latest Stable |
| Composer | Latest |
| Docker | Latest Stable |
| SCSS | Latest Stable |

---

# Development Environment

Docker is used as the standard development environment for this project.

Although Docker was listed as an additional advantage in the assignment, this implementation uses it as a required part of the development workflow.

The Docker environment provides:

- PHP runtime
- MySQL database
- Nginx web server
- Dependency isolation
- Reproducible setup

---

# Architecture

The application follows a lightweight MVC-inspired architecture.

```
Browser
    │
    ▼
public/index.php
    │
    ▼
Router
    │
    ▼
Controller
    │
    ▼
Model
    │
    ▼
PDO
    │
    ▼
MySQL
    │
    ▼
Smarty
    │
    ▼
HTML Response
```

Responsibilities:

| Layer | Responsibility |
|--------|----------------|
| Router | Request dispatching |
| Controller | Business flow |
| Model | Database interaction |
| Smarty | View rendering |
| Database | Data persistence |

---

# Project Structure

```
project/

app/
│
├── Controllers/
├── Models/
├── Database/
├── Services/
├── Helpers/

config/

database/

public/

templates/

storage/

vendor/

docker/
```

---

# Routing

The application provides the following public routes.

| Route | Description |
|--------|-------------|
| / | Home page |
| /category/{id} | Category page |
| /article/{id} | Article page |

Future routes can easily be added by extending the Router.

---

# Database Design

## Categories

| Column | Type |
|---------|------|
| id | INT |
| name | VARCHAR |
| description | TEXT |
| created_at | DATETIME |
| updated_at | DATETIME |

---

## Articles

| Column | Type |
|---------|------|
| id | INT |
| image | VARCHAR |
| title | VARCHAR |
| description | TEXT |
| content | LONGTEXT |
| views | INT |
| published_at | DATETIME |
| created_at | DATETIME |
| updated_at | DATETIME |

---

## Article Categories

Many-to-Many relationship.

| Column | Type |
|---------|------|
| article_id | INT |
| category_id | INT |

---

# Application Flow

## Home Page

The home page displays:

- categories containing articles;
- three latest articles for every category;
- "View All Articles" button.

Categories without articles are not displayed.

---

## Category Page

Displays:

- category information;
- article list;
- sorting;
- pagination.

Sorting options:

- newest first
- most viewed

Pagination is performed at the SQL level.

---

## Article Page

Displays:

- article information;
- categories;
- view counter;
- three related articles.

Related articles are selected based on shared categories.

---

# Business Rules

## Categories

- Categories without articles are hidden.
- A category may contain unlimited articles.

---

## Articles

- An article belongs to one or multiple categories.
- View counter is displayed.
- Publication date determines ordering.

---

# Data Access

All database communication is performed through PDO.

Requirements:

- Prepared Statements
- Parameter Binding
- Exception Handling

No raw SQL should be embedded inside Controllers.

---

# Models

## Category Model

Responsibilities:

- retrieve categories;
- retrieve category by ID;
- retrieve categories with latest articles.

---

## Article Model

Responsibilities:

- retrieve article;
- retrieve articles by category;
- retrieve related articles;
- sorting;
- pagination.

---

# Controllers

## HomeController

Responsible for rendering the home page.

---

## CategoryController

Responsible for displaying category information and article list.

---

## ArticleController

Responsible for displaying article details.

---

# Presentation Layer

Smarty is used for rendering HTML.

Templates should be separated into reusable components.

The styling layer is implemented using SCSS.

SCSS was selected to improve:

- stylesheet organization;
- maintainability;
- reusable variables;
- reusable mixins;
- scalable component styling.

Compiled CSS is served to the browser, while source SCSS files remain organized by responsibility.

Suggested structure:

```
templates/

layouts/

partials/

pages/
```

---

# Configuration

Application configuration is stored outside the source code.

Environment variables include:

- Database Host
- Database Name
- Database User
- Database Password

---

# Seeder

The project provides a Seeder capable of generating sample data.

Generated data includes:

- Categories
- Articles
- Category relationships
- Random publication dates
- Random view counters

---

# Error Handling

The application should gracefully handle:

- Missing categories
- Missing articles
- Invalid routes

404 page should be displayed whenever appropriate.

---

# Security

The application should implement the following security measures:

- Prepared SQL statements
- Input validation
- Output escaping
- SQL Injection prevention
- XSS prevention

---

# Performance

Basic optimization requirements:

- Database indexes
- SQL LIMIT
- SQL OFFSET
- Avoid unnecessary queries

---

# Code Style

The implementation should follow:

- PSR-12 coding style
- Composer autoloading (PSR-4)
- Meaningful naming
- Single Responsibility Principle where applicable

---

# Deliverables

The repository should contain:

- Source code
- SQL schema
- Seeder
- Docker configuration (optional)
- README
- Documentation

---

# Future Improvements

Possible future enhancements:

- Admin panel
- Authentication
- Article search
- Tag system
- Comments
- REST API
- Image upload
- Unit testing

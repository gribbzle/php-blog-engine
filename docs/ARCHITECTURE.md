# Architecture

## Overview

The Blog application is built using a lightweight MVC-inspired architecture.

Although no PHP framework is used, the project follows common architectural principles such as:

- Separation of Concerns (SoC)
- Single Responsibility Principle (SRP)
- Layered Architecture
- Front Controller Pattern

The goal is to keep the application simple, maintainable, and easy to extend.

---

# High-Level Architecture

```
                     HTTP Request
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
          ┌───────────────┴───────────────┐
          ▼                               ▼
       Services                       Models
          │                               │
          └───────────────┬───────────────┘
                          ▼
                         PDO
                          │
                          ▼
                        MySQL
                          │
                          ▼
                     Smarty View
                          │
                          ▼
                     HTML Response
```

---

# Directory Structure

```
project/

app/
├── Controllers/
├── Models/
├── Services/
├── Database/
└── Helpers/

config/

database/

public/

templates/

storage/

vendor/

docs/
```

---

# Layer Responsibilities

## Front Controller

Entry point:

```
public/index.php
```

Responsibilities:

- Bootstrap application
- Load Composer autoloader
- Load configuration
- Initialize Router
- Dispatch request

Only one public entry point exists.

---

## Router

Responsibilities:

- Parse URL
- Match routes
- Extract route parameters
- Execute corresponding controller

Example:

```
GET /
GET /category/3
GET /article/25
```

The Router does not contain business logic.

---

## Controllers

Controllers coordinate the application flow.

Responsibilities:

- Receive request
- Validate parameters
- Call Models (or Services)
- Pass data to Smarty
- Return response

Controllers never contain SQL queries.

---

## Models

Models encapsulate all database interaction.

Responsibilities:

- Read data
- Write data
- Build SQL queries
- Return domain objects

Models do not generate HTML.

---

## Services

Services contain reusable business logic that may be shared across multiple controllers.

Examples:

- Related article selection
- Pagination
- Sorting logic

This layer remains optional for small projects but improves scalability.

---

## Database Layer

Database communication is performed using PDO.

Features:

- Prepared Statements
- Exception handling
- Parameter binding

The Database layer provides a single connection shared throughout the application.

---

## Presentation Layer

Smarty is responsible only for rendering HTML.

Templates never execute SQL queries.

Business logic is kept outside templates.

---

# Request Lifecycle

```
Browser

↓

HTTP Request

↓

public/index.php

↓

Router

↓

Controller

↓

Model

↓

PDO

↓

MySQL

↓

Controller

↓

Smarty

↓

HTML

↓

Browser
```

---

# Data Flow

```
User Request

↓

Controller

↓

Model

↓

Database

↓

Model

↓

Controller

↓

Smarty

↓

HTML Response
```

Data always moves in one direction.

---

# Database Architecture

The application contains three tables.

```
categories

articles

article_category
```

Relationship:

```
Category

1

↓

∞

Article_Category

∞

↓

1

Article
```

This implements a Many-to-Many relationship.

---

# Routing Architecture

Public routes:

```
/

/category/{id}

/article/{id}
```

Each route maps to exactly one controller action.

Example:

```
GET /

↓

HomeController::index()
```

---

# Template Architecture

Templates are separated into reusable components.

```
templates/

layouts/

partials/

pages/
```

Example:

```
layout.tpl

↓

home.tpl

↓

category.tpl

↓

article.tpl
```

Shared UI components should be extracted into partial templates whenever possible.

---

# Configuration

Configuration is externalized using environment variables.

Example:

```
.env

DB_HOST

DB_NAME

DB_USER

DB_PASSWORD
```

No sensitive configuration is stored in source code.

---

# Error Handling

Expected errors:

- Invalid route
- Missing article
- Missing category
- Database exception

Error pages are rendered using Smarty.

---

# Security Architecture

Security measures include:

- Prepared SQL statements
- Escaped HTML output
- Input validation
- Parameterized queries
- Exception handling

The application avoids:

- SQL Injection
- XSS
- Hardcoded credentials

---

# Scalability

Although intentionally simple, the architecture allows future extension.

Possible additions:

- Admin panel
- Authentication
- REST API
- Image uploads
- Search
- Comments
- Tags
- Unit testing

No major architectural changes would be required.

---

# Design Principles

The implementation follows the following principles.

## Separation of Concerns

Each layer has one responsibility.

---

## Single Responsibility Principle

Every class should have only one reason to change.

---

## Dependency Isolation

Business logic is isolated from presentation.

Database logic is isolated from controllers.

---

## Reusability

Shared functionality should be extracted into reusable classes.

---

## Maintainability

Project structure should remain understandable as the application grows.

---

# Technology Decisions

| Component | Choice |
|-----------|--------|
| Language | PHP 8.1+ |
| Templates | Smarty |
| Database | MySQL |
| Database Access | PDO |
| Dependency Management | Composer |
| Configuration | Dotenv |
| Styling | SCSS |
| Environment | Docker |

---

# Docker Architecture

The application is executed inside Docker containers.

Containers:

- nginx
- php-fpm
- mysql

Benefits:

- identical environments;
- simplified onboarding;
- predictable deployments;
- dependency isolation.

---

# Frontend Architecture

The presentation layer consists of:

Templates (Smarty)

↓

SCSS

↓

Compiled CSS

↓

Browser

---

# Summary

The chosen architecture keeps the application:

- Simple
- Modular
- Readable
- Maintainable
- Easy to extend

While intentionally avoiding frameworks, the project still follows common software engineering practices and modern PHP development principles.

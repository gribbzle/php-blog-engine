# Engineering Decisions

## Purpose

This document records the key architectural and technical decisions made during the implementation of the Blog application.

Each decision explains:

- what was chosen;
- why it was chosen;
- which alternatives were considered;
- why those alternatives were rejected.

---

# Decision 001

## Use a Lightweight MVC Architecture

### Decision

The application is implemented using a lightweight MVC-inspired architecture.

### Rationale

Although no framework is allowed, separating responsibilities between Controllers, Models, and Views improves:

- readability;
- maintainability;
- scalability;
- testability.

### Alternatives Considered

- Procedural PHP
- Single-file application

### Why Not

While procedural PHP would satisfy the assignment, it quickly becomes difficult to maintain and extend.

---

# Decision 002

## Use PDO

### Decision

PDO is used as the database abstraction layer.

### Rationale

PDO provides:

- prepared statements;
- parameter binding;
- exception handling;
- portability.

### Alternatives Considered

- mysqli

### Why Not

PDO offers a cleaner API and supports multiple database drivers while encouraging secure SQL practices.

---

# Decision 003

## Composer for Dependency Management

### Decision

Composer is used to manage project dependencies.

### Rationale

Composer is the standard dependency manager for modern PHP applications.

It also provides:

- PSR-4 autoloading;
- reproducible dependency installation;
- package version management.

### Alternatives Considered

- Manual includes

### Why Not

Manual dependency management becomes increasingly difficult as the project grows.

---

# Decision 004

## PSR-4 Autoloading

### Decision

Classes are loaded using Composer's PSR-4 autoloader.

### Rationale

Advantages include:

- automatic class loading;
- cleaner code;
- improved maintainability.

### Alternatives Considered

- require
- require_once

### Why Not

Manual includes tightly couple files and increase maintenance overhead.

---

# Decision 005

## Environment Configuration

### Decision

Configuration values are stored in environment variables.

### Rationale

Sensitive information should never be committed into source code.

Examples:

- database password;
- database host;
- usernames.

### Alternatives Considered

- Hardcoded configuration

### Why Not

Hardcoded credentials reduce flexibility and create security risks.

---

# Decision 006

## Many-to-Many Relationship

### Decision

Articles and categories are connected through a junction table.

```
articles

↓

article_category

↓

categories
```

### Rationale

The assignment allows an article to belong to multiple categories.

This relationship is naturally represented as Many-to-Many.

### Alternatives Considered

- Single category per article

### Why Not

It would not satisfy the functional requirements.

---

# Decision 007

## Separate Controllers and Models

### Decision

Controllers do not execute SQL queries directly.

### Rationale

Business logic and persistence should remain independent.

Controllers coordinate application flow.

Models communicate with the database.

### Alternatives Considered

- SQL inside Controllers

### Why Not

Mixing responsibilities makes the application difficult to maintain.

---

# Decision 008

## Smarty as Presentation Layer

### Decision

Smarty is used exclusively for rendering HTML.

### Rationale

Business logic remains inside PHP classes.

Templates remain clean and easy to understand.

### Alternatives Considered

- Native PHP templates

### Why Not

The assignment explicitly requires Smarty.

---

# Decision 009

## Front Controller Pattern

### Decision

All requests pass through:

```
public/index.php
```

### Rationale

Benefits:

- centralized request handling;
- simple routing;
- easier configuration;
- scalability.

### Alternatives Considered

- Multiple entry points

### Why Not

A single entry point simplifies request processing.

---

# Decision 010

## Prepared Statements Everywhere

### Decision

Every SQL query uses prepared statements.

### Rationale

Prepared statements:

- prevent SQL Injection;
- improve code readability;
- separate SQL from data.

### Alternatives Considered

- String concatenation

### Why Not

Concatenating SQL queries is insecure and error-prone.

---

# Decision 011

## Pagination in SQL

### Decision

Pagination is implemented using SQL.

```
LIMIT

OFFSET
```

### Rationale

Only the required rows are loaded from the database.

### Alternatives Considered

- Load all rows into PHP

### Why Not

Loading unnecessary data wastes memory and reduces performance.

---

# Decision 012

## Sorting in SQL

### Decision

Sorting is delegated to MySQL.

### Rationale

Database engines are optimized for sorting large datasets.

### Alternatives Considered

- PHP sorting

### Why Not

Sorting inside PHP is less efficient and increases memory usage.

---

# Decision 013

## Related Articles

### Decision

Related articles are selected using shared categories.

### Rationale

This is simple, efficient, and satisfies the assignment requirements.

### Alternatives Considered

- Similar titles
- Full-text search
- Tags

### Why Not

Those approaches introduce unnecessary complexity.

---

# Decision 014

## Keep Business Logic out of Templates

### Decision

Smarty templates contain only presentation logic.

### Rationale

Templates should describe **how data is displayed**, not **how data is obtained**.

### Alternatives Considered

- Complex Smarty logic

### Why Not

Mixing presentation and business logic reduces readability.

---

# Decision 015

## Docker Support

### Decision

Docker configuration is included.

### Rationale

Docker ensures:

- reproducible environments;
- simplified setup;
- consistent development experience.

### Alternatives Considered

- Local PHP installation only

### Why Not

Local environments often differ between developers.

---

# Decision 016

## Incremental Git Commits

### Decision

Development is committed incrementally.

### Rationale

A structured commit history demonstrates:

- implementation progress;
- development workflow;
- engineering thought process.

### Alternatives Considered

- Single final commit

### Why Not

A single commit hides implementation history and makes code review more difficult.

---

# Decision 017

## Code Style

### Decision

The project follows PSR-12.

### Rationale

Consistent formatting improves readability and maintainability.

### Alternatives Considered

- Personal formatting style

### Why Not

Following community standards improves collaboration.

---

# Decision 018

## Simple Architecture over Premature Complexity

### Decision

The application intentionally avoids unnecessary abstractions.

### Rationale

The assignment is relatively small.

The chosen architecture should remain:

- understandable;
- maintainable;
- appropriate for the project size.

### Alternatives Considered

- Repository Pattern
- Dependency Injection Container
- Event System
- ORM

### Why Not

These approaches introduce unnecessary complexity for the scope of this assignment.

---

# Final Notes

Every decision in this project was made with the following priorities:

1. Simplicity
2. Readability
3. Maintainability
4. Security
5. Extensibility

The resulting architecture intentionally balances clean software engineering practices with the limited scope of the assignment.

---

# Decision 019

## Docker is Required

### Decision

The project is developed and executed exclusively using Docker.

### Rationale

Docker guarantees that every developer works in an identical environment.

Benefits include:

- reproducible builds;
- simplified setup;
- dependency isolation;
- consistent PHP and MySQL versions.

### Alternatives Considered

Native PHP installation.

### Why Not

Local environments often differ, making debugging and onboarding more difficult.

---

# Decision 020

## SCSS Instead of Plain CSS

### Decision

All styles are written using SCSS.

### Rationale

SCSS improves:

- code organization;
- reusable variables;
- reusable mixins;
- maintainability;
- scalability.

### Alternatives Considered

Plain CSS.

### Why Not

Plain CSS becomes increasingly difficult to maintain as the project grows.

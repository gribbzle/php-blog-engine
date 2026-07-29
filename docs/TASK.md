# Task

## Overview

The goal of this assignment is to develop a simple but fully functional blog application using **pure PHP** (without frameworks), **MySQL**, and the **Smarty** template engine.

The application should demonstrate clean project structure, proper database interaction, readable code, and understanding of core PHP development principles.

---

# Technology Stack

The project must use the following technologies:

- PHP 8.1+
- MySQL
- Smarty Template Engine

### Restrictions

- PHP frameworks are **not allowed** (Laravel, Symfony, Yii, CodeIgniter, etc.).
- The application should be implemented using plain PHP.

---

# Data Model

## Category

A category must contain the following fields:

| Field | Description |
|--------|-------------|
| Name | Category name |
| Description | Category description |

---

## Article

An article must contain the following fields:

| Field | Description |
|--------|-------------|
| Image | Preview image |
| Title | Article title |
| Description | Short article description |
| Content | Full article content |
| Categories | One or more assigned categories |
| Views | Number of article views |

---

# Functional Requirements

## Home Page

Display all categories that contain at least one published article.

For each category display:

- Category title
- Three most recent articles (ordered by publication date)
- "All Articles" button leading to the category page

---

## Category Page

Display:

- Category title
- Category description
- List of articles

Additional functionality:

- Sort articles by:
  - publication date
  - number of views
- Pagination

---

## Article Page

Display:

- Article image
- Article title
- Short description
- Full content
- Assigned categories
- View counter

Additionally display:

- Three related articles

---

# Additional Requirements

Implement a database seeder capable of generating sample data.

The seeder should populate:

- Categories
- Articles
- Category-article relationships

---

# Evaluation Criteria

The solution will be evaluated according to:

- Code readability
- Project structure
- Database design
- MySQL usage
- Clean architecture
- Level of independent implementation
- Understanding of the chosen solution

---

# Bonus Points

The following features are considered an advantage:

- SCSS for styling
- Docker development environment

---

# Deliverables

The completed assignment should be submitted as a public repository hosted on one of the following platforms:

- GitHub
- GitLab
- Bitbucket

---

# AI Usage Disclosure

If AI tools are used during development, the following information should be provided:

- Which AI tool(s) were used
- For which tasks they were used

This information is required to correctly evaluate the implementation approach and the level of independent work.

---

# Git History

It is recommended to create commits incrementally throughout the development process.

A meaningful commit history should demonstrate:

- Development workflow
- Implementation logic
- Progress of the solution

---

# Expected Result

The final result should be a fully functional blog application that satisfies all functional requirements and demonstrates good software engineering practices using plain PHP.

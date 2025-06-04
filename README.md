# 🧱 PHP Clean Architecture API

A robust and modular **RESTful API** built with **Pure PHP**, following the **Clean Architecture** principles. This project uses **Doctrine ORM** for data mapping, **PHPUnit** for testing, and is fully containerized using **Docker** and **Shell Scripts** for setup and automation.

---

## 🚀 Technologies Used

| Technology | Description |
|-----------|-------------|
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) | Core programming language |
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white) | Dependency management |
| ![Clean Architecture](https://img.shields.io/badge/Clean%20Architecture-Pattern-brightgreen?style=for-the-badge) | Software design pattern |
| ![Doctrine ORM](https://img.shields.io/badge/Doctrine-FF7139?style=for-the-badge&logo=doctrine&logoColor=white) | ORM for data persistence |
| ![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white) | Containerization tool |
| ![Shell Script](https://img.shields.io/badge/Shell-121011?style=for-the-badge&logo=gnu-bash&logoColor=white) | Automation and setup scripts |
| ![PHPUnit](https://img.shields.io/badge/PHPUnit-3A2C8A?style=for-the-badge&logo=php&logoColor=white) | Unit testing framework |

---
## 📦 Features

- ✅ Clean and maintainable structure
- ✅ Fully containerized
- ✅ Doctrine ORM mapping
- ✅ Shell scripts for automation
- ✅ PHPUnit integration
- ✅ Easy to extend with new modules

---
## 🐳 Setup

1. Copy the **.env.example** and **docker-compose.override.example.yml** files and rename them (respectively) to **.env** and **docker-compose.override.yml**.

   > ⚠️ **Warning:** If the default database port is in use, use another one and reflect this change in the service configuration.

   ```yaml
   # docker-compose.override.yml
   db:
     image: mysql:8.0
     container_name: mysql_db
     restart: unless-stopped
     environment:
       MYSQL_DATABASE: ${DB_DATABASE}
       MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
     ports:
       - "3306:3306" # <- Change here to 3307:3306 for example 
     volumes:
       - db_data:/var/lib/mysql

2. Access the project directory:
    ```bash
    cd php-cleanarch-api/
    ```

3. The first time you run it on your machine, run the command:
    ```bash
    docker-compose up --build
    ```

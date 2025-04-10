# Architecture Library for the Repository Pattern

## Description

**Architecture Library** is a PHP package focused on automating the creation of essential files for implementing the Repository Pattern in Laravel.  
Through Artisan commands, it allows you to generate repositories, services, DTOs, controllers, and other necessary components to structure an application following this architecture.

## Installation

To install this library, use Composer:

```bash
composer require jaimec-coder/architecture-library
```

## Available Commands

### 1. Generate a full architecture

```bash
php artisan make:architecture {name}
```

This command generates all files related to the Repository Pattern for the specified entity (`{name}`). It includes:

- Repository (`make:repository`)
- Service (`make:service`)
- DTO (`make:dto`)
- Controller (`make:controller` with `--resource` and `--model`)
- Request (`make:request`)
- Resource (`make:resource`)

### 2. Create a DTO

```bash
php artisan make:dto {name}
```

Generates a Data Transfer Object (DTO) in the `app/DTOs/` folder.

### 3. Create a Repository

```bash
php artisan make:repository {name}
```

Creates a repository in `app/Repositories/`.  
If it doesn’t exist, it also generates a `BaseRepository.php`.

### 4. Create a Service

```bash
php artisan make:service {name}
```

Generates a service in `app/Services/` that interacts with the corresponding repository.

### 5. Optimize the Application

```bash
php artisan app:optimize
```

Cleans the application cache and optimizes configuration to improve performance.

## Support

For assistance, please send an email to **centurionjaime@gmail.com**.

## License

This project is licensed under the [MIT License](https://choosealicense.com/licenses/mit/)

## Authors

- [@Eduardo Centurión](https://www.github.com/JaimeC-coder)

## Requirements

- PHP ^7.1
 
 

# Architecture Library for the repository pattern 

Descripcion

Architecture Library es una librería PHP enfocada en la creación automatizada de archivos esenciales para la implementación del patrón Repository en Laravel. A través de comandos Artisan, permite generar repositorios, servicios, DTOs, controladores y otros componentes necesarios para estructurar una aplicación siguiendo este patrón.


## Instalación

Para instalar esta librería, usa Composer:

```bash
composer require repopattern/arch
```
    

## Comandos disponibles

1. Generar una arquitectura completa

```bash
php artisan make:architecture {name}
```

Este comando genera todos los archivos relacionados con el patrón Repository para la entidad especificada ({name}). Incluye:

- Repositorio (make:repository)

- Servicio (make:service)

- DTO (make:dto)

- Controlador (make:controller con --resource y --model)

- Request (make:request)

- Resource (make:resource)


2. Crear un DTO

```bash
php artisan make:dto {name}

```
Genera un Data Transfer Object (DTO) en la carpeta app/DTOs/.

3. Crear un Repositorio

```bash
php artisan make:repository {name}
```

Crea un repositorio en app/Repositories/. Si no existe, también genera un BaseRepository.php.

4. Crear un Servicio
```bash
php artisan make:service {name}
```
Genera un servicio en app/Services/ que interactúa con el repositorio correspondiente.

5. Optimizar la Aplicación
```bash
php artisan app:optimize
```
Limpia la caché de la aplicación y optimiza la configuración para mejorar el rendimiento.

## Support
Para obtener ayuda, envíe un correo electrónico a centurionjaime@gmail.com.
## License

Este proyecto está bajo la licencia  [MIT](https://choosealicense.com/licenses/mit/)


## Authors

- [@Eduardo Centurión](https://www.github.com/JaimeC-coder)


## Requisitos

- PHP ^7.1
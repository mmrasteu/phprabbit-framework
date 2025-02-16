# Changelog
## [1.0.0] - Pendiente de fecha de salida
### Will add
- **Codigo**:
  - Refactorización y optimización final de todo el código.
  - Limpieza del código.
  - Añadir comentarios necesarios y eliminar comentarios innecesarios
- **Composer**: Implementar instalación del framework desde Composer
- **Docuemntación**: Publicación de la documentación final del framework

## [0.4.0] - 2025-08-30
### Will add
- **Documentación**: Generar documentacion de la API con Swagger.
- **Visor de estado**: Implementar un comando que muestre que controladores estan enlazados con endpoints.

## [0.3.0] - 2025-06-29
### Will add
- **Caché:** Implementación de respuestas en caché.
- **Rate limit:** Implementación de logica para aplicar rate limit personalizado a los endpoints/controladores.
- **Testing**: Implementar testing con PHPUnit y crear algunas pruebas de ejemplo.
- **Manejo de excepciones:** Implementación de manejo total de excepciones personalizadas.
- **Comandos `php rabbit`:** Más comandos básicos usando `php rabbit [comando]`.
- **Traducciones:** Traducción al ingles y al español de los mensajes del framework. Creación de un sistema propio de traducciones para no tener que realizar instalaciones extras para poder utilizar la funcion `__t('mensaje');`

## [0.2.0] - 2025-02-16
### Added
- **Autenticación JWT:** Implementación total de autenticación usando JWT.
- **ORM:** Soporte básico para uso de modelos y bases de datos con el framework.
- **Comandos `php rabbit`:** Más comandos básicos usando `php rabbit [comando]`.
- **Manejo de excepciones:** Implementación de manejo parcial de excepciones personalizadas.
- **Roles:** Implementación total de roles de usuarios API.
- **Traducciones:** Implementación de la lógica de traducciones con `_t('mensaje');`
- **Log:** Implementación del log del framework.
- **Swagger:** Implementación de Swagger para generar documentación de la API. 

## [0.1.0] - 2025-01-10
### Added
- **Estructura básica del framework:** Configuración inicial de carpetas y archivos.
- **Middleware básico:** Un middleware para la validación de tokens.
- **Manejo de rutas:** Soporte para rutas básicas con parámetros, expresiones regulares y grupos.
- **Sistema de respuesta (Response):** Respuestas básicas con código de estado.
- **Autenticación JWT:** Implementación parcial de autenticación usando JWT. Solo para verificar el funcionamiento de `BearerTokenMiddleware` sobre los grupos, no es una implementación de autenticación válida.
- **Comandos `php rabbit`:** Comandos básicos usando `php rabbit [comando]`.
- **Reglas de validación:** Implementación de reglas de validación.

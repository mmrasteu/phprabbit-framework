# PHP Rabbit Framework 

## v0.2.0

[Español](#espanol) | [English](#english)

---

## Español

Rabbit es un framework PHP ligero y modular, diseñado para ofrecer flexibilidad y escalabilidad en el desarrollo de APIs. Se encuentra en sus primeras etapas de desarrollo.

### Instalación

#### Requisitos previos

- PHP 8.x o superior
- Composer (próximamente disponible)
- Instalar Gettext en el servidor para el correcto funcionamiento de las traducciones [Ver pasos](#traducciones)

#### Instrucciones de instalación

Por ahora, Rabbit solo está disponible para ser descargado directamente desde GitHub.

1. Clona el repositorio:
```bash
   git clone https://github.com/mmrasteu/phprabbit-framework.git
```

2. Accede a la carpeta del proyecto:
```bash
   cd rabbit-framework
```

3. Comienza a crear tu proyecto y ajusta el autoload según tus necesidades.

#### Notas

> Rabbit no es instalable actualmente mediante Composer. Planeamos integrar Composer en versiones posteriores.

> Las versiones betas no son recomendables para un desarrollo seguro. Están publicadas para poder ser estudiadas y para aceptar colaboraciones.

### Características

[Ver Changelog](./rabbitcore/docs/changelog.es.md)

### Uso

#### Rutas y grupos

Ejemplo básico de definición de rutas:
```php
//Se añade la ruta /auth al grupo que usa el prefijo /api
Router::group(['prefix' => '/api', 'middlewares' => []], function () {
    Router::POST('/auth', ['AuthController', 'getBearerToken']);
});
```

#### Middleware

Puedes agregar middleware en tu aplicación para validar tokens, manejar autenticación o realizar otras tareas. Se asignan a grupos de rutas.  
Si el middleware necesita parámetros para instanciarse, se deben pasar dentro de un array como se muestra en el ejemplo.

Ejemplo de uso de Middlewares:
```php
//Se pueden definir varios grupos con el mismo prefijo. A este grupo se le añade el middleware `TestMiddleware`
Router::group(['prefix' => '/api', 'middlewares' => ['TestMiddleware']], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

```php
//Se pueden definir varios grupos con el mismo prefijo. A este grupo se le añade el middleware `ParametizableMiddleware` con un parámetro `param1`
Router::group(['prefix' => '/api', 'middlewares' => ['ParametizableMiddleware' => ['param1']]], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```
#### Roles de usuario

El Bearer Token generado al iniciar sesión con un usuario API tiene implícito un rol ('api_user' por defecto) para aplicar esta restricción de acceso vinculada al Bearer Token. El middleware RoleMiddleware se encargará de la gestión de permisos. A continuación se muestra un ejemplo de un endpoint sin necesidad de Bearer Token para llamarlo, un endpoint accesible solo al role 'user_admin' y otro endpoint accesible por todos los usuarios (pero que necesariamente solo se le puede llamar con autenticación con Bearer Token).

Ejemplo de uso:

- Sin autenticación
```php
Router::group(['prefix' => '/api', 'middlewares' => []], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

- Con autenticación, habilitado solo para usuarios con rol 'api_user'
```php
Router::group(['prefix' => '/api', 'middlewares' => ['RoleMiddleware'=>['api_user']]], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

- Con autenticación, habilitado solo para todos los usuarios.
```php
Router::group(['prefix' => '/api', 'middlewares' => ['RoleMiddleware'=>[]]], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

#### Respuestas

Ejemplo de cómo usar las respuestas con código de estado. Estas respuestas se pueden personalizar.
```php
. . . 
// Se obtiene el valor de los parámetros. En este caso del parámetro 'id' que contiene el valor '123'
$id = $this->request->getParam('id');

//Se crea un array con los datos que se mostrarán en la respuesta
$data = [
   'id' => (int) $id
];

//Se envía el $data a la clase Response
$this->response->withStatus200($data);

. . .
```

Respuesta API:
```json
{
	"status": 200,
	"title": "Success",
	"message": "200 - Success",
	"data": {
		"id": 123
	}
}
```
#### Validation Rules

##### **Email**
Valida si el valor es una dirección de correo electrónico válida.

##### **Numeric**
Valida si el valor es un número. Acepta cualquier tipo de valor numérico, incluyendo enteros y flotantes.

##### **Date**
Valida si el valor es una fecha válida según el formato dado (por ejemplo, 'Y-m-d'). El formato por defecto se especifica en la variable de entorno `DEFAULT_DATETIME_FORMAT`

##### **Boolean**
Valida si el valor es un valor booleano (`true` o `false`), o si es una cadena que representa un valor booleano (como "true", "false").

##### **Array**
Valida si el valor es un array.

##### **Url**
Valida si el valor es una URL válida.

##### **Alpha**
Valida si el valor contiene solo caracteres alfabéticos (letras, sin números ni símbolos).

##### **AlphaNumeric**
Valida si el valor contiene solo caracteres alfanuméricos (letras y números).

### Traducciones
- sudo apt-get install gettext
- Descomentar "es_ES.UTF-8 UTF-8" en `/etc/locale.gen` si es necesario.
- sudo locale-gen
- sudo update-locale
- msgfmt ./locale/es_ES/LC_MESSAGES/messages.po -o ./locale/es_ES/LC_MESSAGES/messages.mo

### Contribuir

Si deseas contribuir a Rabbit, por favor sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-caracteristica`).
3. Realiza tus cambios y haz commit de ellos.
4. Envía un pull request con una descripción clara de los cambios.

### Licencia

Este proyecto está bajo la Licencia MIT - consulta el archivo [LICENSE](LICENSE) para más detalles.

### Contacto

Puedes ponerte en contacto conmigo a través de [mmrasteu@gmail.com] para cualquier pregunta o sugerencia.

---

## English

Rabbit is a lightweight and modular PHP framework designed to offer flexibility and scalability for API development. It's still in the early stages of development.

### Installation

#### Prerequisites

- PHP 8.x or higher
- Composer (coming soon)

#### Installation Instructions

For now, Rabbit is only available for download directly from GitHub.

1. Clone the repository:
```bash
   git clone https://github.com/mmrasteu/phprabbit-framework.git
```

2. Navigate to the project folder:
```bash
   cd rabbit-framework
```

3. Start building your project and adjust the autoload as needed.

#### Notes

> Rabbit is currently not installable via Composer. We plan to integrate Composer in future versions.

> Beta versions are not recommended for secure development. They are published to be studied and to accept contributions.

### Features

[View Changelog](./rabbitcore/docs/changelog.en.md)

### Usage

#### Routes and Groups

Basic route definition example:
```php
//Adds the /auth route to the group using the /api prefix
Router::group(['prefix' => '/api', 'middlewares' => []], function () {
    Router::POST('/auth', ['AuthController', 'getBearerToken']);
});
```
#### Middleware

You can add middleware to your application to validate tokens, handle authentication, or perform other tasks. They are assigned to route groups.  
If the middleware needs parameters to be instantiated, they should be passed in an array as shown in the example.

Middleware usage example:
```php
//Multiple groups with the same prefix can be defined. This group adds the `TestMiddleware`
Router::group(['prefix' => '/api', 'middlewares' => ['TestMiddleware']], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

```php
//Multiple groups with the same prefix can be defined. This group adds the `ParametizableMiddleware` with a `param1` parameter
Router::group(['prefix' => '/api', 'middlewares' => ['ParametizableMiddleware' => ['param1']]], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

#### User Roles

The Bearer Token generated when logging in with an API user has an implicit role ('api_user' by default) to apply this access restriction linked to the Bearer Token. The `RoleMiddleware` will handle permission management. Below is an example of an endpoint that does not require a Bearer Token to be called, an endpoint accessible only to the 'user_admin' role, and another endpoint accessible to all users (but that must be called with Bearer Token authentication).

Example usage:

- Without authentication
```php
Router::group(['prefix' => '/api', 'middlewares' => []], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

- With authentication, enabled only for users with the 'api_user' role
```php
Router::group(['prefix' => '/api', 'middlewares' => ['RoleMiddleware'=>['api_user']]], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

- With authentication, enabled for all users.
```php
Router::group(['prefix' => '/api', 'middlewares' => ['RoleMiddleware'=>[]]], function () {
    Router::GET('/test', ['StatusController', 'getStatus']);
});
```

#### Responses

Example of how to use responses with status codes. These responses can be customized.
```php
. . . 
// Get the value of parameters. In this case, the 'id' parameter contains the value '123'
$id = $this->request->getParam('id');

//Create an array with the data that will be shown in the response
$data = [
   'id' => (int) $id
];

//Send the $data to the Response class
$this->response->withStatus200($data);

. . .
```

API Response:
```json
{
	"status": 200,
	"title": "Success",
	"message": "200 - Success",
	"data": {
		"id": 123
	}
}
```

#### Validation Rules

##### **Email**
Validates if the value is a valid email address.

##### **Numeric**
Validates if the value is a number. Accepts any numeric type, including integers and floats.

##### **Date**
Validates if the value is a valid date according to the given format (e.g., 'Y-m-d'). The default format is specified in the environment variable `DEFAULT_DATETIME_FORMAT`.

##### **Boolean**
Validates if the value is a boolean (`true` or `false`), or if it's a string representing a boolean value (e.g., "true", "false").

##### **Array**
Validates if the value is an array.

##### **Url**
Validates if the value is a valid URL.

##### **Alpha**
Validates if the value contains only alphabetic characters (letters, no numbers or symbols).

##### **AlphaNumeric**
Validates if the value contains only alphanumeric characters (letters and numbers).

### Contribute

If you want to contribute to Rabbit, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/new-feature`).
3. Make your changes and commit them.
4. Send a pull request with a clear description of the changes.

### License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### Contact

You can contact me via [mmrasteu@gmail.com] for any questions or suggestions.

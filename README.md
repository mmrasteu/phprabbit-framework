
# Rabbit Framework 

## v0.1.0

Rabbit es un framework PHP ligero y modular, diseñado para ofrecer flexibilidad y escalabilidad en el desarrollo de APIs. Esta es la versión **v0.1.0**, aún no funcional, y se encuentra en sus primeras etapas de desarrollo.

## Instalación

### Requisitos previos

- PHP 8.x o superior
- Composer (próximamente disponible)

### Instrucciones de instalación

Por ahora, Rabbit solo está disponible para ser descargado directamente desde GitHub.

1. Clona el repositorio:
   ```bash
   git clone https://github.com/mmrasteu/rabbit-framework.git
   ```

2. Accede a la carpeta del proyecto:
   ```bash
   cd rabbit-framework
   ```

3. Incluye los archivos del framework en tu proyecto PHP o configura el autoload según tus necesidades.

### Notas

> Rabbit no es instalable actualmente mediante Composer. Planeamos integrar Composer en versiones posteriores.

> Las versiones betas no son recomendables para un desarrollo seguro. Estan publicadas para poder ser estudiadas y para aceptar colaboraciones.

## Características

[Ver Changelog](./CHANGELOG.md)

## Uso

### Rutas y grupos

Ejemplo básico de definición de rutas:

```php
//Se añade la ruta /auth al grupo que usa el prefijo /api
Router::group(['prefix' => '/api', 'middlewares' => []], function () {
    Router::POST('/auth', ['AuthController', 'getBearerToken']);
});
```

### Middleware

Puedes agregar middleware en tu aplicación para validar tokens, manejar autenticación o realizar otras tareas. Se asignan a grupos de rutas.

Ejemplo de uso de Middlewares:
```php
//Se pueden definir varios grupos con el mismo prefijo. A este grupo se le añade el middleware `BearerTokenMiddleware`
Router::group(['prefix' => '/api', 'middlewares' => ['BearerTokenMiddleware']], function () {
    Router::GET('/status', ['StatusController', 'getStatus']);
});
```

### Respuestas

Ejemplo de cómo usar las respuestas con código de estado. Estas respuestas se pueden customizar.

```php
. . . 
// Se obtiene el valor de los parametros. En este caso del parametro 'id'
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

### Validation Rules

#### **Email**
Valida si el valor es una dirección de correo electrónico válida.

#### **Numeric**
Valida si el valor es un número. Acepta cualquier tipo de valor numérico, incluyendo enteros y flotantes.

#### **Date**
Valida si el valor es una fecha válida según el formato dado (por ejemplo, 'Y-m-d'). El formato por defecto se especifica en la variable de entorno `DEFAULT_DATETIME_FORMAT`

#### **Boolean**
Valida si el valor es un valor booleano (`true` o `false`), o si es una cadena que representa un valor booleano (como "true", "false").

#### **Array**
Valida si el valor es un array.

#### **Url**
Valida si el valor es una URL válida.

#### **Alpha**
Valida si el valor contiene solo caracteres alfabéticos (letras, sin números ni símbolos).

#### **AlphaNumeric**
Valida si el valor contiene solo caracteres alfanuméricos (letras y números).

## Contribuir

Si deseas contribuir a Rabbit, por favor sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama (`git checkout -b feature/nueva-caracteristica`).
3. Realiza tus cambios y haz commit de ellos.
4. Envía un pull request con una descripción clara de los cambios.

## Licencia

Este proyecto está bajo la Licencia MIT - consulta el archivo [LICENSE](LICENSE) para más detalles.

## Contacto

Puedes ponerte en contacto conmigo a través de [contacto@phprabbit.es] para cualquier pregunta o sugerencia.

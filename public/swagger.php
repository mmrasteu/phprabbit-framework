<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentación API</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.14.0/swagger-ui.min.css">
  </head>
  <body>
    <div id="swagger-ui"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.14.0/swagger-ui-bundle.min.js"></script>
    <script>
      const ui = SwaggerUIBundle({
        url: "swagger.json",  // Ruta relativa al mismo directorio de doc.php
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIBundle.SwaggerUIStandalonePreset  // Mantén este preset
        ]
        // Eliminar la opción de layout para que use el predeterminado
      });
    </script>
  </body>
</html>

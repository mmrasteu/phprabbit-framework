<?php

function _t($msgid) {
    // Obtener el idioma activo
    $locale = setlocale(LC_ALL, 0); // Obtener el idioma actual configurado (retorna el locale)

    $default_locale = 'en_US';

    // Intentar obtener la traducción
    $translated = _($msgid);
    
    // Solo registrar el error si la traducción no se encuentra y el idioma no es el idioma base
    if ($translated === $msgid && $locale !== $default_locale) {
        // Registrar un mensaje en el log indicando que falta la traducción
        rabbit_debug("Translation not found for: '$msgid' in language '$locale'");
    }

    // Retornar la traducción (o el mensaje original si no se encontró)
    return $translated;
}

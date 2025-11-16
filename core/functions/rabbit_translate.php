<?php
use Rabbit\Core\i18n;

function _t($key, $params = []) {
    $msg = i18n::get($key);

        // Detectar tipo de mensaje por la key
    $color = "\033[0m"; // default
    if (str_starts_with($key, 'console.success')) {
        $color = "\033[32m"; // verde
    } elseif (str_starts_with($key, 'console.error')) {
        $color = "\033[31m"; // rojo
    } elseif (str_starts_with($key, 'console.warning')) {
        $color = "\033[33m"; // amarillo
    }

    $reset = "\033[0m";
    if (str_starts_with($key, 'console.')){
        $reset .= "\n";
    }

    return $color . replaceParams($msg, $params) . $reset;
}

function replaceParams(string $msg, array $values): string
{
    $pattern = '/%([a-zA-Z0-9_]+)%/';
    $index   = 0;

    return preg_replace_callback($pattern, function($m) use (&$values, &$index) {
        if (isset($values[$index])) {
            $replacement = (string) $values[$index];
            $index++;
            return $replacement;
        }

        return $m[0]; // Se deja tal cual si no hay valores
    }, $msg);
}
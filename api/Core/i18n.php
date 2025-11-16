<?php

namespace Rabbit\Core;

class i18n
{
    protected static string $langDir  = BASE_PATH . '/core/i18n';
    protected static string $locale   = APP_LOCALE; 
    protected static string $fallback = 'en_EN';
    protected static bool   $devMode  = I18N_DEV_MODE;
    protected static array  $cache    = [];

    public static function setLocale(string $locale): void
    {
        self::$locale = $locale;
    }

    public static function setFallback(string $fallback): void
    {
        self::$fallback = $fallback;
    }

    public static function setDevMode(bool $dev): void
    {
        self::$devMode = $dev;
    }

    public static function get(string $key): string
    {
        // 1. Buscar en el idioma actual
        $current = self::load(self::$locale);
        $value = self::resolveNamespace($current, $key);

        if ($value !== null) {
            return $value;
        }

        self::warn("[i18n] Missing key '$key' in locale ".self::$locale);

        // 2. Buscar en fallback
        $fallback = self::load(self::$fallback);
        $value = self::resolveNamespace($fallback, $key);

        if ($value !== null) {
            return $value;
        }

        self::warn("[i18n] Missing key '$key' in fallback locale ".self::$fallback);

        // 3. Nada encontrado → devolver mensaje genérico
        return "Translation not found";
    }

    /**
     * Carga un archivo JSON y lo cachea.
     */
    protected static function load(string $locale): array
    {
        $file = self::$langDir . '/' . $locale . '.json';

        if (isset(self::$cache[$file])) {
            return self::$cache[$file];
        }

        if (!file_exists($file)) {
            self::warn("[i18n] Missing language file: $file");
            self::$cache[$file] = [];
            return [];
        }

        $content = file_get_contents($file);
        $decoded = json_decode($content, true);

        if (!is_array($decoded)) {
            self::warn("[i18n] Invalid JSON in file: $file");
            self::$cache[$file] = [];
            return [];
        }

        self::$cache[$file] = $decoded;
        return $decoded;
    }

    /**
     * Permite usar namespaces tipo "auth.login.failed"
     */
    protected static function resolveNamespace(array $array, string $key): ?string
    {
        // Si no contiene namespace, usar clave directa
        if (strpos($key, '.') === false) {
            return $array[$key] ?? null;
        }

        $parts = explode('.', $key);
        $value = $array;

        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                return null; // namespace no encontrado
            }
            $value = $value[$part];
        }

        return is_string($value) ? $value : null;
    }

    /**
     * Mostrar warnings solo si devMode = true
     */
    protected static function warn(string $message): void
    {
        if (self::$devMode) {
            trigger_error($message, E_USER_WARNING);
        }
    }
}

<?php

namespace Rabbit\CLI\Commands;

use Rabbit\CLI\Commands\Command;

class i18nCommand extends Command
{
    private string $i18nDir = BASE_PATH. '/core/i18n';

    public function handleI18nCommand($type, $name, $arrayOptions)
    {
        $addLang = false;
        $addSection = false;
        switch($type) {
            case "addLang":
                if($name == '') {
                    $this->argumentException("Es necesario proporcionar un codigo de idioma");
                }
                $addLang = true;
                break;
            case "addSection":
                if($name == '') {
                    $this->argumentException("Es necesario proporcionar un nombre de sección");
                }      
                $addSection = true;
                break;    
            default:
                rabbit_debug("Parametro invalido", true);
                $this->argumentException("Parametro invalido");
                break;
        }

        if ($addLang && $addSection) {
            $this->argumentException("Error: Solo se puede usar un comando a la vez (addLang o --addSection).");
        }

        if (!$addLang && !$addSection) {
            $this->argumentException("Error: Debes indicar un comando (addLang o addSection).");
        }

        // -------------------------
        // Comando: addLang
        // -------------------------
        if ($addLang) {
            $newLang = $name;
            $copyFrom = null;

            // Opcional: copiar desde otro idioma
            if (array_key_exists('copyFrom', $arrayOptions)) {
                $copyFrom = $arrayOptions['copyFrom'];

                if (empty($copyFrom)) {
                    $this->argumentException("Error: Debes indicar un idioma válido después de --copyFrom.");
                }

                // Si viene como array, debe tener solo un elemento
                if (is_array($copyFrom) && count($copyFrom) > 1) {
                    $this->argumentException("Error: Solo se puede copiar desde un idioma, no desde múltiples.");
                }

                // Si viene como array, tomar el primer valor
                if (is_array($copyFrom)) {
                    $copyFrom = $copyFrom[0];
                }

                // Verificar que el archivo JSON exista
                $copyFile = $this->i18nDir . '/' . $copyFrom . '.json';
                if (!file_exists($copyFile)) {
                    $this->argumentException("Error: El idioma a copiar ('$copyFrom') no existe en la carpeta i18n.");
                }
            }

            // Llamada al método interno
            $this->addLanguage($newLang, $copyFrom);
            return;
        }

        // -------------------------
        // Comando: addSection
        // -------------------------
        if ($addSection) {
            // Llamada al método interno
            $this->addSection($name);
            return;
        }
    }

    /**
     * Añade un idioma
     * 
     * @param string $langName nombre del idioma a crear (ej: es_ES)
     * @param string|null $copyFrom idioma a copiar (ej: en_US)
     * @return void
     */
    public function addLanguage(string $langName, ?string $copyFrom = null): void
    {   
        // 1. Validar formato: xx_XX
        if (!preg_match('/^[a-z]{2}_[A-Z]{2}$/', $langName)) {
            echo "Error: El nombre de idioma debe tener formato xx_XX\n";
            echo $langName;
            return;
        }

        // 2. Crear ruta del archivo
        $filePath = $this->i18nDir . '/' . $langName . '.json';

        if (file_exists($filePath)) {
            echo "Error: El idioma $langName ya existe\n";
            return;
        }

        // 3. Generar contenido
        if ($copyFrom) {
            $copyFile = $this->i18nDir . '/' . $copyFrom . '.json';
            if (!file_exists($copyFile)) {
                echo "Error: El idioma a copiar ($copyFrom) no existe\n";
                return;
            }

            $baseStructure = json_decode(file_get_contents($copyFile), true);
            if (!is_array($baseStructure)) {
                echo "Error: El JSON a copiar está corrupto\n";
                return;
            }

            // Vaciar solo los valores recursivamente, manteniendo las claves
            $newContent = $this->emptyValuesRecursive($baseStructure);
        } else {
            // Estructura base vacía
            $newContent = $this->getBaseStructure();
        }

        // 4. Guardar archivo
        file_put_contents($filePath, json_encode($newContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo "Idioma $langName creado correctamente.\n";
    }

    /**
     * Devuelve la estructura base del JSON
     */
    private function getBaseStructure(): array
    {
        return [
            "generic" => ["success" => [], "error" => [], "warning" => [], "info" => []],
            "console" => ["success" => [], "error" => [], "warning" => [], "info" => []],
            "router"  => ["success" => [], "error" => [], "warning" => [], "info" => []],
            "log"     => ["success" => [], "error" => [], "warning" => [], "info" => []],
            "database"=> ["success" => [], "error" => [], "warning" => [], "info" => []],
            "test"    => ["success" => [], "error" => [], "warning" => [], "info" => []],
        ];
    }

    /**
     * Recursivamente vacía los valores de un array asociativo, dejando las claves intactas
     */
    private function emptyValuesRecursive(array $array): array
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $this->emptyValuesRecursive($value);
            } else {
                $array[$key] = "";
            }
        }
        return $array;
    }

    /**
     * Añade una nueva sección a uno o varios JSON de idiomas
     *
     * @param string $sectionName Nombre de la sección a añadir
     * @return void
     */
    public function addSection(string $sectionName): void
    {
        $filesToUpdate = [];

        // Tomamos todos los JSON de la carpeta
        $allFiles = glob($this->i18nDir . '/*.json');
        if (empty($allFiles)) {
            echo "Error: No hay archivos de idiomas en la carpeta {$this->i18nDir}\n";
            return;
        }
        $filesToUpdate = $allFiles;

        // Estructura base de la nueva sección
        $newSection = [
            "success" => [],
            "error" => [],
            "warning" => [],
            "info" => []
        ];

        // Añadir sección a cada JSON
        foreach ($filesToUpdate as $file) {
            $content = json_decode(file_get_contents($file), true);
            if (!is_array($content)) {
                echo "Warning: El archivo $file está corrupto, se omitirá.\n";
                continue;
            }

            // Solo añadir si no existe la sección
            if (!array_key_exists($sectionName, $content)) {
                $content[$sectionName] = $newSection;
                file_put_contents($file, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                echo "Sección '$sectionName' añadida a " . basename($file) . "\n";
            } else {
                echo "Warning: La sección '$sectionName' ya existe en " . basename($file) . "\n";
            }
        }
    }
}

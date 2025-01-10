<?php 

namespace Rabbit\Validate\ValidationRules;

use Rabbit\Http\Response;
use Rabbit\Interfaces\ValidationRulesInterface;

class Datetime implements ValidationRulesInterface {

  protected $response;

  private $format;

  /**
     * Setter para $format
     *
     * @param string $format
     * @throws InvalidArgumentException Si el formato no es válido
     */
    public function setFormat(string $format): void
    {
        if (!$this->isValidFormat($format)) {
            throw new InvalidArgumentException("El formato proporcionado '$format' no es válido.");
        }
        $this->format = $format;
    }

  /**
     * Getter para $format
     *
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

  public function __construct(Response $response, $format=null) {
    try {
      if(is_null($format)) {
        $format = DEFAULT_DATETIME_FORMAT;
      }

      setFormat($format);

    } catch(Exception $e) {
      $this->response->withStatus400($e->getMessage());
    }
  }

  public function validate(mixed $value): bool {

    $dt = DateTime::createFromFormat($this->format, $date);
    return $dt && $dt->format($format) === $date;
  }

  public function getMessage(): string{
    return "This value is not a valid datetime";
  }

  private function isValidDateFormat(string $format): bool {
    try {
        // Intentamos usar un formato de prueba para detectar errores
        $testDate = '2024-12-23 12:34:56.123456'; // Fecha de prueba genérica
        $dt = DateTime::createFromFormat($format, $testDate);
        $errors = DateTime::getLastErrors();

        if ($dt === false || !empty($errors['errors'])) {
            throw new InvalidArgumentException("El formato proporcionado '$format' no es válido.");
        }
        return true;
    } catch (Exception $e) {
        throw new InvalidArgumentException("Error al validar el formato: " . $e->getMessage());
    }
  }

}
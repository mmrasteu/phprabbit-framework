<?php

namespace Rabbit\Interfaces;

interface ValidationRulesInterface {
  /**
   * Valida el dato entrada
   *
   * @param mixed Dato a validar 
   * @return bool Devuelve si la validación es correcta o no
   */
  public function validate(mixed $value): bool;

  /**
   * Devuelve el mensaje correspondiente a la validación
   *
   * @return string Mensaje de la validación
   */
  public function getMessage(): string;

}
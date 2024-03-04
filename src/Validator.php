<?php

namespace Yi\Argus;

class Validator
{
  /**
   * Validates data against a set of rules
   *
   * @param array $data The data to validate
   * @param array $rules An associative array of field names and validation rules
   *
   * @return array An array containing validation errors or empty if valid
   */
  public function validate(array $data, array $rules): array
  {
    $errors = [];

    foreach ($rules as $field => $validations) {
      foreach ($validations as $validation) {
        $params = explode(':', $validation);
        $validationName =array_shift($params);

        if (!$this->$validationName($data[$field], ...$params)) {
          $errors[$field][] = ucfirst($validationName) . ' validation failed.';
        }
      }
    }

    return $errors;
  }

  /**
   * Checks if a value is required
   *
   * @param mixed $value The value to check
   *
   * @return bool True if value is not empty, False otherwise
   */
  private function required($value): bool
  {
    return isset($value) && !empty($value);
  }

  /**
   * Checks if a value is a valid email address
   *
   * @param mixed $value The value to check
   *
   * @return bool True if value is a valid email, False otherwise
   */
  private function email($value): bool
  {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
  }

  /**
   * Checks if a value is a string
   *
   * @param mixed $value The value to check
   *
   * @return bool True if value is a string, False otherwise
   */
  private function string($value): bool
  {
    return is_string($value);
  }

  /**
   * Checks if a value is a number
   *
   * @param mixed $value The value to check
   *
   * @return bool True if value is numeric, False otherwise
   */
  private function numeric($value): bool
  {
    return is_numeric($value);
  }

  /**
   * Checks if the value length is within a specific range
   *
   * @param mixed $value The value to check
   * @param int $min The minimum allowed length (optional)
   * @param int $max The maximum allowed length (optional)
   *
   * @return bool True if value length is within range, False otherwise
   */
  private function length($value, int $min = null, int $max = null): bool
  {
    $length = strlen($value);
    if ($min !== null && $length < $min) {
      return false;
    }
    if ($max !== null && $length > $max) {
      return false;
    }
    return true;
  }

  /**
   * Checks if a number is within a specific range
   *
   * @param mixed $value The value to check
   * @param int $min The minimum allowed value (optional)
   * @param int $max The maximum allowed value (optional)
   *
   * @return bool True if value is within range, False otherwise
   */
  private function between($value, int $min = null, int $max = null): bool
  {
    if (!is_numeric($value)) {
      return false;
    }
    $numericValue = (float) $value;
    if ($min !== null && $numericValue < $min) {
      return false;
    }
    if ($max !== null && $numericValue > $max) {
      return false;
    }
    return true;
  }
}

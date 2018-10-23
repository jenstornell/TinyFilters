<?php
class TinyValidators {
  function exists($value) {
    return $value !== null;
  }
  function equals($value, $match) {
    return $value === $match;
  }

  // Is type
  function isString($value) {
    return is_string($value);
  }
  function isInteger($value) {
    return is_int($value);
  }
  function isNumeric($value) {
    return is_numeric($value);
  }
  function isFloat($value) {
    return is_float($value);
  }
  function isArray($value) {
    return is_array($value);
  }
  function isObject($value) {
    return is_object($value);
  }
  function isBoolean($value) {
    return is_boolean($value);
  }

  // Max min
  function max($value, $match) {
    return !is_numeric($value) ? false : (int)$value <= $match;
  }
  function min($value, $match) {
    return !is_numeric($value) ? false : (int)$value >= $match;
  }

  // In array
  function in($value, $match) {
    if(!$this->isArray($value)) return false;
    return in_array($match, $value);
  }

  // Contains
  function contains($value, $match) {
    return strpos($value, $match) !== false ? true : false;
  }

  // Between
  function between($value, $match) {
    $min = $this->min($value, $match[0]);
    $max = $this->max($value, $match[1]);

    return ($min && $max) ? true : false;
  }
}
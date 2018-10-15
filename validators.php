<?php
class TinyValidators {
  function has($array, $key) {
    return array_key_exists($key, $array);
  }
  function exists($array, $key) {
    if(!$this->has($array, $key)) return false;
    return $array[$key] !== null;
  }
  function equals($array, $key, $value) {
    $array[$key] = isset($array[$key]) ? $array[$key] : null;
    return $array[$key] === $value;
  }

  // Is
  function isString($array, $key) {
    if(!$this->exists($array, $key)) return false;
    return is_string($array[$key]);
  }
  function isNumber($array, $key) {
    if(!$this->exists($array, $key)) return false;
    return gettype($array[$key]) === 'integer';
  }

  // Max min
  function max($array, $key, $value) {
    if(!$this->isNumber($array, $key)) return false;
    return ($array[$key] <= $value);
  }
  function min($array, $key, $value) {
    if(!$this->isNumber($array, $key)) return false;
    return ($array[$key] >= $value);
  }

  // In array
  function in($array, $key, $value) {
    if(!$this->exists($array, $key)) return false;
    if(!is_array($array[$key])) return false;
    return in_array($value, $array[$key]);
  }
}
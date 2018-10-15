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
    if(!$this->isArray($array, $key)) return false;
    return in_array($value, $array[$key]);
  }

  // Is array
  function isArray($array, $key) {
    if(!$this->exists($array, $key)) return false;
    return is_array($array[$key]);
  }

  // Contains
  function contains($array, $key, $value) {
    if(!$this->exists($array, $key)) return false;
    
    if(strpos($array[$key], $value) !== false) return true;
    return false;
  }

  // Between
  function between($array, $key, $params) {
    if(!$this->exists($array, $key)) return false;

    $min = $this->min($array, $key, $params[0]);
    $max = $this->max($array, $key, $params[1]);

    if($min && $max) return true;
    return false;
  }
}
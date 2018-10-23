<?php
class TinyFilters {
  public $settings;
  public $validators;
  public $results;

  function __construct() {
    if(class_exists('TinyValidators')) {
      $this->validators['default'] = new TinyValidators();
    }
  }
  function validate($array) {
    if(empty($this->settings)) return true;

    foreach($this->settings as $this->key => $items) {
        $this->item($items, $this->key, $array);
    }

    $result = $this->result();
    unset($this->results);
    return $result;
  }

  function item($settings, $key, $array) {
    foreach($settings as $params) {
      if(!array_key_exists($key, $array)) {
        $validated = false;
      } else {
        $validated = $this->validated($array[$key], $params['vname'], $params['args']);
      }
      $this->results[] = $this->invert($validated, $params['positive']);
    }
  }

  function result() {
    $result = in_array(false, $this->results) ? false : true;
    unset($this->settings);
    return $result;
  }

  function validated($value, $vname, $args) {
    if(!empty($this->validators)) {
      foreach($this->validators as $validator) {
        if(method_exists($validator, $vname)) return $validator->{$vname}($value, $args);
      }
    }
  }

  function invert($result, $positive) {
    return $positive ? $result : !$result;
  }

  function addValidators($object) {
    $this->validators[] = $object;
  }

  function vname($validator) {
    return strtok($validator, '!');
  }

  function positive($validator, $vname) {
    return $validator === $vname;
  }

  function add($key, $validator = null, $args = null) {
    if(is_string($key)) $this->addSingle($key, $validator, $args);
  }

  function addSingle($key, $validator, $args) {
    $vname = $this->vname($validator);

    $this->settings[$key][] = [
      'key' => $key,
      'vname' => $vname,
      'positive' => $this->positive($validator, $vname),
      'args' => $args,
    ];
  }
}
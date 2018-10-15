<?php
class TinyFilter {
  public $validators;
  public $settings;

  function __construct() {
    $this->Validators = new TinyValidators();
  }
  function validate($array) {
    if(isset($this->settings)) {
      foreach($this->settings as $key => $items) {
        foreach($items as $args) {
          $validator = $this->validator($args);
          $positive = $this->positive($validator, $args);
          
          $result = $this->Validators->{$validator}($array, $key, $args['args']);
          $result = $positive ? $result : !$result;

          if(!$result) return false;
        }
      }
      return true;
    }
    return false;
  }

  function validator($args) {
    return strtok($args['validator'], '!');
  }

  function positive($validator, $args) {
    return ($validator == $args['validator']);
  }

  function add($key, $validator = null, $args = null) {
    if(is_string($key)) $this->addSingle($key, $validator, $args);
  }

  function reset() {
    unset($this->settings);
  }

  function addSingle($key, $validator, $args) {
    $this->settings[$key][] = [
      'key' => $key,
      'validator' => $validator,
      'args' => $args,
    ];
  }
}
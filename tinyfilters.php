<?php
class TinyFilters {
  public $settings;
  public $validators;

  function __construct() {
    $this->validators['default'] = new TinyValidators();
  }
  function validate($array) {
    $result = false;
    if(isset($this->settings)) {
      foreach($this->settings as $key => $items) {
        foreach($items as $settings) {
          $vname = $this->validator($settings);

          if(!$this->validators['default']->has($key, $array)) {
            $result = $this->invert($result, $vname, $settings);
            continue;
          }
          
          foreach($this->validators as $validator) {
            if(!method_exists($validator, $vname)) continue;

            $result = $validator->{$vname}($array[$key], $settings['args']);
          }

          $result = $this->invert($result, $vname, $settings);
        }
      }
    }
    return $result;
  }

  function invert($result, $vname, $settings) {
    return $this->positive($vname, $settings) ? $result : !$result;
  }

  function addValidators($object) {
    $this->validators[] = $object;
  }

  function validator($args) {
    return strtok($args['validator'], '!');
  }

  function positive($validator, $args) {
    return $validator === $args['validator'];
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
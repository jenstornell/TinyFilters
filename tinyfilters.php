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
          if($this->validators['default']->has($key, $array, $settings['positive'])) {
            foreach($this->validators as $validator) {
              if(method_exists($validator, $settings['vname'])) {
                $result = $validator->{$settings['vname']}($array[$key], $settings['args']);
              }
            } 
          }
          return $this->invert($result, $settings);
        }
      }
    }
    return $result;
  }

  function invert($result, $settings) {
    return $settings['positive'] ? $result : !$result;
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

  function reset() {
    unset($this->settings);
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
<?php
$issues = [];

// Multiple
// Multiple keys
$filter = new TinyFilter();
$filter->add('first', 'isString');
$filter->add('first', 'equals', 'aaa');
$filter->add('second', 'isString');
$filter->add('second', '!equals', 'bbb');

// Multiple positive
$array = [
  'first' => 'aaa',
  'second' => 'ccc',
];

if(!$filter->validate($array)) $issues[] = 'Multiple - Should be positive';

// Multiple negative
$array = [
  'first' => 'aaa',
  'second' => 'bbb',
];
if($filter->validate($array)) $issues[] = 'Multiple - Should be negative';

// Reset
$filter = new TinyFilter();
$filter->add('first', 'isString');
$filter->reset();
$array = [
  'first' => 'aaa',
];
if($filter->validate($array)) $issues[] = 'Reset';

// VALIDATORS
$filter = new TinyFilter();

// Has
$filter->add('first', 'has');
$filter->add('second', 'has');
//$filter->add('third', '!has');
$array = [
  'first' => 'aaa',
  'second' => null,
];
if(!$filter->validate($array)) $issues[] = 'Has';
$filter->reset();

// Exists
$filter->add('first', 'exists');
$filter->add('second', '!exists');
$filter->add('third', 'exists');
$filter->add('fourth', 'exists');
$filter->add('fifth', '!exists');
$array = [
  'first' => 'aaa',
  'second' => null,
  'third' => false,
  'fourth' => ['an' => 'array']
];
if(!$filter->validate($array)) $issues[] = 'Exists';
$filter->reset();

// Equals
$filter->add('first', 'equals', 'aaa');
$filter->add('second', '!equals', 'bbb');
$filter->add('third', 'equals', false);
$filter->add('fourth', 'equals', null);
$filter->add('fifth', 'equals', null);
$array = [
  'first' => 'aaa',
  'second' => 'ccc',
  'third' => false,
  'fourth' => null,
];
if(!$filter->validate($array)) $issues[] = 'Equals';
$filter->reset();

// isString
$filter->add('first', 'isString');
$filter->add('second', 'isString');
$filter->add('third', '!isString');
$filter->add('fourth', '!isString');
$filter->add('fifth', '!isString');
$array = [
  'first' => 'aaa',
  'second' => '',
  'third' => false,
  'fourth' => null,
];
if(!$filter->validate($array)) $issues[] = 'isString';
$filter->reset();

// isArray
$filter->add('first', 'isArray');
$filter->add('second', 'isArray');
$filter->add('third', '!isArray');
$filter->add('fourth', '!isArray');
$array = [
  'first' => ['hello' => 'world'],
  'second' => [],
  'third' => false,
];
if(!$filter->validate($array)) $issues[] = 'isArray';
$filter->reset();

// isNumber
$filter->add('first', 'isNumber');
$filter->add('second', 'isNumber');
$filter->add('third', '!isNumber');
$filter->add('fourth', '!isNumber');
$filter->add('fifth', '!isNumber');
$array = [
  'first' => 42,
  'second' => 0,
  'third' => false,
  'fourth' => null,
];
if(!$filter->validate($array)) $issues[] = 'isNumber';
$filter->reset();

// max
$filter->add('first', 'max', 100);
$filter->add('second', 'max', 100);
$filter->add('third', '!max', 100);
$filter->add('fourth', '!max', 100);
$filter->add('fifth', '!max', 100);
$array = [
  'first' => 1,
  'second' => 100,
  'third' => 101,
  'fourth' => 'string',
];
if(!$filter->validate($array)) $issues[] = 'max';
$filter->reset();

// min
$filter->add('first', 'min', 100);
$filter->add('second', 'min', 100);
$filter->add('third', '!min', 100);
$filter->add('fourth', '!min', 100);
$filter->add('fifth', '!min', 100);
$array = [
  'first' => 200,
  'second' => 100,
  'third' => 1,
  'fourth' => 'string',
];
if(!$filter->validate($array)) $issues[] = 'min';
$filter->reset();

// between
$filter->add('first', 'between', [100, 200]);
$filter->add('second', 'between', [100, 200]);
$filter->add('third', 'between', [100, 200]);
$filter->add('fourth', '!between', [100, 200]);
$filter->add('fifth', '!between', [100, 200]);
$filter->add('sixth', '!between', [100, 200]);
$array = [
  'first' => 150,
  'second' => 100,
  'third' => 200,
  'fourth' => 201,
  'fifth' => 49,
  'sixth' => false,
];
if(!$filter->validate($array)) $issues[] = 'between';
$filter->reset();

// in
$filter->add('first', '!in', 'hello');
$filter->add('second', 'in', 'hello');
$filter->add('third', '!in', 'hello');
$array = [
  'first' => 'string',
  'second' => ['hello', 'world'],
  'third' => ['something', 'else'],
];
if(!$filter->validate($array)) $issues[] = 'in';
$filter->reset();

// Contains
$filter->add('first', 'contains', 'ello');
$filter->add('second', 'contains', 'ello');
$filter->add('third', '!contains', 'ello');
$array = [
  'first' => 'hello',
  'second' => 'ello',
  'third' => 'world',
];
if(!$filter->validate($array)) $issues[] = 'contains';
$filter->reset();

// Custom Validators
class CustomValidators {
  function test($array, $key, $value) {
    return ($array[$key] == $value);
  }
}

$CustomValidators = new CustomValidators();

$filter->addValidators($CustomValidators);
$filter->add('first', 'test', 'hello');
$array = [
  'first' => 'hello'
];

if(!$filter->validate($array)) $issues[] = 'Custom validators';

print_r($issues);
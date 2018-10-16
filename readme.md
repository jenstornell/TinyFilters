# TinyFilter

*Version: 1.0*

TinyFilter is perhaps the smallest PHP filter library on earth. Still packed with features.

## Why another filter/validator library?

- A very small library, yet powerful.
- Only 2 files needs to be included.
- Really simple syntax.
- Made for large nested arrays in mind.
- Add your own custom validators, or use the default ones.

## Setup

```php
include __DIR__ . '/tinyfilter.php';
include __DIR__ . '/validators.php';
```

## Basic usage

```php
$filter = new TinyFilter();

$filter->add('first',  'between', [0, 100];
$filter->add('first',  'equals',  50;
$filter->add('second', 'isString');

$array['first']  = 50;
$array['second'] = 'Hello world';

var_dump($filter->validate($array));
```

## Advanced example

A more advanced example. If page `root` is not equal to `true`, remove the page from the array.

```php
$filter->add('root', '!equals', true);

$pages = [
  'home' => [
    'title' => 'Home',
    'root'  => true
  ],
  'about' => [
    'title' => 'About'
  ]
];

foreach($pages as $page => $array) {
  if($filter->validate($array))
    unset($pages[$page]);
}

print_r($pages);
```

**The code above will give:**

```php
$pages = [
  'home' => [
    'title' => 'Home',
    'root'  => true
  ],
];
```

## Validators

There are some built in validators that can be used.

- Before the examples below you need `$filter = new TinyFilter();`. 
- After the examples below you need `$results = $filter->validate($array);`.
- All the examples below will return `true` from the `$results`.

### in

The `in` validator takes a string as third argument and tries to find a match in the array.

```php
$filter->add('my_key', 'in', 'world');

$array['my_key'] = ['hello', 'world'];
```

### exists

It will return `true` if the array key is not `null`.

```php
$filter->add('my_key', 'exists');

$array['my_key'] = false;
```

### equals

It will return `true` if an equal match is found. It also needs to be of equal type.

```php
$filter->add('my_key', 'equals', 'hello');

$array['my_key'] = 'hello';
```

### isString

It will return `true` if the value is a string.

```php
$filter->add('my_key', 'isString');

$array['my_key'] = 'hello';
```

### isNumber

It will return `true` if the value is a number and an integer.

```php
$filter->add('my_key', 'isNumber');

$array['my_key'] = 100;
```

### min

It will return `true` if the value is larger than the third argument.

```php
$filter->add('my_key', 'min', 10);

$array['my_key'] = 100;
```

### max

It will return `true` if the value is smaller than the third argument.

```php
$filter->add('my_key', 'max', 100);

$array['my_key'] = 10;
```

## Custom validators

To create custom validators you need to create a class

```php
class CustomValidators {
  function test($value, $match) {
    return $value == $match;
  }

  function another($value, $match) {
    return true;
  }
}

$CustomValidators = new CustomValidators();

$filter->addValidators($CustomValidators);

$filter->add('first', 'test', 'hello');

$array['first'] = 'hello';
```

## Donate

Donate to [DevoneraAB](https://www.paypal.me/DevoneraAB) if you want.

## Additional notes

- To keep it dead simple, namespaces are not used.

## Requirements

- PHP 7

## License

[MIT](license)
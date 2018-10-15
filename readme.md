# TinyFilter

*Version: 1.0*

TinyFilter is perhaps the smallest PHP filter library on earth. Still packed with features.

## Setup

```php
include __DIR__ . '/tinyfilter.php';
include __DIR__ . '/validators.php';
```

## Basic usage

1. Create an object from the `TinyFilter` class
1. Add filter rules
1. Add a associative array with key/value pairs
1. Validate if the result is `true` or `false`

```php
$filter = new TinyFilter();

$filter->add('first', 'min', 0);
$filter->add('first', 'max', 100);
$filter->add('second', 'isString');

$array = [
  'first' => 50,
  'second' => 'Hello world'
];

$results = $filter->validate($array);

var_dump($results);
```

## Validators

There are some built in validators that can be used.

### in

The `in` validator takes a string as third argument and tries to find a match in the array.

```php
$filter->add('my_key', 'in', 'world');
$array = [
  'my_key' => ['hello', 'world']
];
```

*The code above will give `true`*

### has

It will check if the array key exists in the array.

```php
$filter->add('my_key', 'has');
$array = [
  'my_key' => 'something'
];
```

*The code above will give `true`*

### exists

It will return `true` if the array key is not `null`, else it will return `false`. It will also return `false` if the key does not exists.

```php
$filter->add('my_key', 'exists');
$array = [
  'my_key' => false
];
```

*The code above will give `true`*

### equals

It will return `true` if an equal match is found. It also needs to be of equal type.

```php
$filter->add('my_key', 'equals', 'hello');
$array = [
  'my_key' => 'hello'
];
```

*The code above will give `true`*

### isString

It will return `true` if the value is a string.

```php
$filter->add('my_key', 'isString');
$array = [
  'my_key' => 'hello'
];
```

*The code above will give `true`*

### isNumber

It will return `true` if the value is a number and an integer.

```php
$filter->add('my_key', 'isNumber');
$array = [
  'my_key' => 100
];
```

*The code above will give `true`*

### min

It will return `true` if the value is larger than the third argument.

```php
$filter->add('my_key', 'min', 10);
$array = [
  'my_key' => 100
];
```

*The code above will give `true`*

### max

It will return `true` if the value is smaller than the third argument.

```php
$filter->add('my_key', 'max', 100);
$array = [
  'my_key' => 10
];
```

*The code above will give `true`*

## Custom validators

To create custom validators you need to create a class

```php
class CustomValidators {
  function test($array, $key, $value) {
    return ($array[$key] == $value);
  }

  function another($array, $key, $value) {
    return true;
  }
}

$CustomValidators = new CustomValidators();

$filter->addValidator($CustomValidators);
$filter->add('first', 'test', 'hello');
$array = [
  'first' => 'hello'
];
```

## Donate

Donate to [DevoneraAB](https://www.paypal.me/DevoneraAB) if you want.

## Additional notes

- To keep it dead simple, namespaces are not used.

## Requirements

- PHP 7

## License

MIT
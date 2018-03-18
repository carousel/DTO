Simple DTO implementation in PHP (single process)
=

author: miroslav.trninic@gmail.com

Introduction
-
This small utility library is acting like real DTO object, that lives between two processes, but in PHP environment. It can be injected into controller or in some kind of middleware. It has couple of handy helper functions like camelize, only, except that converts input into more granular form.

Usage:
-
shell of composer.json

composer require carousel/dto

```php
<?php

use Carousel\DTO\DTOClass;

//mock request data (array)
$request = [
    'myUsername' => 'John Scofield',
    'my_timezone' => 'UTC+1'
];

//inject DTO in controller or middleware
public function __construct($request)
{
    $this->dto = new DTOClass($request);
}

//camelize input key
$camelized = $this->dto->camelize('my_timezone');

//camelize all input keys
$camelized = $this->dto->camelize();

//exclude data from input
$except = $this->dto->except(['myUsername']);

//get only subset of data from input
$only = $this->dto->only(['myUsername']);

//serialize input
$serialized = $this->dto->serialize();

//decamelize all request keys in DTO object
$request = $dto->decamelize();
$dto->request = $request;
//return one decamelized key
return json_encode($dto->my_username);
```

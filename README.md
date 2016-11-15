# slim-doctrine
Doctrine middleware for Slim Framework 3 (only tested on 3.5)

### Install

Composer (https://getcomposer.org)
```shell
composer require psykosoldi3r/slim-doctrine
```

### Usage

After installing `slim-doctrine` you will need to initialize it in your Slim Framework application.

#### Initialize Doctrine
```php
$doctrine = new \Slim\Middleware\Doctrine( \Slim\Container $container, array $configuration );
```
`$container` = Container for your Slim App<br/>
`$configuration` = Associative array

Example
```php
<?php

require 'vendor/autoload.php';

$container = new \Slim\Container;
$app = new \App\App( $container );

$doctrine = new \Slim\Middleware\Doctrine(
    $app->getContainer(),
    array(
        "dev_mode" => true,
        "entities" => [
            "paths" => ["src/App/Entity"]
        ],
        "connection" => [
            "driver"    => "pdo_mysql",
            "host"      => "127.0.0.1",
            "dbname"    => "slim_doctrine_demo",
            "user"      => "root",
            "password"  => "root"
        ]
    ));

$app->run();
```

#### Config
At this moment the following config is supported. More information can be found at: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/configuration.html
```
"dev_mode" => true/false,
"entities" => [
    "paths" => ["src/App/Entity", ...]
],
"connection" => [
    "driver"    => "pdo_mysql",
    "host"      => "127.0.0.1",
    "dbname"    => "slim_doctrine_demo",
    "user"      => "root",
    "password"  => "root"
]
```


#### Controllers

It's also possible to get access to the Entity Manager by extending your controllers with `\Slim\Middleware\DoctrineResource` class.
You can then easily gain access to the EntityManager by using `$this->getEntityManager()`

Example
```php
<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Middleware\DoctrineResource;

class QuestionController extends DoctrineResource
{
    public function __construct( ContainerInterface $ci ){
        parent::__construct( $ci );
    }
    
    public function exampleAction( ServerRequestInterface $request, ResponseInterface $response, $args ){
        $em = $this->getEntityManager();
    }
}
```

### Issue & Pull Request

Feel free to create new issue's on this repository for bugs, feature requests and questions.
Have you fixed any issue or something else related to this project, feel free to create a pull requests.

### Contact

For any other questions you can ask it to my on Twitter: [@JoeyNL](https://twitter.com/JoeyNL)
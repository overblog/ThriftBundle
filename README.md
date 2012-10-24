# OverBlog Thrift Bundle #

What is this repository ?
----------------------

This is a custom version of the Thrift protocol for PHP

Usefull links ?
----------------------

https://github.com/yuxel/thrift-examples

http://svn.apache.org/repos/asf/thrift/trunk/

Getting the bundle
------------------
### The Symfony 2.0.X way

Install the Thrift library
```
# deps
[OverblogThrift]
    git=git://github.com/apache/thrift.git
    target=/thrift
```
``` php
// app/autoload.php
$loader->registerNamespaces(array(
    ...
    'Thrift'           => __DIR__.'/../vendor/apache-thrift/lib/php/lib',
));
```

Install OverblogThriftBundle
```
# deps
[OverblogThriftBundle]
    git=git@github.com:ebuzzing/OverblogThriftBundle.git
    target=/bundles/Overblog/ThriftBundle
```
```php
// app/autoload.php
$loader->registerNamespaces(array(
    ...
    'Overblog'         => __DIR__.'/../vendor/bundles',
));
```
### The Symfony 2.1.X way

Update your composer json with this new dependency into the "require" section.
```json
// composer.json
"require": {
    "php": ">=5.3.3",
    "symfony/symfony": "2.1.*",
    ...
    "overblog/thrift-bundle": "dev-master" // insert this line
}
```

And then run ```composer update```

Setting up the bundle
---------------------

Let's start by registering the bundle into the AppKernel
```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        ...
        new Overblog\ThriftBundle\OverblogThriftBundle(),
        ...
    );

    return $bundles;
}
```

You can now create your Service.thrift file and place it in a ThriftDefinition directory, in your own bundle.

For example: MyNameSpace/MyBundle/ThriftDefinition/Service.thrift

You need to configure the compiler to build the right files.

```yml
#app/config/config.yml
    services:
      *service_name*:
        definition: Service
        namespace: ThriftModel\Service
        bundleNameIn: MyBundle # Replace with your own bundle name
        server: true    # Define if server class will be generated
```

You are now able to generate the model with ```php app/console thrift:compile CompleteBundleName Service```

Model will be automatically generated on the cache warmup (```php app/console cache:warmup```) in your cache directory.

You can set in the option "protocol" too

To use server
----------------------

### 1) Create your handler (Extends Overblog\ThriftBundle\Api\Extensions\BaseExtension
    and Implements ThriftModel\Service\ServiceIf) and register it in your bundle:

```yml
#Bundle/Ressources/config/services.yml
    services:
      thrift.handler.service:
        class: BundleName\Handler\Service
        arguments: [@service_container]
        tags:
          -: { name: "thrift.extension" }

          # Tag thrift.extension is needed to be sure autoloaded will be
            loaded (for interface & classes)
```
### 2) Add the config server to your config.yml project:
```yml
#app/config/config.yml
    overblog_thrift:
      servers:
        *service_name*:
          service: *service_name*
          handler: thrift_api.processor.service
```

Note: You can set in the option "fork" too

### 4) If you wan't to use Thrift over HTTP Transport, register controller

    #app/config/routing.yml
        OverblogThriftBundle:
          resource: "@OverblogThriftBundle/Resources/config/routing.yml"
          prefix:   /

### 5) Or you can start the socket version with the command:

    php app/console thrift:server *service_name*

To use client
----------------------

### 1) HTTP Client: Add the config server to your config.yml project:

```yml
#app/config/config.yml
    clients:
      *client_name*:
        service: *service_name*:
        type: http
        hosts:
          comment:
            host: domain/thrift
            port: 80
```

### 2) Socket Client: Add the config server to yout config.yml project:

```yml
#app/config/config.yml
    clients:
      *client_name*:
        service: *service_name*:
        type: socket
        hosts:
          *host_name*:
            host: localhost
            port: 9090
```

### 3) Multi Socket Client: Add the config server to yout config.yml project:

```yml
#app/config/config.yml
    clients:
      *client_name*:
        service: *service_name*:
        type: socket
        hosts:
          *host_name*:
            host: localhost
            port: 9090
          *host_name_2*:
            host: localhost
            port: 9091
```

### 4) Then you can call the client:

```php
// your_controller.php

$service = $this->getContainer()->get('thrift.client.*client_name*');
$client = $service->getClient();

$service = $service->getFactory('ThriftModel\Service\Service');
$service->property = 121354984651354647;
$service->name = 'Name 1';

$id = $client->execMethod($service);
```

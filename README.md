# OverBlog Thrift Bundle #

What is this repository ?
----------------------

This is a custom version of the Thrift protocol for PHP

Usefull links ?
----------------------

@link https://github.com/yuxel/thrift-examples
@link http://svn.apache.org/repos/asf/thrift/trunk/

Installation and setup
----------------------

1) Install Overblog Thrift library

    #deps
        [OverblogThrift]
            git=git@github.com:ebuzzing/OverblogThrift.git
            target=/thrift
            version=v0.8.0

    #app/autoload.php
        $loader->registerNamespaces(array(
            ...
            'Thrift'           => __DIR__.'/../vendor/thrift',
        ));

2) Install OverblogThriftBundle
    #deps
        [OverblogThriftBundle]
            git=git@github.com:ebuzzing/OverblogThriftBundle.git
            target=/bundles/Overblog/ThriftBundle

    #app/autoload.php
        $loader->registerNamespaces(array(
            ...
            'Overblog'         => __DIR__.'/../vendor/bundles',
        ));

3) Create you Service.Thrift and add it in a "ThriftDefinition" directory in your bundle.

4) You can generate your Model with this command to test

    php app/console thrift:compile CompleteBundleName Service

Register the warmer command
----------------------

1) Add the compiler config to your config.yml project:

    #app/config/config.yml
        overblog_thrift:
          compiler:
            services:
              *service_name*:
                bundleNameIn: BundleWhereDefinitionAreStore
                bundleNameOut: BundleWhereModelWillbeStored
                server: true

(You can safely add *ThriftModel* to your git ignore)

To use server
----------------------

1) Create your handler (Implements the interface located in ThriftModel/Service/Client/ModelInterface.php) and register it in your bundle:

    #Bundle/Ressources/config/services.yml
        services:
          thrift.handler.service:
            class: BundleName\Handler\Service

2) Register your processor and inject the handler:

    #Bundle/Ressources/config/services.yml
        services:
          thrift_api.processor.service:
            class: BundleName\Model\Service\Processor\ServiceProcessor
            arguments: [@thrift.handler.service]

3) Add the config server to your config.yml project:

    #app/config/config.yml
        overblog_thrift:
          services:
            *service_name*:
              processor: thrift_api.processor.service

    You can set in the option "protocol" and "fork" too

4) If you wan't to use Thrift over HTTP Transport, register controller

    #app/config/routing.yml
        thrift_server:
          pattern:  /thrift
          defaults: { _controller: OverblogThriftBundle:Thrift:server, config: *service_name* }

5) Or you can start the socket version with the command:

    php app/console thrift:server *service_name*

To use client
----------------------

1) HTTP Client: Add the config server to yout config.yml project:

    #app/config/config.yml
        clients:
          *client_name*:
            client: BundleName\ThriftModel\Service\Client\ServiceClient
            type: http
            hosts:
              *host_name*:
                host: domain/thrift
                port: 80

2) Socket Client: Add the config server to yout config.yml project:

    #app/config/config.yml
        clients:
          *client_name*:
            client: BundleName\ThriftModel\Service\Client\ServiceClient
            type: socket
            hosts:
              *host_name*:
                host: localhost
                port: 9090

3) Multi Socket Client: Add the config server to yout config.yml project:

    #app/config/config.yml
        clients:
          *client_name*:
            client: BundleName\ThriftModel\Service\Client\ServiceClient
            type: socket
            hosts:
              *host_name*:
                host: localhost
                port: 9090
              *host_name_2*:
                host: localhost
                port: 9091

4) Then you can call the client:

    #your_controller.php

        $client = $this->getContainer()->get('thrift')->getClient('*client_name*');

        $service = new Service();
        $service->property = 121354984651354647;
        $service->name = 'Name 1';

        $id = $client->execMethod($service);
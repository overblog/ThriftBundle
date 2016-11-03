<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Metadata;

use Overblog\ThriftBundle\Metadata\Exception\ClientNotFoundException;
use Overblog\ThriftBundle\Metadata\Exception\ServerNotFoundException;
use Overblog\ThriftBundle\Metadata\Exception\ServiceNotFoundException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Metadata
{
    /**
     * @var ServiceMetadata[]
     */
    private $services;

    /**
     * @var ClientMetadata[]
     */
    private $clients;

    /**
     * @var ServerMetadata[]
     */
    private $servers;

    /**
     * @var CompilerMetadata
     */
    private $compiler;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'services' => [],
            'clients' => [],
            'servers' => [],
            'compiler' => [],
        ]);
        $resolvedOptions = $resolver->resolve($options);

        $this->setServices($resolvedOptions['services']);
        $this->setClients($resolvedOptions['clients']);
        $this->setServers($resolvedOptions['servers']);
        $this->setCompiler($resolvedOptions['compiler']);
    }

    public function setServices(array $services)
    {
        foreach ($services as $name => $service) {
            $this->addService($name, $service);
        }

        return $this;
    }

    public function addService($name, array $service)
    {
        $this->services[$name] = ServiceMetadata::create($service);

        return $this;
    }

    /**
     * @return ServiceMetadata[]
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param $name
     *
     * @return ServiceMetadata
     *
     * @throws ServiceNotFoundException
     */
    public function getService($name)
    {
        if (!isset($this->services[$name])) {
            throw ServiceNotFoundException::createNotFoundException($name);
        }

        return $this->services[$name];
    }

    public function setClients(array $clients)
    {
        foreach ($clients as $name => $client) {
            $this->addClient($name, $client);
        }

        return $this;
    }

    public function addClient($name, array $client)
    {
        unset($client['service_config']);
        $this->clients[$name] = ClientMetadata::create($client);

        return $this;
    }

    /**
     * @return ClientMetadata[]
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param $name
     *
     * @return ClientMetadata
     *
     * @throws ClientNotFoundException
     */
    public function getClient($name)
    {
        if (!isset($this->clients[$name])) {
            throw ClientNotFoundException::createNotFoundException($name);
        }

        return $this->clients[$name];
    }

    public function setServers(array $servers)
    {
        foreach ($servers as $name => $server) {
            $this->addServer($name, $server);
        }

        return $this;
    }

    public function addServer($name, array $server)
    {
        unset($server['service_config']);
        $this->servers[$name] = ServerMetadata::create($server);

        return $this;
    }

    /**
     * @return ServerMetadata[]
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @param $name
     *
     * @return ServerMetadata
     *
     * @throws ServerNotFoundException
     */
    public function getServer($name)
    {
        if (!isset($this->servers[$name])) {
            throw ServerNotFoundException::createNotFoundException($name);
        }

        return $this->servers[$name];
    }

    public function setCompiler(array $compiler)
    {
        $this->compiler = CompilerMetadata::create($compiler);

        return $this;
    }

    public function getCompiler()
    {
        return $this->compiler;
    }
}

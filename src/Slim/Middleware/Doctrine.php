<?php

namespace Slim\Middleware;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Tools\Setup;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;

class Doctrine
{
    /** @var string */
    private $config;

    /** @var EntityManager */
    protected $entityManager = null;

    /** @var Container */
    protected $container;

    /**
     * Doctrine constructor.
     * @param $configuration
     */
    public function __construct( Container $container, $configuration ){
        $this->config = $configuration;
        $this->container = $container;

        $this->container['doctrine'] = $this;
    }

    /**
     * @param Container $container
     * @return $this
     */
    public function __invoke( Container $container )
    {
        return $this;
    }

    private function createEntityManager(){
        $config = Setup::createAnnotationMetadataConfiguration(
            $this->generatePaths( $this->config['entities']['paths'] ),
            $this->config['dev_mode'] );

        $this->entityManager = EntityManager::create(
            ( gettype( $this->config ) === "object" ) ? (array)$this->config->connection : $this->config['connection'],
            $config );
        $this->container['entityManager'] = $this->entityManager;

        $platform = $this->entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * @param $paths
     * @return array
     */
    private function generatePaths( $paths ){
        foreach( $paths as &$path ){
            $path = getcwd()."/".$path;
        }

        return $paths;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(){
        if( $this->entityManager == null ){
            $this->createEntityManager();
        }

        return $this->entityManager;
    }
}
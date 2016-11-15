<?php
/**
 * Created by PhpStorm.
 * User: joeykamsteeg
 * Date: 15/11/2016
 * Time: 22:09
 */

namespace Slim\Middleware;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class DoctrineResource
{
    /** @var ContainerInterface */
    protected $ci;

    /**
     * DoctrineResource constructor.
     * @param ContainerInterface $ci
     */
    public function __construct( ContainerInterface $ci ){
        $this->ci = $ci;
    }

    public function getContainer(){
        return $this->ci;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(){
        return $this->ci->get('doctrine')->getEntityManager();
    }
}
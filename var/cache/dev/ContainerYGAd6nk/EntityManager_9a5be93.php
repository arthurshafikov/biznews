<?php

namespace ContainerYGAd6nk;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHoldere196f = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer18210 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties16ca5 = [
        
    ];

    public function getConnection()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getConnection', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getMetadataFactory', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getExpressionBuilder', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'beginTransaction', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getCache', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getCache();
    }

    public function transactional($func)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'transactional', array('func' => $func), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'wrapInTransaction', array('func' => $func), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'commit', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->commit();
    }

    public function rollback()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'rollback', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getClassMetadata', array('className' => $className), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'createQuery', array('dql' => $dql), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'createNamedQuery', array('name' => $name), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'createQueryBuilder', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'flush', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'clear', array('entityName' => $entityName), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->clear($entityName);
    }

    public function close()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'close', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->close();
    }

    public function persist($entity)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'persist', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'remove', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'refresh', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'detach', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'merge', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getRepository', array('entityName' => $entityName), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'contains', array('entity' => $entity), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getEventManager', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getConfiguration', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'isOpen', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getUnitOfWork', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getProxyFactory', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'initializeObject', array('obj' => $obj), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'getFilters', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'isFiltersStateClean', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'hasFilters', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return $this->valueHoldere196f->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer18210 = $initializer;

        return $instance;
    }

    public function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config)
    {
        static $reflection;

        if (! $this->valueHoldere196f) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHoldere196f = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHoldere196f->__construct($conn, $config);
    }

    public function & __get($name)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, '__get', ['name' => $name], $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        if (isset(self::$publicProperties16ca5[$name])) {
            return $this->valueHoldere196f->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere196f;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHoldere196f;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere196f;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHoldere196f;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, '__isset', array('name' => $name), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere196f;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHoldere196f;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, '__unset', array('name' => $name), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldere196f;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHoldere196f;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, '__clone', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        $this->valueHoldere196f = clone $this->valueHoldere196f;
    }

    public function __sleep()
    {
        $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, '__sleep', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;

        return array('valueHoldere196f');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer18210 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer18210;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer18210 && ($this->initializer18210->__invoke($valueHoldere196f, $this, 'initializeProxy', array(), $this->initializer18210) || 1) && $this->valueHoldere196f = $valueHoldere196f;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldere196f;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHoldere196f;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}

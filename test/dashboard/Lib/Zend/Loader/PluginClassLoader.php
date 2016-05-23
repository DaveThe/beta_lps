<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Loader;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Plugin Class locator interface
 */
Class PluginClassLoader implements PluginClassLocator
{
    /**
     * List of plugin name => Class name pairs
     * @var array
     */
    protected $plugins = array();

    /**
     * Static map allow global seeding of plugin loader
     * @var array
     */
    protected static $staticMap = array();

    /**
     * Constructor
     *
     * @param  null|array|Traversable $map If provided, seeds the loader with a map
     */
    public function __construct($map = null)
    {
        // Merge in static overrides
        if (!empty(static::$staticMap)) {
            $this->registerPlugins(static::$staticMap);
        }

        // Merge in constructor arguments
        if ($map !== null) {
            $this->registerPlugins($map);
        }
    }

    /**
     * Add a static map of plugins
     *
     * A null value will clear the static map.
     *
     * @param  null|array|Traversable $map
     * @throws Exception\InvalidArgumentException
     * @return void
     */
    public static function addStaticMap($map)
    {
        if (null === $map) {
            static::$staticMap = array();
            return;
        }

        if (!is_array($map) && !$map instanceof Traversable) {
            throw new Exception\InvalidArgumentException('Expects an array or Traversable object');
        }
        foreach ($map as $key => $value) {
            static::$staticMap[$key] = $value;
        }
    }

    /**
     * Register a Class to a given short name
     *
     * @param  string $shortName
     * @param  string $ClassName
     * @return PluginClassLoader
     */
    public function registerPlugin($shortName, $ClassName)
    {
        $this->plugins[strtolower($shortName)] = $ClassName;
        return $this;
    }

    /**
     * Register many plugins at once
     *
     * If $map is a string, assumes that the map is the Class name of a
     * Traversable object (likely a ShortNameLocator); it will then instantiate
     * this Class and use it to register plugins.
     *
     * If $map is an array or Traversable object, it will iterate it to
     * register plugin names/Classes.
     *
     * For all other arguments, or if the string $map is not a Class or not a
     * Traversable Class, an exception will be raised.
     *
     * @param  string|array|Traversable $map
     * @return PluginClassLoader
     * @throws Exception\InvalidArgumentException
     */
    public function registerPlugins($map)
    {
        if (is_string($map)) {
            if (!Class_exists($map)) {
                throw new Exception\InvalidArgumentException('Map Class provided is invalid');
            }
            $map = new $map;
        }
        if (is_array($map)) {
            $map = new ArrayIterator($map);
        }
        if (!$map instanceof Traversable) {
            throw new Exception\InvalidArgumentException('Map provided is invalid; must be traversable');
        }

        // iterator_apply doesn't work as expected with IteratorAggregate
        if ($map instanceof IteratorAggregate) {
            $map = $map->getIterator();
        }

        foreach ($map as $name => $Class) {
            if (is_int($name) || is_numeric($name)) {
                if (!is_object($Class) && Class_exists($Class)) {
                    $Class = new $Class();
                }

                if ($Class instanceof Traversable) {
                    $this->registerPlugins($Class);
                    continue;
                }
            }

            $this->registerPlugin($name, $Class);
        }

        return $this;
    }

    /**
     * Unregister a short name lookup
     *
     * @param  mixed $shortName
     * @return PluginClassLoader
     */
    public function unregisterPlugin($shortName)
    {
        $lookup = strtolower($shortName);
        if (array_key_exists($lookup, $this->plugins)) {
            unset($this->plugins[$lookup]);
        }
        return $this;
    }

    /**
     * Get a list of all registered plugins
     *
     * @return array|Traversable
     */
    public function getRegisteredPlugins()
    {
        return $this->plugins;
    }

    /**
     * Whether or not a plugin by a specific name has been registered
     *
     * @param  string $name
     * @return bool
     */
    public function isLoaded($name)
    {
        $lookup = strtolower($name);
        return isset($this->plugins[$lookup]);
    }

    /**
     * Return full Class name for a named helper
     *
     * @param  string $name
     * @return string|false
     */
    public function getClassName($name)
    {
        return $this->load($name);
    }

    /**
     * Load a helper via the name provided
     *
     * @param  string $name
     * @return string|false
     */
    public function load($name)
    {
        if (!$this->isLoaded($name)) {
            return false;
        }
        return $this->plugins[strtolower($name)];
    }

    /**
     * Defined by IteratorAggregate
     *
     * Returns an instance of ArrayIterator, containing a map of
     * all plugins
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->plugins);
    }
}
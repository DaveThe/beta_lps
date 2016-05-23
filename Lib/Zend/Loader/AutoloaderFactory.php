<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Loader;

use Traversable;

if (Class_exists('Zend\Loader\AutoloaderFactory')) {
    return;
}

abstract Class AutoloaderFactory
{
    const STANDARD_AUTOLOADER = 'Zend\Loader\StandardAutoloader';

    /**
     * @var array All autoloaders registered using the factory
     */
    protected static $loaders = array();

    /**
     * @var StandardAutoloader StandardAutoloader instance for resolving
     * autoloader Classes via the include_path
     */
    protected static $standardAutoloader;

    /**
     * Factory for autoloaders
     *
     * Options should be an array or Traversable object of the following structure:
     * <code>
     * array(
     *     '<autoloader Class name>' => $autoloaderOptions,
     * )
     * </code>
     *
     * The factory will then loop through and instantiate each autoloader with
     * the specified options, and register each with the spl_autoloader.
     *
     * You may retrieve the concrete autoloader instances later using
     * {@link getRegisteredAutoloaders()}.
     *
     * Note that the Class names must be resolvable on the include_path or via
     * the Zend library, using PSR-0 rules (unless the Class has already been
     * loaded).
     *
     * @param  array|Traversable $options (optional) options to use. Defaults to Zend\Loader\StandardAutoloader
     * @return void
     * @throws Exception\InvalidArgumentException for invalid options
     * @throws Exception\InvalidArgumentException for unloadable autoloader Classes
     * @throws Exception\DomainException for autoloader Classes not implementing SplAutoloader
     */
    public static function factory($options = null)
    {
        if (null === $options) {
            if (!isset(static::$loaders[static::STANDARD_AUTOLOADER])) {
                $autoloader = static::getStandardAutoloader();
                $autoloader->register();
                static::$loaders[static::STANDARD_AUTOLOADER] = $autoloader;
            }

            // Return so we don't hit the next check's exception (we're done here anyway)
            return;
        }

        if (!is_array($options) && !($options instanceof Traversable)) {
            require_once __DIR__ . '/Exception/InvalidArgumentException.php';
            throw new Exception\InvalidArgumentException(
                'Options provided must be an array or Traversable'
            );
        }

        foreach ($options as $Class => $autoloaderOptions) {
            if (!isset(static::$loaders[$Class])) {
                $autoloader = static::getStandardAutoloader();
                if (!Class_exists($Class) && !$autoloader->autoload($Class)) {
                    require_once 'Exception/InvalidArgumentException.php';
                    throw new Exception\InvalidArgumentException(
                        sprintf('Autoloader Class "%s" not loaded', $Class)
                    );
                }

                if (!is_subClass_of($Class, 'Zend\Loader\SplAutoloader')) {
                    require_once 'Exception/InvalidArgumentException.php';
                    throw new Exception\InvalidArgumentException(
                        sprintf('Autoloader Class %s must implement Zend\\Loader\\SplAutoloader', $Class)
                    );
                }

                if ($Class === static::STANDARD_AUTOLOADER) {
                    $autoloader->setOptions($autoloaderOptions);
                } else {
                    $autoloader = new $Class($autoloaderOptions);
                }
                $autoloader->register();
                static::$loaders[$Class] = $autoloader;
            } else {
                static::$loaders[$Class]->setOptions($autoloaderOptions);
            }
        }
    }

    /**
     * Get a list of all autoloaders registered with the factory
     *
     * Returns an array of autoloader instances.
     *
     * @return array
     */
    public static function getRegisteredAutoloaders()
    {
        return static::$loaders;
    }

    /**
     * Retrieves an autoloader by Class name
     *
     * @param  string $Class
     * @return SplAutoloader
     * @throws Exception\InvalidArgumentException for non-registered Class
     */
    public static function getRegisteredAutoloader($Class)
    {
        if (!isset(static::$loaders[$Class])) {
            require_once 'Exception/InvalidArgumentException.php';
            throw new Exception\InvalidArgumentException(sprintf('Autoloader Class "%s" not loaded', $Class));
        }
        return static::$loaders[$Class];
    }

    /**
     * Unregisters all autoloaders that have been registered via the factory.
     * This will NOT unregister autoloaders registered outside of the fctory.
     *
     * @return void
     */
    public static function unregisterAutoloaders()
    {
        foreach (static::getRegisteredAutoloaders() as $Class => $autoloader) {
            spl_autoload_unregister(array($autoloader, 'autoload'));
            unset(static::$loaders[$Class]);
        }
    }

    /**
     * Unregister a single autoloader by Class name
     *
     * @param  string $autoloaderClass
     * @return bool
     */
    public static function unregisterAutoloader($autoloaderClass)
    {
        if (!isset(static::$loaders[$autoloaderClass])) {
            return false;
        }

        $autoloader = static::$loaders[$autoloaderClass];
        spl_autoload_unregister(array($autoloader, 'autoload'));
        unset(static::$loaders[$autoloaderClass]);
        return true;
    }

    /**
     * Get an instance of the standard autoloader
     *
     * Used to attempt to resolve autoloader Classes, using the
     * StandardAutoloader. The instance is marked as a fallback autoloader, to
     * allow resolving autoloaders not under the "Zend" namespace.
     *
     * @return SplAutoloader
     */
    protected static function getStandardAutoloader()
    {
        if (null !== static::$standardAutoloader) {
            return static::$standardAutoloader;
        }


        if (!Class_exists(static::STANDARD_AUTOLOADER)) {
            // Extract the filename from the Classname
            $stdAutoloader = substr(strrchr(static::STANDARD_AUTOLOADER, '\\'), 1);
            require_once __DIR__ . "/$stdAutoloader.php";
        }
        $loader = new StandardAutoloader();
        static::$standardAutoloader = $loader;
        return static::$standardAutoloader;
    }

    /**
     * Checks if the object has this Class as one of its parents
     *
     * @see https://bugs.php.net/bug.php?id=53727
     * @see https://github.com/zendframework/zf2/pull/1807
     *
     * @deprecated since zf 2.3 requires PHP >= 5.3.23
     *
     * @param  string $ClassName
     * @param  string $type
     * @return bool
     */
    protected static function isSubClassOf($ClassName, $type)
    {
        return is_subClass_of($ClassName, $type);
    }
}

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Db\TableGateway\Feature;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\Exception;

Class GlobalAdapterFeature extends AbstractFeature
{
    /**
     * @var Adapter[]
     */
    protected static $staticAdapters = array();

    /**
     * Set static adapter
     *
     * @param Adapter $adapter
     */
    public static function setStaticAdapter(Adapter $adapter)
    {
        $class = get_called_Class();

        static::$staticAdapters[$class] = $adapter;
        if ($class === __Class__) {
            static::$staticAdapters[__Class__] = $adapter;
        }
    }

    /**
     * Get static adapter
     *
     * @throws Exception\RuntimeException
     * @return Adapter
     */
    public static function getStaticAdapter()
    {
        $class = get_called_Class();

        // Class specific adapter
        if (isset(static::$staticAdapters[$class])) {
            return static::$staticAdapters[$class];
        }

        // default adapter
        if (isset(static::$staticAdapters[__Class__])) {
            return static::$staticAdapters[__Class__];
        }

        throw new Exception\RuntimeException('No database adapter was found in the static registry.');
    }

    /**
     * after initialization, retrieve the original adapter as "master"
     */
    public function preInitialize()
    {
        $this->tableGateway->adapter = self::getStaticAdapter();
    }
}

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Db\Sql\Ddl\Column;

/**
 * Stub Class for backwards compatibility.
 *
 * Since PHP 7 adds "float" as a reserved keyword, we can no longer have a Class
 * named that and retain PHP 7 compatibility. The original Class has been
 * renamed to "Floating", and this Class is now an extension of it. It raises an
 * E_USER_DEPRECATED to warn users to migrate.
 *
 * @deprecated
 */
Class Float extends Floating
{
    /**
     * {@inheritDoc}
     *
     * Raises a deprecation notice.
     */
    public function __construct(
        $name,
        $digits = null,
        $decimal = null,
        $nullable = false,
        $default = null,
        array $options = array()
    ) {
        trigger_error(
            sprintf(
                'The Class %s has been deprecated; please use %s\\Floating',
                __Class__,
                __NAMESPACE__
            ),
            E_USER_DEPRECATED
        );

        parent::__construct($name, $digits, $decimal, $nullable, $default, $options);
    }
}

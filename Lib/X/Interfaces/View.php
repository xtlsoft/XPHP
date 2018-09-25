<?php
/**
 * XPHP - PHP Framework
 *
 * This project is licensed
 * under MIT. Please use it
 * under the license and law.
 *
 * @category Framework
 * @package  XPHP
 * @author   Tianle Xu <xtl@xtlsoft.top>
 * @license  MIT
 * @link     https://github.com/xtlsoft/XPHP
 *
 */

namespace X\Interfaces;

interface View
{

    /**
     * @param string $content
     * @return string
     */
    function getRender($content);

    /**
     * @param string $renderCode
     * @return callable
     */
    function prepareRender($renderCode);

    /**
     * @param string $name
     * @param array $data
     */
    function render($name, $data);
}
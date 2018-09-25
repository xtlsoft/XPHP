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

namespace X\Route;

class AddressParseResult
{
    /**
     * @var array
     */
    public $keys;

    /**
     * @var string[]
     */
    public $preg;

    /**
     * Assign result.
     *
     * @param array $assignment
     * @return AddressParseResult
     */
    public function assign($assignment)
    {
        $this->keys = $assignment['keys'];
        $this->preg = $assignment['preg'];
        return $this;
    }
}
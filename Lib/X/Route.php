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

namespace X;

use X\Interfaces\NeedApplication as INeedApplication;
use X\Route\AddressParseResult;

class Route implements INeedApplication
{

    /**
     * @var array[] $routes
     */
    protected $routes = [];

    /**
     * Register a handle
     *
     * @param string $method
     * @param string $url
     * @param callable $callback
     * @throws \Exception
     * @return Route
     */
    public function on($method, $url, callable $callback)
    {
        $result = self::parseUrl($url);
        if (!($result instanceof AddressParseResult)) {
            throw new \Exception("Route Expecting \X\Route\AddressParseResult, Other Given.");
        }
        $route = ["method" => $method, "keys" => $result->keys, "preg" => $result->preg, "callback" => $callback];
        $this->routes[] = $route;
        return $this;
    }

    /**
     * Handle a request
     *
     * @param string $method
     * @param string $address
     * @return int|array
     */
    public function handle($method, $address)
    {
        $method = strtolower($method);
        $rb = $this->app->config['Route']['Base'];
        $address = substr($address, (strlen($rb)));
        foreach ($this->routes as $route) {
            if ($route['method'] == $method) {
                $result = self::matchUrl($route['preg'], $address);
                if ($result) {
                    $vars = self::toAssocByKeyAndValue($route['keys'], $result);
                    $callback = $route['callback'];
                    return ["vars" => $vars, "callback" => $callback];
                }
            }
        }
        return 404;
    }

    /**
     * Call function in registry
     *
     * @param string Method
     * @param array Parameters
     * @throws \Exception
     * @return mixed
     *
     */
    public function __call($name, $param)
    {

        return $this->on($name, $param[0], $param[1]);

    }

    /**
     * Parse a route address
     *
     * @param string $address
     *
     * @return \X\Route\AddressParseResult
     *
     */
    public static function parseUrl($address)
    {
        $keys = [];

        // Dump the keys & Replacement
        $patterns = preg_replace_callback("/\\{[a-zA-Z]*\\}/", function ($a) use (&$keys) {
            $keys[] = substr($a[0], 1, -1);
            return "<<<>>>";
        }, $address);
        // Generate The Regex
        $patterns = "/^" . str_replace(array("/", ".", "<<<>>>"), array("\\/", "\\.", "(.*)"), $patterns) . "$/";
        return (new AddressParseResult())->assign(["keys" => $keys, "preg" => $patterns]);
    }

    /**
     * Match a url by RegEx pattern and work out the matched results.
     *
     * @param string $regex
     * @param string $url
     * @return array|bool
     */
    public static function matchUrl($regex, $url)
    {
        $result = [];
        if (preg_match($regex, $url, $result)) {
            array_shift($result);
            if ($result === []) {
                $result = ["____"];
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get assoc by keys and values
     *
     * @param string[] $key
     * @param string[] $value
     * @return string[]
     */
    public static function toAssocByKeyAndValue($key, $value)
    {
        $result = [];
        foreach ($value as $k => $v) {
            if (isset($key[$k - 1])) {
                $result[$key[$k - 1]] = urldecode($v);
            }
        }
        return $result;
    }
}
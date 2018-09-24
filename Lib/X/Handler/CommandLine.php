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

namespace X\Handler;

use League\CLImate\CLImate;
use X\Interfaces\Bootable;
use X\Interfaces\Handler as IHandler;
use X\Interfaces\NeedApplication as INeedApplication;
use X\Request;

class CommandLine implements Bootable, IHandler, INeedApplication
{

    use CallbackStackTrait;

    public $cli;

    public function bootup()
    {
        $this->cli = new CLImate();
    }

    /**
     * @return \X\Request
     */
    public function getRequest()
    {

        $request = new Request();
        $parse = $this->parseArgv($_SERVER['argv']);
        $request->set([
            "method" => "CLI",
            "data" => [
                "param" => $parse['param'],
                "raw" => $parse['command'],
                "server" => $_SERVER
            ],
            "uri" => $parse['command'][1]
        ]);
        return $request;
    }

    /**
     * @param array $argv
     * @return array
     */
    public function parseArgv($argv)
    {
        $flag = false;
        $arguments = [];
        $rawCommand = [];
        foreach ($argv as $k => $v) {
            if ($flag) {
                $flag = false;
                continue;
            }
            if (substr($v, 0, 1) == "-") {
                $key = "";
                if (substr($v, 0, 2) == "--") {
                    $key = substr($v, 2);
                } else {
                    $key = substr($v, 1);
                }
                $value = $argv[$k + 1];
                $flag = true;
                $arguments[$key] = $value;
            } else {
                $rawCommand[] = $v;
            }
        }
        return ["param" => $arguments, "command" => $rawCommand];
    }

    /**
     * @param \X\Response $response
     */
    public function response($response)
    {
        $response = $this->handleResponseCallback($response);
        $stat = $response->dump()->status;
        if ($stat !== 200) {
            $this->cli->error('Error: ' . $stat);
        }
        $this->cli->out($response->dump()->content);
    }

}
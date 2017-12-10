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

    use \League\CLImate\CLImate;

    class CommandLine implements \X\Interfaces\Handler, \X\Interfaces\Bootable, \X\Interfaces\NeedApplication {

        use \X\Handler\CallbackStack;

        public $cli;

        public function bootup(){

            $this->cli = new CLImate();

        }

        public function getRequest(){

            $req = new \X\Request();

            $parse = $this->parseArgv($_SERVER['argv']);
            
            $req->set([
                "method" => "CLI",
                "data" => [
                    "param"  => $parse['param'],
                    "raw"    => $parse['command'],
                    "server" => $_SERVER
                ],
                "uri" => $parse['command'][1]
            ]);

            return $req;

        }

        public function parseArgv($argv){

            $flag = false;

            $arguments = [];
            $rawCommand = [];

            foreach($argv as $k=>$v){

                if($flag){
                    $flag = false;
                    continue;
                }

                if(substr($v, 0, 1) == "-"){
                    $key = "";
                    if(substr($v, 0, 2) == "--"){
                        $key = substr($v, 2);
                    }else{
                        $key = substr($v, 1);
                    }
                    $value = $argv[$k + 1];
                    $flag = true;
                    $arguments[$key] = $value;
                }else{
                    $rawCommand[] = $v;
                }

            }

            return ["param"=>$arguments, "command"=>$rawCommand];

        }

        public function response(\X\Response $response){

            $response = $this->handleResponseCallback($response);

            $stat = $response->dump()->status;
            
            if($stat !== 200){
                $this->cli->error('Error: '. $stat);
            }

            $this->cli->out($response->dump()->content);

        }

    }
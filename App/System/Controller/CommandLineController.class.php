<?php
    /**
     * XPHP Project
     * By xtl
     * 
     */
    
    namespace Controller\System;
    
    use X\Controller;
    
    class CommandLineController extends Controller implements \X\Interfaces\Bootable {

        public function bootup(){
            $this->app->handler->cli->addArt($this->app->config['SysDir'] . $this->app->config['Path']['Template'] . '/default/System/cliart');
        }

        public function version($req){
            
            $cli = $this->app->handler->cli;

            $cli->backgroundLightRedGreenBlack()->animation('xphp')->speed('150')->enterFrom('left');

            return $this->response("\n<bold>Version</bold>: <red>".X."</red>\n");
            
        }
        
        public function serve($req){

            $p = rand(20000, 30000);

            $this->app->handler->cli
                ->out("<bold>XPHP Development Server</bold>")
                ->inline("Listening On: ")
                ->red(isset($req->get()->data->param->p) ? $req->get()->data->param->p : $p)
                ->out("Press <bold><green>Ctrl + C</green></bold> to quit.\n");
            echo shell_exec("php -S 127.0.0.1:" . (isset($req->get()->data->param->p) ? $req->get()->data->param->p : $p ) . " ./Public/index.php");

            return $this->response("", [], "Failed to startup server.");

        }

        public function init($req){

            $cli = $this->app->handler->cli;
            $cli->out("<bold><yellow>Welcome to XPHP project init.</yellow></bold>");
            $cli->out("We need some information from you in order to init your project.");
            $cli->br();
            $name = $cli->input("Project Name: [" . basename($this->app->config['SysDir']) . "]")
                ->defaultTo(basename($this->app->config['SysDir']))
                ->prompt();
            $description = $cli->input("Describe your Project: []")
                ->prompt();
            $version = $cli->input("Version: [0.1.0-alpha]")
                ->defaultTo("0.1.0-alpha")
                ->prompt();
            $xphp_version = $cli->input("XPHP Version: [" . X . "]")
                ->defaultTo(X)
                ->prompt();

        }

    }
    
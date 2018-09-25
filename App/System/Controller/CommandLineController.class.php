<?php
/**
 * XPHP Project
 * By xtl
 *
 */

namespace Controller\System;

use X\Controller;
use X\Request;
use X\Interfaces\Bootable;

class CommandLineController extends Controller implements Bootable
{

    public function bootup()
    {
        $this->app->handler->cli->addArt($this->app->config['SysDir'] . $this->app->config['Path']['Template'] . '/default/System/cliart');
    }

    /**
     * @return \X\Response
     */
    public function version()
    {
        $cli = $this->app->handler->cli;
        $cli->backgroundLightRedGreenBlack()->animation('xphp')->speed('150')->enterFrom('left');
        return $this->response("\n<bold>Version</bold>: <red>" . X . "</red>\n");
    }

    /**
     * @param Request $req
     * @return \X\Response
     */
    public function serve($req)
    {
        $p = rand(20000, 30000);
        $this->app->handler->cli
            ->out("<bold>XPHP Development Server</bold>")
            ->inline("Listening On: ")
            ->red(isset($req->get()->data->param->p) ? $req->get()->data->param->p : $p)
            ->out("Press <bold><green>Ctrl + C</green></bold> to quit.\n");
        echo shell_exec("php -S 127.0.0.1:" . (isset($req->get()->data->param->p) ? $req->get()->data->param->p : $p) . " ./Public/index.php");
        return $this->response("", [], "Failed to startup server.");
    }

    public function init($req)
    {
        $cli = $this->app->handler->cli;
        $cli->out("<bold><yellow>Welcome to XPHP project init.</yellow></bold>");
        $cli->out("We need some information from you in order to init your project.");
        $cli->br();
        $name = $cli->input("Project Name: [" . basename($this->app->config['SysDir']) . "]")->defaultTo(basename($this->app->config['SysDir']))->prompt();
        $description = $cli->input("Describe your Project: []")->prompt();
        $version = $cli->input("Version: [0.1.0-alpha]")->defaultTo("0.1.0-alpha")->prompt();
        $xphp_version = $cli->input("XPHP Version: [" . X . "]")->defaultTo(X)->prompt();
        $need_stable_version = $cli->confirm('Need Stable Version:')->confirmed();
        $edited_core_files = [];

        $base = $this->app->config['SysDir'];

        do {
            $item = $cli->input("Edited Core Files: (Leave empty to quit)")->accept(function ($input) use ($base) {
                if (is_file($input) || $input == "") {
                    return true;
                } else {
                    echo "Invalid Input.\r\n";
                    return false;
                }
            })->prompt();
            if ($item != "") {
                $edited_core_files[] = $item;
            }
        } while ($item != "");

        $xphpJson = [
            "name" => $name,
            "description" => $description,
            "version" => $version,
            "xphp-version" => $xphp_version,
            "edited-core-files" => $edited_core_files,
            "need-stable-version" => $need_stable_version
        ];

        $xphpJson = json_encode($xphpJson, JSON_PRETTY_PRINT);

        $cli->backgroundLightBlue($xphpJson);

        $confirm = $cli->confirm("Is That OK?")->confirmed();

        if ($confirm) {
            file_put_contents($base . "xphp.json", $xphpJson);
            $cli->out("<green>Done.</green>");
        }

        $composer = $cli->confirm("Run <blue>composer init</blue>?")->confirmed();
        if ($composer) {
            shell_exec("composer init");
        }

        return $this->response("");

    }

    public function update()
    {


    }

    public function push()
    {


    }

}
    
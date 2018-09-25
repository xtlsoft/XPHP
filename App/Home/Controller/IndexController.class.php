<?php
/**
 * XPHP Project
 * By xtl
 *
 */

namespace Controller\Home;

use X\Controller;
use X\Log;

class IndexController extends Controller
{
    public function index($req)
    {

        $data = array(
            "version" => X,
            "welcome" => "欢迎"
        );

        //$model = $this->model("Home/IndexModel");

        //var_dump($model->where("name", "testname")->findOne()->value);

        return $this->view("Home/Index", $data);

    }

}
    
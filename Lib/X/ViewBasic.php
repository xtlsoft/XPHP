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
    
    class View{
        private $tplFile;
        private $vars;
        public function __construct($name){
            $tpl = $GLOBALS['_C']['Template'];
            if(is_file(TemplateDir.$tpl."/".$name.".tpl")){
                $this->tplFile = file_get_contents(TemplateDir.$tpl."/".$name.".tpl");
            }elseif(is_file(TemplateDir."default/".$name.".tpl")){
                $this->tplFile = file_get_contents(TemplateDir."default/".$name.".tpl");
            }else{
                $exp = explode("/",$name);
                if($exp[0] == "plugin"){
                    $file = PluginDir. $exp[1]. '/Template';
                    for($i=2; $i<=(count($exp)-1); ++$i){
                        $file .= '/'.$exp[$i];
                    }
                    $file .= '.tpl';
                    if(is_file($file)){
                        $this->tplFile = file_get_contents($file);
                    }
                }
            }
        }
        public function bindVars($varArr){
            $this->vars = $varArr;
        }
        public function show(){
            if($_GET['inajax'] == "yes"){
                echo json_encode($this->vars);
                return;
            }
            $rpl  = array($GLOBALS['_C']['View']['Start']."#", $GLOBALS['_C']['View']['Start'], $GLOBALS['_C']['View']['End']);
            $torp = array("<?php",                             "<?=",                           "?>" );
            $this->tplFile = str_replace($rpl,$torp,$this->tplFile);
            $preEval = '$L = self::lang($GLOBALS["_C"]["Language"]);
$Base = $GLOBALS["_C"]["RouteBase"]."/";
$StaticDir = $Base . "Static/" . $GLOBALS["_C"]["Template"] . "/";
foreach($this->vars as $k=>$v){
    eval("\$".$k." = \$v;");
}?>';
            eval($preEval.$this->tplFile);
        }
        
        public static function lang($lang){
            return json_decode(file_get_contents(LangDir.$lang.'.json'),1);
        }
        
        private function need($tpl){
            $this->tplFile="";
            $this->__construct($tpl);
            $this->show();
        }
        
    }
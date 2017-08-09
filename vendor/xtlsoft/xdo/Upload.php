<?php
    
    namespace XDO;
    
    use XDO\Tool;
    use XDO\XDO;
    use XDO\XDOError;
    
    class Upload{
        protected $ModelName;
        protected $Base;
        protected $files = array();
        
        public function __construct($ModelName){
            $this->ModelName = $ModelName;
            $this->Base = XDO::$DataDir . '/Upload/' . $ModelName . '/';
            $flf = $this->Base . 'FileList.json';
            if(is_file($flf)) $this->files = Tool::getJson($flf);
            else $this->files = array();
        }
        
        public function get($f){
            
            if(isset($this->files[$f])){
                return file_get_contents($this->Base . $this->files[$f]);
            }else{
                throw new XDOError("NO_SUCH_FILE",3101);
            }
            
        }
        
        public function put($f, $c, $useOrginName=false){
            
            $fn = Tool::genFileName();
            if($useOrginName){
                $fn = $f;
            }
            $this->files[$f] = $fn;
            file_put_contents(($this->Base . $fn), $c);
            return $fn;
            
        }
        
        public function ParseUpload(){
            
        }
    }
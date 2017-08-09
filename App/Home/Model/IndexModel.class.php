<?php
    /**
     * IndexModel.php
     * A Demo of Model
     * 
     */
    
    namespace Model\Home;
    
    use X\Model;
    
    class IndexModel extends Model{
        
        public function get($a){
            
            return $this->ORM->where("name",$a)->findOne()->value;
            
        }
        
    }
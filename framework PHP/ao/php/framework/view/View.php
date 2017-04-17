<?php
namespace ao\php\framework\view;

class View {
    private $control;
    private $action;
    private static $data = array();//een associatief te vullen array
    
     
    public function setControl($control)
    {
        $this->control = $control;
    }
    
    public function setAction($action)
    {
        $this->action = $action;
    }
    
    /**
     * draagt een naam waarde paar over aan de view ter expressie in de template;
     */
    public function set($naam, $waarde)
    {
        //if(!isset(View::$data[$naam]))
        {
            self::$data[$naam] = $waarde;
        }
    }
    
    /**
     * bepaalt het gezochte pad aan de hand van $this->action en $this->control
     * @return type string het pad van de gezochte template
     */
    private function getTemplate()
    {
        
        return str_replace('\\',DIRECTORY_SEPARATOR, BASE_NAMESPACE."view\\tpls\\$this->control\\$this->action.php");
    }
    
    
    public function toon()
    {
        \header('Content-Type: text/html; charset=utf-8');
        //voorkom dat er een variabelen conflict komt doordat 
        //er dynamisch een naam gemaakt wordt die al bestaat, 
        //vandaar de rare variabele namen
        foreach (self::$data as $qrxU =>$Pqzy)
        {
            $$qrxU = $Pqzy;
            
        }
        include_once $this->getTemplate();
    } 
}





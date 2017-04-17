<?php

namespace ao\php\framework\controls;
class ControlDispatcher 
{
    
    private $control;
    private $action;
    public function __construct($control, $action)
    {
        $this->control = $control;
        $this->action = $action;
    }
    public function dispatch()
    {
        $klasseNaam = BASE_NAMESPACE.'controls\\'.ucFirst($this->control).'Controller';
        if(!class_exists($klasseNaam))
        {
            //$this->control = DEFAULT_ROLE;
            //$klasseNaam = BASE_NAMESPACE.'controls\\'.ucFirst($this->control).'Controller';
            throw new \ao\php\framework\error\FrameworkException
                        ("controller $klasseNaam bestaat niet!");
        }
        if(!is_subclass_of($klasseNaam,'\\ao\php\\framework\\controls\\AbstractController')  )
        {
            throw new \ao\php\framework\error\FrameworkException
                        ("klas $klasseNaam implementeert overerft niet van framework AbstractController. dat is verplicht");
        }
        $controller = new $klasseNaam($this->control,$this->action);
        $controller->execute();
    }
}







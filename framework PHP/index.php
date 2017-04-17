<?php
/* de default autoloader spl__autoload wordt nu niet geladen. deze geeft een LogicException
 * dat is uiterst hinderlijk als je verwacht dat de methode class_exsists true of false returnt
 * dat doet deze methode dan dus niet; er ontstaat een logicexception
 */
include "ao/php/framework/config.php";
function __autoload($className)
{
    $class = str_replace('\\',DIRECTORY_SEPARATOR,$className);
    $file = "$class.php";
    if(file_exists($file)){
        include $file;
    }
}


$control =\filter_input(\INPUT_GET, 'control')?:'bezoeker' ; 
$action = \filter_input(\INPUT_GET, 'action')?:'default' ;


try{
   
    $dispatcher = new \ao\php\framework\controls\ControlDispatcher($control, $action);
    $dispatcher->dispatch(); 
} 
catch (ao\php\framework\error\FrameworkException $ex) {
    $error = $ex->getMessage();
    // zorg zelf e.v.t. voor een fout pagina 
    echo $error;
}
catch(\PDOException $e)
{
    $error = "er is iets misgegaan in met de database. Waarschuw de beheerder";
    // zorg zelf e.v.t. voor een fout pagina
     echo $error;
}
catch(\Exception $e)
{
    $error = "er is uitzondering opgetreden. Ga je code na";
   // zorg zelf e.v.t. voor een fout pagina
     echo $error;
}



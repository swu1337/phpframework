<?php

namespace ao\php\framework\models\db;
use ao\php\framework\error as ERROR;
abstract class Entiteit
{
    
    /**
    * @param <string> $methodeNaam
    * deze variabele bevat als string de naam van een methode die niet bestaat in de klassedefinitie
    * van het bevraagde object. 
    * @param <string> $args
    * deze variabele is van het type array en hij bevat alle argumenten die aan de onbekende methode
    * werden meegegeven als zijn argumenten
    * Resultaat:
    * de methode wordt dynamisch gemaakt als er sprake is van een setter of een getter van een property
    * van het object. Zoniet dan wordt er een exception geworpen.
    */
    public function __call($methodeNaam, $args)
    {
        $methodeType = substr($methodeNaam,0,3);
        $eigenschap = lcfirst(substr($methodeNaam,3));
        $aantalArgumenten = count($args);
        if(!property_exists($this,$eigenschap))
        {
            throw new ERROR\FrameworkException(
            "de eigenschap $eigenschap bestaat helemaal niet!!");
        }
        switch($methodeType)
        {
            case 'get':
                if($aantalArgumenten!==0)
                {
                    throw new ERROR\FrameworkException(
                    "$methodeNaam methode accepteert geen argumenten, zeker niet 
                    $aantalArgumenten argument(en).");
                }
                return $this->$eigenschap; 
            case 'set':
                if($aantalArgumenten!==1)
                {
                    throw new ERROR\FrameworkException(
                    "$methodeNaam methode accepteert niet
                    $aantalArgumenten argument(en).");
                }
                $this->$eigenschap = $args[0];
                break;
            default:
                throw new ERROR\FrameworkException(
                "de methode $methodeNaam bestaat helemaal niet!!");
        }
    }
}



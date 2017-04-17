<?php

namespace ao\php\framework\models;
abstract class AbstractModel 
{
    protected $control;
    protected $action;
    protected $dbh;
    
    
    public function __construct($control,$action)
    {
        $this->control = $control;
        $this->action = $action;
        $this->dbh = new \PDO(DATA_SOURCE_NAME,DB_USERNAME,DB_PASSWORD);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        if($this->control !==DEFAULT_ROLE)
        {
            $this->startSession();            
            
        }
        else{
            /*je kan van een andere controller komen middels forward, mogelijk geldt dan dat er een open sessie is. Sluit die nu af.
             * de default role heeft geen sessie!!
             */
            if($this->getGebruiker()!==NULL)
            {
                $this->stopSession();
            }
        }
    }
    
    /**
     * vertelt of er bij het af te handelen requerst formulier data aanwezig was.
     * @return boolean 
     * description true als er een formulier gestuurd is met daarin data.<br>
     * false anders
     */
    public function isPostLeeg()
    {
        return empty($_POST);
    }
    /**
     * 
     * @return Persoon in casu de gebruiker van de applicatie die ook in de sessie staat of null als er geen sessie of een lege sessie is
     */
    public function getGebruiker()
    {
        if(!isset($_SESSION)||!isset($_SESSION['gebruiker'])||empty($_SESSION['gebruiker']))
        {
            return NULL;
        }
        else
        {
            return $_SESSION['gebruiker'];
        }
    }
    
    public function getGebruikerRecht()
    {
        $gebruiker = $this->getGebruiker();
        $recht = ($gebruiker === null) ? DEFAULT_ROLE : $gebruiker->getRecht();
        return $recht;
    }
    
    protected function startSession() 
    {
        if(!isset($_SESSION))
        {
            \session_start();
        }
    }
    
    public function stopSession() 
    {
        if(isset($_SESSION))
        {
            $_SESSION = [];
            \session_destroy();
        }  
    }
    
    
    public function setAction($action)
    {
        $this->action=$action;
    }
    
    /**
     * deze functie geeft als return waarde de informatie die in het formulier verstuurd wwas terug. 
     * Enkel de input gegevens van de eventuele mee gestuurde afbeelding zit er niet in.
     * @return array 
     * al de in het formulier aangeleverde data staat in deze associatieve array. 
     * de keys zijn de inputnamen de values zijn de input waarden
     */
    public function getFormData()
    {
        return $_POST;
    }
}

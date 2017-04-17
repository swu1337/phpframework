<?php
namespace ao\php\framework\error;
/**
 * deze exception wordt geworpen als het framework de benodigde klasse niet kan vinden
 * of als de bevraagde methode niet bestaat.
 */
class FrameworkException  extends \Exception
{
    public function __construct($message, $code = 0,\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous) ;  
    }
}

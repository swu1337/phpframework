<?php
namespace ao\php\framework\utils;
final class Foto 
{
    private function __construct()
    {
        //to avoid construction of object;
    }
    public static function isAfbeeldingGestuurd() 
    {
        
        if(!isset($_FILES['foto'])){
            return IMAGE_NOTHING_UPLOADED; 
        }
        if($_FILES['foto']['error'] === \UPLOAD_ERR_NO_FILE)
        {
            return IMAGE_NOTHING_UPLOADED; 
        }
        if($_FILES['foto']['error']=== \UPLOAD_ERR_FORM_SIZE||$_FILES['foto']['error']===\UPLOAD_ERR_INI_SIZE)
        {
            return IMAGE_FAILURE_SIZE_EXCEEDED;
        }
        if($_FILES['foto']['error']===\UPLOAD_ERR_OK){
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $ext = $finfo->file($_FILES['foto']['tmp_name']);
            $allowed = array(
                'image/jpeg',
                'image/png',
                'image/jpg',
            );
            if( ! in_array( $ext, $allowed ) ){
                return IMAGE_FAILURE_TYPE;
            }
            return IMAGE_SUCCES;
        }
        return IMAGE_FAILURE_SAVE_FAILED;  
    }
    /**
     * de methode bepaalt een bestandsnaam voor een in de globale FILES variable staande afbeelding 
     * @return boolean|string false als er een foutief bestandstype aangeboden wordt. string een unieke naam in al de andere gevallen.
     */
    public static function getAfbeeldingNaam()
    {
        $foto_tmp_name = $_FILES['foto']['tmp_name'];
        $foto_name = $_FILES['foto']['name'];
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['foto']['tmp_name']);
        $allowed = array(
            'jpg'=>'image/jpeg',
            'png'=>'image/png',
            'gif'=>'image/jpg',
        );
        $ext = array_search($mime,$allowed,true);
        if($ext===false){
            return false;
        }
        $tijd = getdate();
        $tehashenNaam = $foto_name.$foto_tmp_name.$tijd[0].$tijd['weekday'].".$ext";
        $teller =0;
        $nieuweFotoNaam = md5($tehashenNaam).".$ext";
        while(file_exists(IMAGE_LOCATION.$nieuweFotoNaam)){
            $tehashenNaam = $teller.$tehashenNaam;
            $nieuweFotoNaam = md5($tehashenNaam).".$ext";
            $teller++;
        }
        return $nieuweFotoNaam;
    }
    
    public static function slaAfbeeldingOp($fotoNaam)
    {
         $foto_tmp_name = $_FILES['foto']['tmp_name'];
         $result = \move_uploaded_file($foto_tmp_name, IMAGE_LOCATION.$fotoNaam);
         if ($result===false) {
             return IMAGE_FAILURE_SAVE_FAILED;
         }
         return  IMAGE_SUCCES;
    }
    
    /**
     * de methode verwijdert uit de afbeeldingen map de aangeboden afbeelding
     * @param string $naam de naam van de te verwijderen afbeelding
     */
    public static function verwijderAfbeelding($naam)
    {
        if(\file_exists(IMAGE_LOCATION.$naam))
        {
            unlink(IMAGE_LOCATION.$naam);
        }
    }
}

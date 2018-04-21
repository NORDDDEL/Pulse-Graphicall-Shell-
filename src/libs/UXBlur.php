<?php
namespace libs;

use Exception;
use gui;
use std;
use framework;
use system\DFFIType;
use system\DFFI;

class UXBlur 
{
    private $dffi;
    
    public function __construct(string $dllname)
    {
        $this->dffi = new DFFI($dllname);
        $this->dffi->bind("SetWindowBlur10", DFFIType::INT, [DFFIType::STRING]);
        $this->dffi->bind("SetWindowBlur7", DFFIType::INT, [DFFIType::STRING]);
    }
    
    public function SetBlur(string $formTitle) : bool 
    {
        $winVer = (int) explode(" ", System::getProperty('os.name'))[1];
       
        $func = "SetWindowBlur{$winVer}";
        
        switch ($winVer){
            case 10 :
            case 7  :
                DFFI::$func($formTitle);
                return true;
            break;
            
            case 8   :
            case 8.1 :
                throw new Exception("На данный момент поддержка Acrylic не осуществляется.");
            break;
            
            default : 
                throw new Exception("Ошибка: Приложение не может запустить Acrulic.");
        }
        
        return false;
        
    }
    
}
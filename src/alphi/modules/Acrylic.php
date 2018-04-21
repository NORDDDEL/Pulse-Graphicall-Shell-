<?php
namespace alphi\modules;

use system\DFFIType;
use system\DFFI;
use std, gui, framework, alphi;


class Acrylic extends AbstractModule
{

    /**
     * @event timer.action 
     */
    function doTimerAction(ScriptEvent $e = null)
    {    
         
        $DNWBU = new DFFI("DNWBU");
        $DNWBU->bind("SetWindowBlur10", DFFIType::INT, [DFFIType::STRING]);
        

        DFFI::SetWindowBlur10("Form");
        DFFI::SetWindowBlur10("Home->panel");
    }

}

<?php
namespace alphi\forms;

use std, gui, framework, alphi;
use php\gui\event\UXEvent; 
use libs\UXBlur;

class panel extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow($onclik)
    {    
        Animation::fadeOut($this, 1, function () use ($event) {
        Animation::fadeIn($this, 80);
        Animation::displace($this, 80, 0.0, -15.0, function () use ($event) {
        Animation::displace($this, 80, 0.0, -10.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, -5.0, function () use ($event) {
        });
        });
        });
        }); 
    }


    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        Animation::displace($this, 70, 0.0, 5.0, function () use ($event) {
        Animation::displace($this, 70, 0.0, 10.0, function () use ($event) {
        Animation::displace($this, 70, 0.0, 15.0, function () use ($event) {
        Animation::fadeOut($this, 250);
        });
        });
        });
        waitAsync(701, function (){
        $this->hide();
        });
    }

}

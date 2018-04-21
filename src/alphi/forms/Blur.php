<?php
namespace alphi\forms;

use std, gui, framework, alphi;
use libs\UXBlur;
use action\Animation; 


class Blur extends AbstractForm
{

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
  //   $this->fullScreen = true;
    }

    /**
     * @event construct 
     */
    function doConstruct(UXEvent $e = null)
    {    
         new UXBlur("./dnwbu.dll")->SetBlur($this->title);
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {
       app()->showForm('Menu'); 
      Animation::fadeOut($this, 1, function () use ($event) {
        Animation::fadeIn($this, 100); 
                });
        
        
    }

}

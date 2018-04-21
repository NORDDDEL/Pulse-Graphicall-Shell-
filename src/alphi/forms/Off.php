<?php
namespace alphi\forms;

use std, gui, framework, alphi;


class Off extends AbstractForm
{

    /**
     * @event button7.click 
     */
    function doButton7Click(UXMouseEvent $e = null)
    {
        Animation::scaleTo($this->panel, 100, 0.9);
         
         Animation::fadeOut($this->panel, 100);
    }

    /**
     * @event button.click 
     */
    function doButtonClick(UXMouseEvent $e = null)
    {
        Animation::scaleTo($this->panel, 100, 0.9);
         
         Animation::fadeOut($this->panel, 100);
    }


}

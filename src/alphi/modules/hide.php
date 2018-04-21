<?php
namespace alphi\modules;

use std, gui, framework, alphi;


class hide extends AbstractModule
{

    /**
     * @event timer.action 
     */
    function doTimerAction(ScriptEvent $e = null)
    {    
                   Animation::fadeTo($this, 500, 0.0, function () use ($e, $event) {});
           $this->form('NotificationPanel')->hide();
    }

}

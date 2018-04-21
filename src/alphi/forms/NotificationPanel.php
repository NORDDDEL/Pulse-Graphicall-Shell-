<?php
namespace alphi\forms;

use std, gui, framework, alphi;


class NotificationPanel extends AbstractForm
{

    /**
     * @event rect.mouseEnter 
     */
    function doRectMouseEnter(UXMouseEvent $e = null)
    {    
        
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        
           $screen = UXScreen::getPrimary();
            $width = $screen->bounds['width'];
            $height = $screen->bounds['height'];
            $this->form('NotificationPanel')->x = $width - 376;
            $this->form('NotificationPanel')->y = $height - 50;
            $this->show();
            Animation::fadeOut($this, 1, function () use ($event) {
            Animation::fadeIn($this, 250);
            Animation::displace($this, 200, 0.0, -15.0, function () use ($event) {
            Animation::displace($this, 100, 0.0, -10.0, function () use ($event) {
            Animation::displace($this, 150, 0.0, -5.0, function () use ($event) {
            });
            });
            });
            });
            waitAsync(5000, function () {
            Animation::fadeTo($this, 500, 0.0, function () use ($e, $event) {});
            $this->form('NotificationPanel')->hide();
            });

           
           }

    /**
     * @event construct 
     */
    function doConstruct(UXEvent $e = null)
    {    
         new UXBlur("./dnwbu.dll")->SetBlur($this->title);
    }
           
     function start($notificationpanel){
        $this->form('NotificationPanel')->labelAlt->text = "$notificationpanel";
        $this->form('NotificationPanel')->doShow();
        }
        
     function start1($notificationpanel1){
     $this->form('NotificationPanel')->label->text = "$notificationpanel1";
     $this->form('NotificationPanel')->doShow();
        
    
    
    }

}

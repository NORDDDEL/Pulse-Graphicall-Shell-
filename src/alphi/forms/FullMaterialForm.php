<?php
namespace alphi\forms;

use action\Animation;
use std, gui, framework, alphi;
use php\gui\event\UXWindowEvent; 
use php\gui\event\UXMouseEvent; 


class FullMaterialForm extends AbstractForm
{


    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    

}

    /**
     * @event button5.click 
     */
    function doButton5Click(UXMouseEvent $e = null)
    {
                Animation::displace($this, 50, 0.0, 5.0, function () use ($event) {
                Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
                Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
                Animation::fadeOut($this, 250);
                });
                });
                });
                waitAsync(700, function (){
                $this->hide();
                $this->hideform();
                });
    }

    /**
     * @event button7.click 
     */
    function doButton7Click(UXMouseEvent $e = null)
    {
       Animation::scaleTo($this->panel, 100, 0.9);
        
        Animation::fadeOut($this->panel, 100);
       
    }



    /**
     * @event button10.click 
     */
    function doButton10Click(UXMouseEvent $e = null)
    {
        Animation::displace($this, 50, 0.0, 5.0, function () use ($event) {
                Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
                Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
                Animation::fadeOut($this, 250);
                });
                });
                });
                waitAsync(700, function (){
                $this->hide();
                $this->hideform();
                });
    }

    /**
     * @event button8.click 
     */
    function doButton8Click(UXMouseEvent $e = null)
    {
        Animation::displace($this, 50, 0.0, 5.0, function () use ($event) {
                Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
                Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
                Animation::fadeOut($this, 250);
                });
                });
                });
                waitAsync(700, function (){
                $this->hide();
                $this->hideform();
                });
    }

    /**
     * @event buttonAlt.click 
     */
    function doButtonAltClick(UXMouseEvent $e = null)
    {
                Animation::displace($this, 50, 0.0, 5.0, function () use ($event) {
                Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
                Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
                Animation::fadeOut($this, 250);
                });
                });
                });
                waitAsync(700, function (){
                $this->hide();
                $this->hideform();
                });
    }
    
}

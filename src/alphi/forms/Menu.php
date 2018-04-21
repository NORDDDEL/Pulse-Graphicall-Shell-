<?php
namespace alphi\forms;

use php\lang\Thread;
use php\gui\layout\UXTilePane;
use php\gui\UXTabPane;
use Exception;
use std, gui, framework, alphi;
use bundle\windows\Windows;
use php\io\File;
use php\lib\fs;
use php\gui\UXImage;
use php\gui\event\UXMouseEvent; 
use php\gui\event\UXKeyEvent; 
use php\gui\event\UXScrollEvent; 
use php\gui\event\UXWindowEvent; 
use php\gui\event\UXEvent; 

class menu extends AbstractForm
{


    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
            
            $screen = UXScreen::getPrimary();
            $width = $screen->bounds['width'];
            $height = $screen->bounds['height'];
            $this->y = $height - 646;
            $this->x = 0;
            $this->y += 25;
            Animation::fadeOut($this, 1, function () use ($event) {Animation::fadeIn($this, 250);Animation::displace($this, 200, 0.0, -15.0, function () use ($event) {Animation::displace($this, 100, 0.0, -10.0, function () use ($event) {Animation::displace($this, 150, 0.0, -5.0, function () use ($event) {});});});}); 
    
            $dir = fs::abs("./plugins/apps/");
            $directory = new File($dir);
            global $apps;
            $apps = [];
            global $id;
            $id = -1;
            foreach ($directory->findFiles() as $one) {
            if ($one->isDirectory()) {
                        $this->label->hide();
                        $id++;
                        $apps[$id] = $one;
                        $panel = new UXPanel();
                        $panel->size = [80, 70];
                        $panel->borderWidth = 0;
                        $app = fs::abs("$apps[$id]/app.php");
                        include "$app";
                        $label = new UXLabel("$title");
                        $label->width = 80;
                        $label->height = 70;
                        $label->alignment = "BOTTOM_CENTER";
                        $label->textColor = "#ffffff";
                        $appicon = new UXImageView(new UXImage("./plugins/icons/". $icon));
                        $appicon->x = 16;
                        $appicon->y = 6;
                        $appicon->width = 45;
                        $appicon->height = 45;
                        $appicon->centered = true; 
                        $appicon->stretch = true; 
                        $i = new DropShadowEffectBehaviour();
                        $i->color = "#00000008";
                        $i->apply($appicon);
                        global $appfile;
                        $appfile[$id] = fs::abs("$apps[$id]/$file");
                        $panel->on('click', function() use ($id, $callback, $nogui){
                        global $appfile;
                        Animation::displace($this, 200, 0.0, 5.0, function () use ($event) {
                        Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
                        Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
                        Animation::fadeOut($this, 250);
                            
                       });
                       });
                       });
                            
                       waitAsync(701, function (){
              
          $this->hide();
          $this->hideform();
          $this->tilePane->free();
          $tilePane = new UXTilePane();
          $tilePane->hgap = 0;
          $tilePane->vgap = 0;
          $tilePane->alignment = "TOP_LEFT";
          $tilePane->tileAlignment = "CENTER";
          $tilePane->x = 728;
          $tilePane->y = 120;
          $tilePane->minWidth = 480;
          $tilePane->maxHeight = 264;
          $tilePane->id = "tilePane";
          $this->add($tilePane);
          });
          if ($callback){
          $callback();
          } else {
          open($appfile[$id]);
          }
          });
          $panel->add($label);
          $panel->add($appicon);
          $this->tilePane->add($panel);
                        
          } else {
                    
          $this->label->show();
         }
       }       
    }

    /**
     * @event image.click 
     */
    function doImageClick(UXMouseEvent $e = null)
    {    
        Animation::displace($this, 250, 0.0, 5.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, 10.0, function () use ($event) {
        Animation::displace($this, 170, 0.0, 15.0, function () use ($event) {
        Animation::fadeOut($this, 250);
        });
        });
        });
        
            waitAsync(700, function (){
        
            $this->hide();
            $this->hideform();
            $this->tilePane->free();
            $tilePane = new UXTilePane();
            $tilePane->hgap = 0;
            $tilePane->vgap = 0;
            $tilePane->alignment = "TOP_LEFT";
            $tilePane->tileAlignment = "CENTER";
            $tilePane->x = 8;
            $tilePane->y = 56;
            $tilePane->minWidth = 480;
            $tilePane->maxHeight = 264;
            $tilePane->id = "tilePane";
            $this->add($tilePane);
            });
    }

    /**
     * @event imageAlt.click 
     */
    function doImageAltClick(UXMouseEvent $e = null)
    {    
        Animation::displace($this, 200, 0.0, 5.0, function () use ($event) {
        Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
        Animation::fadeOut($this, 250);
        });
        });
        });
        
          waitAsync(700, function (){

             $this->tilePane->free();
             $tilePane = new UXTilePane();
             $tilePane->hgap = 0;
             $tilePane->vgap = 0;
             $tilePane->alignment = "TOP_LEFT";
             $tilePane->tileAlignment = "CENTER";
             $tilePane->x = 8;
             $tilePane->y = 56;
             $tilePane->minWidth = 480;
             $tilePane->maxHeight = 264;
             $tilePane->id = "tilePane";
             $this->add($tilePane);
             
             app()->showForm('');
             
             });
     }



    

    /**
     * @event scroll-Down 
     */
    function doScrollDown(UXScrollEvent $e = null)
    {    
        Animation::fadeOut($this, 250);
        Animation::displace($this, 200, 0.0, 15.0, function () use ($event) {
        Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, 5.0, function () use ($event) {
        
        waitAsync(750, function (){
        
        $this->hide();
        $this->hideform();
        
        });
        });
        });
        });
            
    }

}

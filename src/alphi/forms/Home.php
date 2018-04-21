<?php
namespace alphi\forms;

use Exception;
use bundle\windows\Task;
use alphi\modules\API;
use bundle\windows\Windows;
use std, gui, framework, alphi;
use action\Animation; 
use php\gui\event\UXKeyEvent; 
use php\gui\event\UXMouseEvent; 
use php\gui\event\UXEvent; 
use design\material\UXButton as UXMaterialButton;
use design\material\UXEdit as UXMaterialEdit;
use design\material\UXCircularProgress as UXMaterialProgress;
use php\gui\event\UXScrollEvent; 
use php\gui\UXImageView;
use php\time\Timer;




class Home extends AbstractForm
{
    public $bgIndex = 0;
    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {         

       $this->fullScreen = true;
       $image = $this->robot->screenshot();
        $this->imageAlt->imageAlt = $image;

       
       
       $batterypot = new Thread(function() use ($event){ 
          for ($i = 0; $i < 1; $i = $i + 0) {
                $battery = Windows::getBatteryInfo();
                uiLater(function() {
                    $battery = Windows::getBatteryInfo();
                    $batteryp = $battery['EstimatedChargeRemaining'] . "%";
                    $this->labelAlt->text = $batteryp;
                    });
                    $batterys = $battery['BatteryStatus'];
                    if ($batterys == 1) {
                    $bp = $battery['EstimatedChargeRemaining'];
                    if ($bp == 100)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_100.png");
                    elseif ($bp >= 90)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_90.png");
                    elseif ($bp >= 80)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_80.png");
                    elseif ($bp >= 60)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_60.png");
                    elseif ($bp >= 50)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_50.png");
                    elseif ($bp >= 30)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_30.png");
                    elseif ($bp <= 20)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_20.png");
                    elseif ($bp >= 20)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_20.png");
                
                    } else { 
                
                    $bp = $battery['EstimatedChargeRemaining'];
                    if ($bp == 100)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_100.png");
                    elseif ($bp >= 90)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_90.png");
                    elseif ($bp >= 80)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_80.png");
                    elseif ($bp >= 60)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_60.png");
                    elseif ($bp >= 50)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_50.png");
                    elseif ($bp >= 30)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_30.png");
                    elseif ($bp <= 20)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_20.png"); 
                    elseif ($bp >= 20)
                        Element::loadContentAsync($this->image, "res://.data/img/ic_battery_charging_20.png"); 
                
                    }
                    sleep(2);
                    }
                    });
        $batterypot->start();
       
        $wifi = new Thread(function() use ($event){ 
            for ($i = 0; $i < 1; $i = $i + 0) {
                $conect = file_get_contents('http://google.com/');
                if ($conect){
                    Element::loadContentAsync($this->image3, "res://.data/img/ic_signal_wifi_statusbar_4_bar_white_26x24dp.png");
                } else {
                    Element::loadContentAsync($this->image3, "res://.data/img/ic_signal_wifi_statusbar_connected_no_internet_white_26x24dp.png");
                }
                sleep(4);
                }
                });
                $wifi->start();

         if($this->iconified) { $this->iconified = false; }
                if (!fs::isFile("config.ini")){
                app()->hideForm('login');  
                app()->showForm('install');
                } else {
                app()->hideForm('login');  
                }
                }
                


    /**
     * @event scroll-Down 
     */
    function doScrollDown(UXScrollEvent $e = null)
    {
       app()->showForm('navpanel'); 
    }



    /**
     * @event keyDown-Alt+C 
     */
    function doKeyDownAltC(UXKeyEvent $e = null)
    {    
      app()->showFormAndWait('Console');  
    }


    /**
     * @event scroll-Up 
     */
    function doScrollUp(UXScrollEvent $e = null)
    {    
        app()->showFormAndWait('Menu');
    }


    /**
     * @event keyDown-Space 
     */
    function doKeyDownSpace(UXKeyEvent $e = null)
    {    
         app()->showFormAndWait('Menu');
    }


    /**
     * @event keyUp-PrintScreen 
     */
    function doKeyUpPrintScreen(UXKeyEvent $e = null)
    {  
        $notificationpanel = "Откройте панель уведомлений, чтобы просмотреть изображение ";
        $notificationpanel1 = "Снимок экрана"; 
        $this->form('NotificationPanel')->start($notificationpanel);  
        $this->form('NotificationPanel')->start1($notificationpanel1);  
        $screen = UXScreen::getPrimary();
        $width = $screen->bounds['width'];
        $height = $screen->bounds['height']; 
        $a = [
        'width' => $width,
        'height' => $height,
        'x' => 0,
        'y' => 0
        ];
        $image = $this->robot->screenshot($a);
        $filename = fs::abs('./snapshot.jpg');
        fs::ensureParent($filename);
        $image->save($filename, fs::ext($filename));
        $noit = [
        'app' => 'Фото',
        'text' => 'Нажмите, Чтобы просмотреть.',
        'svg' => 'img',
        'mode' => '2',
        'callback' => function () use ($event){
            open($filename);
        }
        ];
        $this->Notification($noit);
       
         
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
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
                $imageAlt = $this->robot->screenshot();
        $this->imageAlt->imageAlt = $imageAlt;
    }


    /**
     * @event slider.mouseUp 
     */
    function doSliderMouseUp(UXMouseEvent $e = null)
    {    
        $this->container->blurEffect->radius = $this->slider->value;
    }

    
    }
    
    
    
     /* Бутафор
        
        Окончание бутафора */ 

<?php
namespace alphi\forms;

use facade\Json;
use php\gui\UXImage;
use action\Animation;
use Exception;
use php\io\IOException;
use std, gui, framework, alphi;
use bundle\windows\Windows;
use php\gui\event\UXEvent; 
use php\gui\event\UXMouseEvent; 


class login extends AbstractForm
{
    
    private $data;
    
    function setBorderRadius($element, $radius)
    {    
        $rect = new \php\gui\shape\UXRectangle;
        $rect->size = $element->size;
 
        $rect->arcWidth = $radius*2;
        $rect->arcHeight = $radius*2;
 
        
        $element->clip = $rect;
        $circledImage = $element->snapshot();
 
        $element->clip = NULL;
        $rect->free();
 
        $element->image = $circledImage;                                                                                                                                                                                                      
    }
    
    function set($obj, $array, $call = null)
    {
        foreach ($array as $key => $value){
            $obj->{$key} = $value;
        }
        
        if ($call) 
            $call();
    }
    
    function drag()
    {
        $this->panel->chatterAnim->enable();
        waitAsync(500, function () use ($event) {
            $this->panel->chatterAnim->disable();
        });
    }
    
    function error($text)
    {
        $this->edit->focusColor = "#ff6666";
        $this->edit->unfocusColor = "#ff6666";
        $this->label4->text = $text;
        if ($this->label4->opacity == 0){
            Animation::moveTo($this->button3, 240, 48, 188);
            Animation::moveTo($this->button4, 240, 240, 188);
            Animation::fadeIn($this->label4, 240);
        } else {
            Animation::fadeTo($this->label4, 100, 0.6, function () use ($event) {
                Animation::fadeTo($this->label4, 100, 1, function () use ($event) {
                    Animation::fadeTo($this->label4, 100, 0.6, function () use ($event) {
                        Animation::fadeTo($this->label4, 100, 1);
                    });
                });
            });
        }
        
    }
    
    function doShow(UXWindowEvent $e = null)
    {   
        $this->data = Json::fromFile("config.json")['user'];
        $this->fullScreen = true;
            $user = $this->data['name'];
            $this->labelAlt->show();
            $this->labelAlt->text = $user;
            $pass = $this->ini->get(password, user); 
            Animation::fadeTo($this->rect, 500, 0.6);
            waitAsync(750, function () { 
                Animation::fadeTo($this->time, 250, 1.0);
                Animation::fadeTo($this->label3, 250, 1.00);
                waitAsync(500, function (){
                    Animation::fadeOut($this->panel, 1, function () use ($event) {
                    Animation::fadeIn($this->panel, 250);
                    Animation::displace($this->panel, 200, 0.0, -15.0, function () use ($event) {
                    Animation::displace($this->panel, 100, 0.0, -10.0, function () use ($event) {
                    Animation::displace($this->panel, 150, 0.0, -5.0, function () use ($event) {
                    });
                    });
                    });
                    }); 
                });
            });       
    }

   

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {   
        $this->edit->observer("focused")->addListener(function($oldValue, $newValue) use ($this) {
            if ($newValue == 1){
                if ($this->label5->y == 134){
                    Animation::scaleTo($this->label5, 200, 0.8);
                    Animation::displace($this->label5, 200, -19, -20);
                }
            } elseif ($newValue != 1) {
                if ($this->edit->text == null){
                    Animation::scaleTo($this->label5, 200, 1);
                    Animation::displace($this->label5, 200, 19, 20);
                } 
            }
        });
        
        $screen = UXScreen::getPrimary();
        $width = $screen->bounds['width'];
        $height = $screen->bounds['height'];
        
        $this->button4->graphic = new UXImageView(new UXImage('res://.data/img/ic_done_white_18dp.png'));
        
        if (fs::exists("user/100_ava.jpg")){
            $this->set($this->image3, [ 
                'image' => new UXImage("user/100_ava.jpg")
             ], function () use ($event) {
                 $this->setBorderRadius($this->image3, 50);
             });
        } else {
            $this->set($this->image3, [ 'opacity'  => 0 ]);
        }
        
        $this->set($this, [
            'fullscreen' => true
        ]);
        
        $this->set($this->rect, [
            'size'     => [ $width, $height ],
            'position' => [ 0, 0 ]
        ]);
        
        $this->set($this->time, [ 'opacity'  => 0 ]);
        
        $this->set($this->panel, [
            'position' => [ $width / 2 - 185, $height / 2 - 85 ],
            'opacity'  => 0
        ]);
        
        $this->set($this->rectAlt, [
            'width' => $width
        ]);
        
        $this->set($this->label3, [ 'opacity'  => 0 ]);
        
        $this->doShow();
    }


    /**
     * @event button3.action 
     */
    function doButton3Action(UXEvent $e = null)
    {    
        $this->button3->requestFocus();
        $this->error("Пока это не работает.");
    }

    /**
     * @event button4.action 
     */
    function doButton4Action(UXEvent $e = null)
    {    
        $this->button4->requestFocus();
        if ($this->edit->text){
            $pass = $this->data['password'];
            $md5 = md5($this->edit->text);
            if ($md5 == $pass){
                Animation::fadeOut($this->panel, 250);
                Animation::displace($this->panel, 200, 0.0, -15.0, function () use ($event) {
                Animation::displace($this->panel, 100, 0.0, -10.0, function () use ($event) {
                Animation::displace($this->panel, 150, 0.0, -5.0, function () use ($event) {
                $this->loadForm('Home');
                });
                });
                });
            } else {
                $this->error("Неверный пароль.");
            }  
        } else {
            $this->error("Заполните необходимые поля.");
        } 
    }

    /**
     * @event edit.click 
     */
    function doEditClick(UXMouseEvent $e = null)
    {    
        $this->edit->requestFocus();
    }


    




}

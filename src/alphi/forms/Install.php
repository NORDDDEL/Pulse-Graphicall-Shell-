<?php
namespace alphi\forms;

use facade\Json;
use action\Animation;
use std, gui, framework, alphi;
use php\gui\event\UXEvent; 
use php\gui\event\UXMouseEvent; 
use php\gui\UXFlatButton;
use design\material\UXButton as UXMaterialButton;


class install extends AbstractForm
{
    public $setmode = 0;
    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $this->y += 65;
        Animation::fadeOut($this, 1, function () use ($event) {
        Animation::fadeIn($this, 250);
        Animation::displace($this, 200, 0.0, -15.0, function () use ($event) {
        Animation::displace($this, 100, 0.0, -10.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, -5.0, function () use ($event) {
        });
        });
        });
        });
    }

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {    
        Animation::displace($this, 200, 0.0, 5.0, function () use ($event) {
        Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
        Animation::fadeOut($this, 250);
        });
        });
        });
        waitAsync(1000, function (){
            exit();
        });
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        $this->setup();
    }



    function setup(){
        if ($this->edit->text == null){
            $this->perror("Введите имя вашего ПК или планшета.");
        } elseif ($this->editAlt->text == null){
            $this->perror("Введите ваше имя.");
        } elseif ($this->passwordField->text == null){
            $this->perror("Введите пароль.");
        } elseif ($this->passwordField->text != $this->passwordFieldAlt->text){
            $this->perror("Пароли не совпадают.");
        } else {
            if ($this->setmode == 0){
                Animation::fadeOut($this->panelAlt, 500, function (){
                    Animation::displace($this->panel4, 500, -672, 0);
                    $this->panel5->x = 680;
                    $this->circleAlt->fillColor = "#6680e6";
                    $this->label4->font = $this->label3->font;
                });
                $this->setmode = 1;
            } elseif ($this->setmode == 1){
                Animation::fadeOut($this->panel4, 500, function (){
                    Animation::displace($this->panel5, 500, -672, 0);
                    $this->circle3->fillColor = "#6680e6";
                    $this->label5->font = $this->label3->font;
                    Json::toFile("config.json", [
                        'user' => [
                            'email'    => $this->edit->text,
                            'name'     => $this->editAlt->text,
                            'password' => md5($this->passwordField->text)
                        ]
                    ]);
                 });
                $this->setmode = 2;
            } elseif ($this->setmode == 2) {
                Animation::displace($this, 200, 0.0, 5.0, function () use ($event) {
                Animation::displace($this, 100, 0.0, 10.0, function () use ($event) {
                Animation::displace($this, 150, 0.0, 15.0, function () use ($event) {
                Animation::fadeOut($this, 250);
                });
                });
                });
                execute("cmd /c taskkill /f /im explorer.exe");
                $this->loadForm("Login");
            }
        }
    }
    
    function perror($text){
        $this->label15->text = $text;
        Animation::fadeIn($this->panel3, 240);
        waitAsync(1750, function (){
            Animation::fadeOut($this->panel3, 240);
        });
    }

}

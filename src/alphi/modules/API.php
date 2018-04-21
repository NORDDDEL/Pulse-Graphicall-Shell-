<?php
namespace alphi\modules;

use php\desktop\Runtime;
use php\windows\DFFIReferenceValue;
use php\windows\DFFIStruct;
use alphi\modules\API;
use php\gui\UXFlatButton;
use php\windows\DFFI;
use php\lang\Thread;
use bundle\windows\Windows;
use std, gui, framework, alphi;
use php\gui\framework\ScriptEvent; 


class API extends AbstractModule
{

    static public function set($obj, $array, $call = null)
    {
        foreach ($array as $key => $value){
            $obj->{$key} = $value;
        }
        
        if ($call) 
            $call();
    }

    public $lib;
    
    private $confirms = [];
    
    public function confirm($app, $type = "notification"){
        var_dump($this->confirms);
        foreach ($this->confirms as $kay => $val){
            var_dump($kay, $val);
            if ($kay == $app){
                return $val;
            }
        }
        $form = app()->getForm("info");
        $form->labelAlt->text = $app;
        if ($type == "notification")
        {
            $form->label3->text = "Доступ к рассылке уведомлений.";
            API::set($form->button3, [ 
                'style' => '-fx-shape: "M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z";',
                'width' => 32
            ]);
        } elseif ($type == "files"){
            $form->label3->text = "Доступ к файлом.";
            API::set($form->button3, [ 
                'style' => '-fx-shape: "M6 2c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6H6zm7 7V3.5L18.5 9H13z";',
                'width' => 32
            ]);
        }
        $form->showAndWait();
        if ($form->res == true){
            $form->free();
            $this->confirms[$app] = true;
            return true;
        } else {
            $form->free();
            $this->confirms[$app] = false;
            return false;
        }
    }
    static function error($text){
        app()->form('panel')->labelAlt->text = $text;
        app()->form('panel')->show();     
    }
    function Notification($arr){
        if (API::confirm($arr['app']))
            app()->form('navpanel')->cards($arr);
    }
    static function changeOpacity($object,$opacity,$interval=10,$callback=null){
        $timer = new TimerScript; 
        $timer->repeatable = true;
        $timer->interval = $interval;
        if($object->opacity > $opacity)
            $timer->on('action',function(ScriptEvent $e)use($object,$opacity,$callback){
                if($object->opacity > $opacity)
                    $object->opacity -= 0.01;
                else
                {
                    !is_callable($callback) ?: $callback();
                    $e->sender->stop();
                    $e->sender->free();
                }
            });
        elseif($object->opacity < $opacity)
            $timer->on('action',function(ScriptEvent $e)use($object,$opacity,$callback){
                if($object->opacity < $opacity)
                    $object->opacity += 0.01;
                else
                {
                    !is_callable($callback) ?: $callback();
                    $e->sender->stop();
                    $e->sender->free();
                }
            });
        else
            $timer->on('action',function(ScriptEvent $e){
                !is_callable($callback) ?: $callback();
            });
        $timer->start();
    }
    function bd($name, $time){
        global $bd;
        $bd['name'] = $name;
        $bd['time'] = $time;
        $bdt = new Thread( function() use ($name, $bdt) {
            global $bd;
            for ($i = 0; $i < 1; $i = $i + 0) {
                $t1 = $this->form('navpanel')->label->text;
                $time1 = explode(":", $t1);
                $time = $time1[0] . $time1[1];
                if ($bd['name'] == $name){
                    if ($bd['time'] == $time){
                        $this->navinfo("Будильник", $name,"noit","3");
                        break;
                    }
                }
            }
            sleep(10);
        });
        $bdt->start();
    }
    function bdstop($name){
        pre('Бутафор');
    }
    function bdslep($name){
        pre('Бутафор');
    }
        function aniDark ($type){
        switch ($type){
            case('start'):
            app()->getForm('black')->show();
            $img = new UXImageView();
            $img->image = $this->robot->screenshot();
            $img->size = [$img->image->width, $img->image->height];
            app()->getForm('black')->add($img);
            Animation::scaleTo($img, 200, 0.9);
            Animation::fadeOut($img, 200);
            waitAsync(2000 + ($GLOBALS['endInc'] - $GLOBALS['startInc']), function (){
                app()->getForm('Home')->opacity = 1;
                Animation::fadeOut(app()->getForm('black'), 300, function () use ($event) {
                    app()->hideForm('black');
                });
            });
            break;
        }
    }
    
    function openForm ($form){
        $this->form("$form")->show();
        Animation::fadeOut($this->form("$form"), 1, function () use ($event) {
    $this->form("$form")->y += 25;
    Animation::fadeIn($this->form("$form"), 250);
    Animation::displace($this->form("$form"), 200, 0.0, -15.0, function () use ($event) {
        Animation::displace($this->form("$form"), 100, 0.0, -10.0, function () use ($event) {
            Animation::displace($this->form("$form"), 150, 0.0, -5.0, function () use ($event) {
            });
        });
    });
        });
}

}
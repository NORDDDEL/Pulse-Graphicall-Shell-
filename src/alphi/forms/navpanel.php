<?php
namespace alphi\forms;

use php\gui\layout\UXHBox;
use php\gui\UXFlatButton;
use php\lang\Thread;
use php\gui\layout\UXVBox;
use php\gui\UXScreen;
use php\lib\fs;
use php\gui\UXImage;
use php\gui\UXImageView;
use behaviour\custom\DropShadowEffectBehaviour;
use php\gui\UXLabel;
use php\gui\shape\UXCircle;
use php\gui\shape\UXRectangle;
use php\gui\layout\UXPanel;
use php\gui\framework\AbstractForm;
use alphi\forms\navpanel;
use php\gui\event\UXWindowEvent; 
use action\Animation; 
use php\gui\event\UXScrollEvent; 
use php\gui\event\UXMouseEvent; 
use php\gui\event\UXEvent; 
use libs\UXBlur;


class navpanel extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {
        
        $screen = UXScreen::getPrimary();
        $width = $screen->bounds['width'];
        $height = $screen->bounds['height'];
        $this->form('navpanel')->x = $width - 449;
        $this->form('navpanel')->y = $height - 839;
       
        Animation::fadeOut($this, 1, function () use ($event) {
        Animation::fadeIn($this, 150);
        Animation::displace($this, 140, 0.0, -10.0, function () use ($event) {
        Animation::displace($this, 130, 0.0, -5.0, function () use ($event) {
        Animation::displace($this, 120, 0.0, -7.0, function () use ($event) {
        });
        });
        });
        });


        
        $time = new Thread(function () use ($event){
            for ($i = 0; $i < 1; $i = $i + 0){
                $j = substr($this->label3->text, 6);
                $b = explode(".", $j);
                $g = $b['1'];
                switch ($g){
                    case ('01'):
                        $mon = 'Января';
                        break;
                    case ('02'):
                        $mon = 'Февраля';
                        break;
                    case ('03'):
                        $mon = 'Марта';
                        break;
                    case ('04'):
                        $mon = 'Апрелья';
                        break;
                    case ('05'):
                        $mon = 'мая';
                        break;
                    case ('06'):
                        $mon = 'Июня';
                        break;
                    case ('07'):
                        $mon = 'Июля';
                        break;
                    case ('08'):
                        $mon = 'Августа';
                        break;
                    case ('09'):
                        $mon = 'Сентября';
                        break;
                    case ('10'):
                        $mon = 'Октября';
                        break;
                    case ('11'):
                        $mon = 'Ноября';
                        break;
                    case ('12'):
                        $mon = 'Декабря';
                        break;
                }
                uiLater(function () use ($b, $mon){
                    $this->labelAlt->text = $b['0'] . " " . $mon . ", " . $b['2'] . " Года.";
                });
                sleep(7);
            }
        });
        $time->start();
        
        // Generated
        $e = $event ?: $e; // legacy code from 16 rc-2
        
        Animation::fadeIn($this, 200, function () use ($e, $event) {
        });
    }

    /**
     * @event scroll-Up 
     */
    function doScrollUp(UXScrollEvent $e = null)
    {    
        Animation::displace($this, 240, $w, -80.0, function () use ($e, $event) {
            waitAsync(241, function (){
                $this->hide();
            });
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
     * @event construct 
     */
    function doConstruct(UXEvent $e = null)
    {    
         new UXBlur("./dnwbu.dll")->SetBlur($this->title);
    }


    
    function cards($arr){
        $app = $arr['app'];
        $text = $arr['text'];
        $icon = $arr['svg'];
        $mode = $arr['mode'];
        $onclick = $arr['callback'];
        $panel = new UXPanel();
        $panel->borderWidth = 0;
        $panel->maxWidth = 440;
        $panel->minHeight = 70;
        $panel->backgroundColor = "null";
        
        $dropShadowEffect = new DropShadowEffectBehaviour();
        $dropShadowEffect->color = "#333";
        $dropShadowEffect->offsetY = 2;
        $rect = new UXRectangle();
        $rect->fillColor = "#fff";
        $rect->strokeWidth = 0;
        $rect->width = 440;
        $rect->height = 70;
        $rect->arcHeight = 2;
        $rect->arcWidth = 2;
        $dropShadowEffect->apply($rect);
        
        $circle = new UXCircle;
        $circle->fillColor = "#11a9e8";
        $circle->strokeWidth = 0;
        $circle->width = 30;
        $circle->y = 20;
        $circle->x = 25;
        
        $a_label = new UXLabel($app);
        $a_label->x = 80;
        $a_label->y = 16;
        
        $t_label = new UXLabel($text);
        $t_label->y = 32;
        $t_label->x = 80;
        $t_label->opacity = 0.5;
        
        $time = new UXLabel($this->label->text);
        $time->y = 16;
        $time->x = 500;
        $time->opacity = 0.5;
        
        switch ($icon) {
            case ('app') :
                $i = $icon;
                $circle->fillColor = "#00c081";
                break;
            case ('dev') :
                $i = $icon;
                break;
            case ('security') :
                $i = $icon;
                $circle->fillColor = "#fec200";
                break;
            case ('noit') :
                $i = $icon;
                $circle->fillColor = "#fec200";
                break;
            case ('img') :
                $i = $icon;
                $circle->fillColor = "#fec200";
                break;
            default: 
                $i = 'app';
                break;
        }
        
        $img = new UXImageView(new UXImage("res://.data/img/" . $i . ".png"));
        $img->width = 18;
        $img->height = 18;
        $img->x = 31;
        $img->y = 26;
        $panel->on('click', function () use ($onclick){
            if ($onclick){
                $onclick();
            }
        });
        if ($mode == 2)
            $rect->height += 305; 
        $panel->add($rect);
        $panel->add($circle);
        $panel->add($time);
        $panel->add($t_label);
        $panel->add($a_label);
        $panel->add($img);
        if ($mode == 2){
            $s = fs::abs('./snapshot.jpg');
            $snapshot = new UXImageView(new UXImage($s));
            $snapshot->width = 440;
            $snapshot->height = 305;
            $snapshot->y = 70;
            $snapshot->x = 0;
            $panel->on('click', function () use ($s, $panel){
                open($s);
                $panel->free();
                $this->doScrollUp();
            });
            $panel->add($snapshot);
        }
        $this->vbox->add($panel);
    } 
}

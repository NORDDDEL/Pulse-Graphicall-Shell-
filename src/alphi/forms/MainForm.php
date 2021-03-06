<?php
namespace alphi\forms;

use bundle\windows\Windows;
use std, gui, framework, alphi;
use Animation;
use php\gui\event\UXMouseEvent; 


class MainForm extends AbstractForm
{

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
         
         $tilepane = new UXTilePane();
         $tilepane->orientation = 'HORIZONTAL'; 
         $tilepane->prefColumns = 3;
         $tilepane->prefRows = 3;
         $tilepane->minSize = [635, 500];
         $tilepane->hgap = 0;
         $tilepane->vgap = 0; 
         $tilepane->alignment = 'TOP_LEFT';
         $tilepane->tileAlignment = 'TOP_LEFT';
         $tilepane->prefTileWidth = -1;
         $tilepane->prefTileHeight = -1;
         $tilepane->paddingTop = 5;
         $tilepane->paddingRight = 5; 
         $tilepane->paddingBottom = 5; 
         $tilepane->paddingLeft = 5; 
         $tilepane->id = 'tilePane';
         $tilepane->backgroundColor = 'null';
         $tilepane->style = "-fx-border-width: 0";
         $this->container->content->add($tilepane);  
         $this->doButtonAction(); 
    }



    /**
     * @event panelAlt.mouseExit 
     */
    function doPanelAltMouseExit(UXMouseEvent $e = null)
    {    
        $this->panelAlt->hide();
    }


    /**
     * @event container.click-Left 
     */
    function doContainerClickLeft(UXMouseEvent $e = null)
    {    
        $this->panelAlt->hide();
    }

    

    
    /**
     * @event button10.action 
     */
    function doButton10Action(UXEvent $e = null)
    {    
        $c = 'XA==';
        $dir = explode(base64_decode($c), $this->edit->text);
        $pop = array_pop($dir);
        $edit = $this->edit->text;
        $i = base64_decode($c) . $pop;
        $row = str_replace($i, "", $edit);
        var_dump($row);
        if (substr($row, 1) == ":"){
        $row = $row . base64_decode($c);
            
        }
        
        $this->edit->text = $row;
        $this->doButtonAction();
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {    
            $this->tilePane->children->clear();
            $list = null;                                      
            $directory = new File($this->edit->text);          
            $list = $directory->findFiles(); 
            if($list) {
            foreach ($list as $v) {   
                               
                     $imageBox = new UXVBox();
                     $imageBox->alignment = 'CENTER';
                     $imageBox->backgroundColor = 'none';
                     $imageBox->style = "-fx-border-width: 0;";
                     $imageBox->padding = 4;
                     $imageBox->spacing = 2;
                     $imageBox->maxSize = [100, 100];
                     if (fs::ext($v) == "exe"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/exe.png"));
                     } elseif (fs::ext($v) == "png" || fs::ext($v) == "jpg" || fs::ext($v) == "gif" || fs::ext($v) == "ico") {
                         $ImageArea = new UXImageArea(new UXImage($v));
                     } elseif (fs::ext($v) == null){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/folder.png"));
                     } elseif (fs::ext($v) == "zip"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/zip.png"));
                     } elseif (fs::ext($v) == "mp3"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/mp3.png"));
                     } elseif (fs::ext($v) == "php"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/php.png"));
                     } elseif (fs::ext($v) == "html"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/html.png"));
                     } elseif (fs::ext($v) == "css"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/css.png"));
                     } elseif (fs::ext($v) == "js"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/js.png"));
                     } elseif (fs::ext($v) == "mp4"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/mp4.png"));
                     } elseif (fs::ext($v) == "rar"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/rar.png"));
                     } elseif (fs::ext($v) == "7z"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/7z.png"));
                     } elseif (fs::ext($v) == "dnpro ject"){
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/dnbundle .png"));
                     } else {
                         $ImageArea = new UXImageArea(new UXImage("res://.data/img/file.png"));
                     }
                     $ImageArea->height = 45;
                     $ImageArea->proportional = true;
                     $ImageArea->width = 45;
                     $ImageArea->centered = true;
                     $ImageArea->stretch = true;
                     $ImageArea->smartStretch = true;
                     $ImageArea->id = "ImageArea";
                     $imageBox->id = "imageBox";
                     $img = $ImageArea->image;
                     $imageBox->on('click', function (UXMouseEvent $e) use ($v, $img, $imageBox) {
                     $this->menu($v, $img);
                     if ($e->clickCount >= 2) { 
                     if (fs::ext($v) == null){
                     $this->edit->text = $v;
                     $this->doButtonAction();
                                 
                     } else {
                     
                     open($v);
                     }
                     }
                     });
                     $imageBox->add($ImageArea);
                     
                     $Label = new UXLabel(fs::name($v));  
                     $Label->textColor = "#fff";
                     $Label->wrapText = true;            
                     $imageBox->add($Label);
                                       
                     $this->tilePane->add($imageBox);                                 
                     }             
                     } else {
                     $this->label3->show();
        }
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        Animation::fadeOut($this, 1, function () use ($event) {
        Animation::fadeIn($this, 70);
        Animation::displace($this, 100, 0.0, -15.0, function () use ($event) {
        Animation::displace($this, 100, 0.0, -10.0, function () use ($event) {
        Animation::displace($this, 150, 0.0, -5.0, function () use ($event) {
        });
        });
        });
        }); 
    }

    /**
     * @event container.click-Right 
     */
    function doContainerClickRight(UXMouseEvent $e = null)
    {    
             
             
             $this->panelAlt->show();
    }

    /**
     * @event button5.action 
     */
    function doButton5Action(UXEvent $e = null)
    {
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    /**
     * @event button6.action 
     */
    function doButton6Action(UXEvent $e = null)
    {
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    /**
     * @event button7.action 
     */
    function doButton7Action(UXEvent $e = null)
    {
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    /**
     * @event button8.action 
     */
    function doButton8Action(UXEvent $e = null)
    {
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    /**
     * @event button9.action 
     */
    function doButton9Action(UXEvent $e = null)
    {
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    /**
     * @event button11.action 
     */
    function doButton11Action(UXEvent $e = null)
    {
        global $d;
        $d = $this->edit->text;
        app()->showForm('mkdir');
    }

    /**
     * @event click-Left 
     */
    function doClickLeft(UXMouseEvent $e = null)
    {    
        $this->panelAlt->hide();
    }

    /**
     * @event click-Right 
     */
    function doClickRight(UXMouseEvent $e = null)
    {    
       $this->panelAlt->show();
        $x = $this->robot->x - $this->x - 20;
        $y = $this->robot->y - $this->y - 20;
        $this->panelAlt->x = $x;
        $this->panelAlt->y = $y;
    }


     
    function menu($file, $img){
        $this->panelAlt->show();
        $x = $this->robot->x - $this->x - 20;
        $y = $this->robot->y - $this->y - 20;
        $this->panelAlt->x = $x;
        $this->panelAlt->y = $y;
        $this->button3->on('click', function () use ($file){
            $filealt = new File($file);
            
            if ($filealt->delete()) {
                $this->panelAlt->hide();
                $this->doButtonAction();
                alert('Файл успешно удален');
            } else {
                $this->panelAlt->hide();
                $this->doButtonAction();
                alert('Ошибка удаления');
            }
        
        });
        $this->button4->on('click', function () use ($file, $img){
        $this->panelAlt->hide();
        $this->form('fileinfo')->doShow($file, $img);
        });
        
    }
    
}

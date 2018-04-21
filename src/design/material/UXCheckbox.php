<?
/*
 * Анимированный checkbox
 *
 * Параметры:
 * ->backgroundColor 

 * ->boxSize
 * ->boxStroke
 * ->boxColor
 
 * ->textAlignment   
 * ->clickColor      
 * ->textColor       
 * ->font      
 */

namespace design\material;

use design\UXBase;

use php\gui\layout\UXPanel;
use php\gui\layout\UXVBox;
use php\gui\UXLabel;
use php\gui\event\UXMouseEvent;
use php\gui\paint\UXColor;
use php\gui\shape\UXCircle;

use action\Animation;
use php\gui\UXDesktop;
use php\gui\effect\UXDropShadowEffect;
use php\gui\text\UXFont;
use script\TimerScript;

class UXCheckbox extends UXBase{   
    protected 	$label,
                $boxParent,
                $box,
                $size, // Размер box, размер boxParent = box * self::PARENTBOX_K
                $checkStatus = false,
                $noAnim = false,
                $callback/*,  
    			$clickColor,
    			$onClick,
    			$shadow*/;

    public function __construct($text = NULL){
        parent::__construct();
        $this->rootPanel->classes->add('ux-material-checkbox');
        $this->rootPanel->content->classes->add('ux-material-checkbox-content');

        $this->box = new UXVBox;
        $this->box->alignment = 'CENTER';
        $this->box->classes->add('ux-material-checkbox-box');

        $this->boxParent = new UXPanel;
        $this->boxParent->classes->add('ux-material-checkbox-boxparent');
        $this->boxParent->alignment = 'CENTER';
        $this->boxParent->add($this->box);

        $this->label = new UXLabel($text, $this->boxParent);
        $this->label->classes->add('ux-material-checkbox-label');
        parent::addChildren($this->label);

        $this->label->on('click', function($e){
            $this->clickEvent($e);
        });

        $this->boxSize = 20;
        $this->width   = 150;
        $this->height  = 40;
    }
    
    private function clickEvent(UXMouseEvent $e){
        $this->checked = !$this->checkStatus;
    }

    const PARENTBOX_K = 1.9;
    const ROTATE_TO = 40;
    const ROTATE_STEP = 5;

    private function animateStart($onFinish = null){
        if($this->noAnim) return;
        $this->noAnim = true;

        $radius = $this->size * self::PARENTBOX_K / 2;
        $c = new UXCircle($radius);
        $c->classes->add('ux-material-checkbox-click');
        if($this->checkStatus) $c->classes->add('ux-material-checkbox-checked');

        $c->x = $c->y = 0;
        parent::addChildren($c);

        Animation::fadeOut($c, 500, function() use ($c, $onFinish){                  
            $c->free(); 
        });
        TimerScript::executeAfter(100, $onFinish);
    }

    private function animateCheckOn($onFinish = null){
      //  if($this->noAnim) return;
       // $this->noAnim = true;
        
        $this->animateStart(function() use ($onFinish){   
            $stepA = ($this->size - 1) / (self::ROTATE_TO / self::ROTATE_STEP);
            $animationA = function() use ($stepA){
                $this->box->rotate += self::ROTATE_STEP;
                $newSize = $this->box->size[0]-$stepA;
                $this->box->size = [$newSize, $newSize];
                $this->box->y = $this->box->x = ($this->size * self::PARENTBOX_K - $newSize) / 2;
                return $this->box->rotate >= self::ROTATE_TO;
            };

            $stepB = ($this->size - 1) / (self::ROTATE_TO / self::ROTATE_STEP);
            $animationB = function() use ($stepB){
                //$this->box->rotate += 5;
                $newSize = $this->box->size[1]+$stepB;
                $this->box->size = [$newSize/2, $newSize];
               
                $this->box->x = (($this->size * self::PARENTBOX_K - $newSize/2) / 2);
                $this->box->y = (($this->size * ((sqrt(2) + self::PARENTBOX_K)/2) - $newSize) / 2) ;

                return $newSize >= $this->size;
            };

            TimerScript::executeWhile(
                $animationA,

                function() use ($onFinish, $animationB){

                    $this->box->classes->add('ux-material-checkbox-checked');

                    TimerScript::executeWhile($animationB, function() use ($onFinish){
                        $this->noAnim = false;
                        if(is_callable($onFinish)){
                            call_user_func($onFinish, NULL);
                        }

                    },  $this->ANIM_TIME);
                },
                
                $this->ANIM_TIME
            );
        });
    }

    private function animateCheckOff($onFinish = null){
       // if($this->noAnim) return;
        //$this->noAnim = true;

        $this->animateStart(function() use ($onFinish){     
            $stepA = ($this->size - 1) / (self::ROTATE_TO / self::ROTATE_STEP);

            $animationA = function() use ($stepA){
                $newSize0 = $this->box->size[0]-$stepA;
                $newSize1 = $this->box->size[1]-$stepA*2;

                $this->box->size = [$newSize0, $newSize1];
                
                $this->box->x = ($this->size * self::PARENTBOX_K - $newSize0) / 2;
                $this->box->y = ($this->size * self::PARENTBOX_K - $newSize1) / 2;

                return $newSize0 <= 2;
            };

            $stepB = ($this->size - 1) / (self::ROTATE_TO / self::ROTATE_STEP);
            $animationB = function() use ($stepB){
                $this->box->rotate -= self::ROTATE_STEP;

                $newSize = $this->box->size[0]+$stepB;
                $this->box->size = [$newSize, $newSize];

                $this->box->x = ($this->size * self::PARENTBOX_K - $newSize) / 2;
                $this->box->y = ($this->size * self::PARENTBOX_K - $newSize) / 2;

                return $this->box->rotate <= 0;
            };

            TimerScript::executeWhile(
                $animationA,

                function() use ($onFinish, $animationB){

                    $this->box->classes->remove('ux-material-checkbox-checked');
                    TimerScript::executeWhile($animationB, function() use ($onFinish){
                        $this->boxSize = $this->size;
                        $this->noAnim = false;
                        if(is_callable($onFinish)){
                            call_user_func($onFinish, NULL);
                        }
                    },  $this->ANIM_TIME);
                },
                
                $this->ANIM_TIME
            );
        });
    }

    public function onChange($func){
        $this->callback = $func;
    }
    
    public function __get($key){
        switch($key){     
            case 'checked':
                return $this->checkStatus;
            break;
        }        

        return null;
    }

    public function __set($key, $value){
        parent::__set($key, $value);

        switch($key){     

            case 'id':
            case 'x':
            case 'y':
            case 'width':
            case 'height':
            case 'backgroundColor':
            case 'skin':
            break;

            case 'boxSize':
                $this->size = $value;
                $parentSize = $value * self::PARENTBOX_K;
                $this->boxParent->size = [$parentSize, $parentSize];
                $this->box->size = [$value, $value];
                $this->box->y = $this->box->x = $this->size * (self::PARENTBOX_K - 1) / 2;
                //$this->box->x = $this->box->y = ($parentSize - $value) / 2;
          
            break;
            
            case 'boxStyle':
                $this->box->style = $value;
            break;

            case 'checked':
                if(!$this->checkStatus){
                    $this->animateCheckOn(function(){
                        $this->checkStatus = true;
                        if(is_callable($this->callback)){
                           call_user_func($this->callback, $this->checkStatus);
                        }
                    });
                } else {
                    $this->animateCheckOff(function(){
                        $this->checkStatus = false;
                        if(is_callable($this->callback)){
                           call_user_func($this->callback, $this->checkStatus);
                        }
                    });
                }
            break;

            default:
                $this->text->{$key} = $value;
        }
    }
}
<?
/*

 */
namespace design\material;

use design\material\UXCircularProgress;
use design\UXBase;
use script\TimerScript;

class UXPreloader extends UXCircularProgress{   
    protected $timerFill, $timerLong, $position = 0, $area = 5;
    public function __construct(){
        parent::__construct();
        $this->size = 50;
        $this->label->free();
  
        $this->timerFill = new TimerScript(ANIM_TIME * 5, true, function(){
            $this->position = ($this->position < 100) ? $this->position+1 : 0;
            $to = $this->position + $this->area;
            $to = ($to > 100) ? ($to - 100) : $to;
            $this->fill = [$this->position , $to];
        });

        $this->timerLong = new TimerScript(3000, true, function(){
            TimerScript::executeWhile(function(){
                $this->area += 1;
                return $this->area >= 70;
            }, function(){
                TimerScript::executeAfter(300, function(){
                    TimerScript::executeWhile(function(){
                        $this->area -= 1;
                        return $this->area <= 5;
                    }, function(){}, ANIM_TIME * 10);
                });
            }, ANIM_TIME);
        });
        //$this->fill = [0, 30];
    }

    public function start(){
        //$this->timerUpdate->start();
        $this->timerFill->start();
        $this->timerLong->start();
    }
}
<?
/*

 */
namespace design\material;

use design\UXBase;
use php\gui\UXLabel;
use php\gui\shape\UXCircle;
use php\gui\shape\UXRectangle;

class UXCircularProgress extends UXBase{   
    protected $background, $scales = [], $label, $center, $thick = 0.2;

    public function __construct($text = NULL){
        parent::__construct();

        $this->rootPanel->classes->add('ux-material-circlular-progress');
        $this->rootPanel->content->classes->add('ux-material-circlular-progress-content');

        $this->background = new UXCircle;
        $this->background->classes->add('ux-material-circlular-progress-background');
        parent::addChildren($this->background);

        for($i = 0; $i < 360; ++$i){
            $this->scales[$i] = new UXRectangle;
            $this->scales[$i]->classes->add('ux-material-circlular-progress-scale');
            $this->scales[$i]->width = 2;
            parent::addChildren($this->scales[$i]);
        }


        $this->center = new UXCircle;
        $this->center->classes->add('ux-material-circlular-progress-center');
        parent::addChildren($this->center);

        $this->label = new UXLabel;
        $this->label->classes->add('ux-material-circlular-progress-label');
        $this->label->alignment        = 'CENTER';
        $this->label->textAlignment    = 'CENTER';
        parent::addChildren($this->label);

        // Параметры по умолчанию
        $this->size = 100;
        $this->position = 0;
    }
    
    public function __set($key, $value){
        parent::__set($key, $value);

        switch($key){            
            case 'size':
                $this->width = $value;
                $this->height = $value;

                $radius = $value / 2;

                $this->borderRadius = $radius;

                $this->background->radius =$radius;
                $this->background->x = $this->background->y = 0;
                foreach( $this->scales as $angle => $v){
                    $v->height = $radius;
                    
                    $y = (-cos(deg2rad($angle)) + 1) / 2;
                    $x = (sin(deg2rad($angle)) + 2) / 2;
                    
                    $v->y = $radius * $y;
                    $v->x = ($radius-1) * $x;

                    $v->rotate = $angle;
                }
                $this->center->radius = $radius - $radius * $this->thick;
                $this->center->x = $this->center->y = $radius * $this->thick;

                $this->label->x = 0;
                $this->label->y = 0;
                $this->label->width = $value;
                $this->label->height = $value;
            break;
          
            case 'position':
                $value = is_array($value) ? $value : [0, $value];
                list($from, $to) = $value;
                $this->label->text = ((string) ((($to < $from) ? ($to + 100) : $to) - $from)) . '%';

                $from = round($from / 100 * 360);
                $to = round($to / 100 * 360);

                foreach( $this->scales as $angle => $v){
                    if($from <= $to)$v->visible = ($angle >= $from && $angle <= $to);
                    else $v->visible = ($angle >= $from || $angle <= $to);
                }

            break;
        }
    }
}
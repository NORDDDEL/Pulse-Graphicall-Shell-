?
/*
 * Плоская кнопка с анимацией как в android 5
 *
 * Параметры:
 * ->textAlignment   
 * ->clickColor      
 * ->textColor       
 * ->backgroundColor 
 * ->font      
 * ->borderRadius   
 *
 .ux-material-button-container{
    .ux-material-button{
        .ux-material-button-clicked,
        .ux-material-button-text
    }
 }
 */
namespace design\material;

use action\Animation;
use design\UXBase;
use design\UXCircled;
use php\gui\UXDesktop;
use php\gui\UXFlatButton;
use php\gui\effect\UXDropShadowEffect;
use php\gui\event\UXMouseEvent;
use php\gui\paint\UXColor;
use php\gui\shape\UXCircle;
use php\gui\text\UXFont;
use script\TimerScript;

class UXButton extends UXBase{   
    protected     $button,  
                $clickColor,
                $onClick,
                $shadow;

    public function __construct($text = NULL){
        parent::__construct();
        $this->rootPanel->classes->add('ux-material-button');
        $this->rootPanel->content->classes->add('ux-material-button-content');

        $this->button = new UXFlatButton;
        $this->button->classes->add('ux-material-button-text');
        $this->button->textFill = "#334db3";
        $this->button->color = UXColor::of('#00000000');
        $this->button->text = $text;

           $this->button->on('click', function(UXMouseEvent $e){
            $c = new UXCircle(1);
            parent::addChildren($c);

            $c->strokeWidth = 0;
            $c->classes->add('ux-material-button-clicked');
            $c->fillColor = $this->clickColor;
            $c->toBack();

            $mouse = (new UXDesktop)->getCursorPosition();
            $c->x = $mouse[0] - $this->rootPanel->screenX - $c->radius/2;
            $c->y = $mouse[1] - $this->rootPanel->screenY - $c->radius/2;

                   
            TimerScript::executeWhile(
                function() use ($c){
                    $c->radius += 15;
                    return $c->radius > sqrt( 
                        pow($this->rootPanel->width, 2) + 
                        pow($this->rootPanel->height, 2)
                    );
                },
                function() use ($c){
                    Animation::fadeOut($c, 100, function() use ($c){                  
                        $c->free(); 
                    });
                },
                1/60*1000
            );
            
            if(is_callable($this->onClick)){
                call_user_func($this->onClick, $e);
            }
        });

        parent::addChildren($this->button);

        // Параметры по умолчанию
        $this->alignment         = 'CENTER';
        $this->textAlignment     = 'CENTER';
        $this->borderRadius      = 2; 
        $this->width             = 100;
        $this->height            = 50;
    }
    
    public function onClick($func){
        $this->onClick = $func;
    }
    
    public function __set($key, $value){
        parent::__set($key, $value);

        switch($key){            
            case 'x':
            case 'y':
            case 'color':
            case 'id':
            case 'backgroundColor':
            break;

            case 'clickColor':
                $this->clickColor = $value;
            break;

            default:
                $this->button->{$key} = $value;
        }
    }
}
<?
namespace design;

use php\gui\UXNode;
use php\gui\shape\UXRectangle;

class UXCircled{   
    protected $element;

    public static function of($element){
        return new self($element);
    }

    public function __construct(UXNode $element){
        $this->element = $element;

        if(is_null($this->element->clip)){
            $this->element->clip = new UXRectangle;
            $this->element->clip->width = $this->element->width;
            $this->element->clip->height = $this->element->height;
        }
    }

    public function setBorderRadius($radius){
        $this->element->clip->arcWidth = $radius*2;
        $this->element->clip->arcHeight = $radius*2;
    }

    public function __call($method, $args){
        return call_user_func($this->element->{$method}, $args);
    }

    public function __get($key){
        return $this->element->{$key};
    }

    public function __set($key, $value){
        switch($key){
            case 'borderRadius':
                $this->setBorderRadius($value);
            break;

            case 'width':
            case 'height':
                $this->element->{$key} = $value;
                $this->element->clip->{$key} = $value;
            break;

            default:
                $this->element->{$key} = $value;
        }
    }

    public function getElement(){
        return $this->element;
    }

    public function getRadius(){
        return $this->element->clip->arcWidth;
    }
}
<?
namespace design;

use design\UXCircled;
use php\gui\layout\UXScrollPane;
use php\gui\layout\UXPanel;
use php\gui\paint\UXColor;

class UXBase{   
    const ANIM_TIME = 1/60*1000;
    protected $rootPanel, $params = [];

    public function __construct(){
        $this->rootPanel = new UXScrollPane;
        $this->rootPanel->vbarPolicy = 'NEVER';
        $this->rootPanel->hbarPolicy = 'NEVER';
        $this->rootPanel->content = new UXPanel;
        $this->rootPanel->content->borderWidth = 0;
        $this->rootPanel->content->classes->add('ux-base-content');
        $this->rootPanel->content->backgroundColor = null;
        $this->rootPanel->classes->add('ux-base-root');
    }
    
    public function __get($key){
        return isset($this->params[$key]) ? $this->params[$key] : NULL;
    }

    public function __set($key, $value){
        $this->params[$key] = $value;

        switch($key){
            case 'width':
            case 'height':
                UXCircled::of($this->rootPanel->content)->{$key} = $value;
            case 'x':
            case 'y':
            case 'maxWidth':
            case 'maxHeight':
            case 'id':
                $this->rootPanel->{$key} = $value;
            break;

            case 'backgroundColor':
            case 'color':
                $this->rootPanel->content->backgroundColor = $value;
            break;

            case 'borderColor':
            case 'borderStyle':
            case 'borderWidth':
                $this->rootPanel->content->{$key} = $value;
            break;

            case 'borderRadius':
                UXCircled::of($this->rootPanel->content)->borderRadius = $value;
            break;
            
            case 'skin':
                if(!is_array($value))$value = [$value];
                foreach($value as $v){
                    $this->rootPanel->classes->add('ux-skin-'.$v);
                }
            break;
        }
    }
    
    public function getRoot(){
        return $this->rootPanel;
    }
    
    protected function addChildren($el){
        $this->rootPanel->content->children->add($el);
    }

    protected function addEffect($el){
        $this->rootPanel->effects->add($el);
    }
}
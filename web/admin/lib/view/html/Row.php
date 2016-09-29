<?php
namespace lib\view\html;

/**
 * 
 * @author Zilvinas Vaira
 *
 */
class Row extends Tag{
    
    /**
     * 
     * @var CompositeTag
     */
    private $cells = array();
    
    /**
     * 
     * @var string
     */
    private $class = "";
    
    /**
     * 
     * @var array
     */
    private $columns = array();
    
    /**
     * 
     * @param array $cells
     * @param string $class
     */
    public function __construct($cells = array(), $class = "") {
        parent::__construct('tr');
        $this->setCells($cells);
        $this->addAttribute('class', $class);
    }
    
    /**
     * 
     * @param array $cells
     */
    public function setCells($cells){
        foreach ($cells as $key => $cell) {
            $td = new CompositeTag('td');
            $td->addText($cell);
            $this->cells [$key] = $td;
        }
    }
    
    public function size(){
        return count($this->cells);
    }
    
    public function getCells(){
        return $this->cells;
    }
    
    /**
     * 
     * @param string $column
     * @param string $name
     * @param string $value
     */
    public function addCellAttribute($column, $name, $value){
        if(isset($this->cells[$column])){
            $this->cells[$column]->addAttribute($name, $value);
        }
    }
    
    /**
     * 
     * @param array $columns
     */
    public function setColumns($columns){
        $this->columns = $columns;
    }
    
    /**
     * 
     * @param string $column
     * @param HtmlElement $element
     */
    public function addToCell($column, $element){
        if(!isset($this->cells[$column])){
            $this->cells[$column] = new CompositeTag('td');
        }
        $this->cells[$column]->addTag($element);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \lib\view\html\Tag::composeInnerString()
     */
    public function composeInnerString(){
        if(count($this->columns)>0){
            $innerString = "";
            foreach ($this->columns as $column) {
                if(!isset($this->cells[$column])){
                    $this->cells[$column] = new CompositeTag('td');
                }
                $this->cells[$column]->setTab("\t".$this->tab);
                $innerString .= $this->cells[$column];
                
            }
            return $innerString;
        }else{
            return parent::composeInnerString();
        }
    }
    
}
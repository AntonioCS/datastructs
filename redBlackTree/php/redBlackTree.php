<?php

class redBlackTree extends \binaryTree {

    const COLOR_RED = 1;
    const COLOR_BLACK = 0;

    protected $_color = self::COLOR_RED;

    /**
     * 
     * @return null|\redBlackTree
     */
    public function getGrandParent() {
        $p = $this->getParent();
        if ($p) {
            return $p->getParent();
        }

        return null;
    }

    /**
     * 
     * @return null|\redBlackTree
     */
    public function getUncle() {
        $g = $this->getGrandParent();
        
        if ($g) {
            if ($g->getNodeRight() == $this->getParent()) {
                return $this->getNodeLeft();
            } 
            
            return $this->getNodeRight();            
        }

        return null;
    }

    /**
     * http://en.wikipedia.org/wiki/Red%E2%80%93black_tree Operations section
     * 
     * @param mixed $value
     */
    public function insert($value) {
        $n = parent::insert($value);

        //The node is there now let's see which condition is true
        if ($n) {
            
            $g = $this->getGrandParent();
            $u = $this->getUncle();
            $p = $this->getParent();
            
            
            switch (true) {
                //root
                case ($p == null):
                    $n->setColorBlack();                    
                break;
                //the node is red so there is nothing to do it conforms to all the red black tree
                case $p->getColor() == self::COLOR_BLACK:
                    return;
                break;
                //if we get to this point we know the parent is red
                case $u !== null && $u->getColor() == self::COLOR_RED:
                    $u->setColorBlack();
                    $p->setColorBlack();
                    
                    //if the grandparent isn't the root set it to red
                    if ($g->getParent() !== null) {
                        $g->setColorRed();                        
                    }
                break;
                //rotations
                
            }
        }    
    }

    public function setColorRed() {
        $this->_color = self::COLOR_RED;
        return $this;
    }

    public function setColorBlack() {
        $this->_color = self::COLOR_BLACK;
    }

    public function getColor() {
        return $this->_color;
    }
}
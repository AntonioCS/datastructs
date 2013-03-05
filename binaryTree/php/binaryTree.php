<?php

class binaryTree {

    /**
     *
     * @var mixed
     */
    protected $_value = null;

    /**
     *
     * @var \binaryTree
     */
    protected $_left = null;

    /**
     *
     * @var \binaryTree
     */
    protected $_right = null;

    /**
     *
     * @var \binaryTree 
     */
    protected $_parent = null;

    /**
     *
     * @var Closure
     */
    protected $_compareFunction = null;

    /**
     * 
     * @param int|null $value
     */
    public function __construct($value = null) {
        $this->setValue($value);
    }

    /**
     * 
     * @param mixed $value
     */
    public function insert($value) {
        $n = $this->search($value);

        if ($n->getValue() === null) {
            $n->setValue($value);
            
            $c = $this->getCompare();
            if ($c) {
                $n->setCompare($c);
            }
            return $n;
        }

        return null;
    }

    /**
     * 
     * @param int $value
     * @return \binaryTree|null
     */
    protected function search($value) {
        $node = $this;

        while ($node->getValue() !== null) {
            $t = $node->compare($value);

            if ($t > 0) {
                if ($node->getNodeRight() === null) {
                    $node = $node->setNodeRight($this->factory());
                } else {
                    $node = $node->getNodeRight();
                }
            } elseif ($t < 0) {
                if ($node->getNodeLeft() === null) {
                    $node = $node->setNodeLeft($this->factory());
                } else {
                    $node = $node->getNodeLeft();
                }
            } else {
                break;
            }
        }

        return $node;
    }

    /**
     * 
     * @return null|\binaryTree
     */
    public function getNodeRight() {
        return $this->_right;
    }

    /**
     * 
     * @return null|\binaryTree
     */
    public function getNodeLeft() {
        return $this->_left;
    }

    /**
     * 
     * @param \binaryTree $node
     * @return \binaryTree
     */
    protected function setNodeRight(\binaryTree $node) {
        $this->_right = $node;
        return $node;
    }

    /**
     * 
     * @return null|\binaryTree
     */
    public function getParent() {
        return $this->_parent;
    }

    /**
     * 
     * @param \binaryTree $node
     * @return \binaryTree
     */
    protected function setNodeLeft(\binaryTree $node) {
        $this->_left = $node;
        return $node;
    }

    /**
     * 
     * @param \binaryTree $node
     */
    protected function setParent(\binaryTree $node) {
        $this->_parent = $node;
        return $node;
    }

    /**
     * 
     * @param mixed $value
     * @return int
     */
    protected function compare($value) {
        $compare = $this->getCompare();

        if ($compare) {
            return $compare($this->getValue(), $value);
        } 
        else {
            switch (true) {
                case ($value > $this->getValue()):
                    return 1;
                case ($value == $this->getValue()):
                    return 0;
                default:
                    return -1;
            }
        }
    }

    /**
     * 
     * @param Closure $compare
     * @return \binaryTree
     */
    public function setCompare(Closure $compare) {
        $this->_compareFunction = $compare;
        return $this;
    }

    /**
     * 
     * @return Closure
     */
    public function getCompare() {
        return $this->_compareFunction;
    }

    /**
     * @param mixed $value
     * @return \binaryTree
     */
    public function setValue($value) {
        $this->_value = $value;
        return $this;
    }

    /**
     * 
     * @return mixed
     */
    public function getValue() {
        return $this->_value;
    }

    /**
     * 
     * @return \self
     */
    protected function factory() {
        $b = new self();
        $b->setParent($this);
        
        return $b;
    }

}


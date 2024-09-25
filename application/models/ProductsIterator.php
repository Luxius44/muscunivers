
<?php

class ProductsIterator implements Iterator {
    private $position = 0;
    private $products;  
  
    public function __construct($products) {
        $this->products = $products;
        $this->position = 0;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->products[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->products[$this->position]);
    }
}
?>
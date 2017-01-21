<?php
class Item {

    public $id;
    public $price;
    public $volprices = array(); //volume prices

    // Constructor populates the attributes:
    public function __construct($id, $price, $volprices = array()) {
        $this->id = $id;
        $this->price = $price;
        $this->volprices = $volprices;
    }

    // Method that returns the ID:
    public function getId() {
        return $this->id;
    }

    // Method that returns the price:
    public function getPrice() {
        return $this->price;
    }

    // Method that returns the volume price:
    public function getvolumePrice() {
        return $this->volprices;
    }

    // Method that returns the price type: ****
    public function checkPricetype() {
        return (!empty($this->volprices)) ? "volumePricing" : "UnitPricing";
    }

}

// End of Item class.

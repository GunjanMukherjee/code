<?php

class ShoppingCart  {

    // Array stores the list of items in the cart:
    protected $items = array();
   
    // For storing the IDs, as a convenience:
    protected $ids = array();
    // Calculate total amount;
    protected $total = 0;

    // Constructor just sets the object up for usage:
    function __construct() {
        $this->items = array();
        $this->ids = array();
    }

    // Returns a Boolean indicating if the cart is empty:
    public function isEmpty() {
        return (empty($this->items));
    }

    // Adds a new item to the cart:
    public function addItem(Item $item) {

        // Need the item id:
        $id = $item->getId();

        // Throw an exception if there's no id:
        if (!$id)
            throw new Exception('The cart requires items with unique ID values.');

        // Add or update:
        if (isset($this->items[$id])) {
            $this->updateItem($item, $this->items[$id]['qty'] + 1);
        } else {
            $this->items[$id] = array('item' => $item, 'qty' => 1);
            $this->ids[] = $id; // Store the id, too!
        }
    }
    // End of addItem() method.
    
    // Changes an item already in the cart:
    public function updateItem(Item $item, $qty=0) {

        // Need the unique item id:
        $id = $item->getId();

        // Delete or update accordingly:
        if ($qty === 0) {
            $this->deleteItem($item);
        } elseif (($qty > 0) && ($qty != $this->items[$id]['qty'])) {
            $this->items[$id]['qty'] = $qty;
        }
    }
    // End of updateItem() method.
    
   
    // Removes an item from the cart:
    public function deleteItem(Item $item) {

        // Need the unique item id:
        $id = $item->getId();

        // Remove it:
        if (isset($this->items[$id])) {
            unset($this->items[$id]);

            // Remove the stored id, too:
            $index = array_search($id, $this->ids);
            unset($this->ids[$index]);

            // Recreate that array to prevent holes:
            $this->ids = array_values($this->ids);
        }
    }
    // End of deleteItem() method.
    
    // Required by Countable:
    public function count() {
        return count($this->items);
    }

    // Return unique item id quantity: 
    private function getItemqty($itemid) {
        return $this->items[$itemid]['qty'];
    }

    //Get Volume number of a item
    private function getVolumeNum(Item $item) {
        return key($item->volprices);
    }

    //Check volume Rule applied for this item
    private function chkVolumeRule($qty=0, $volumenum=0) {
        $qty = (int) $qty;
        $volumenum = (int) $volumenum;

        if ($volumenum <= $qty) {
            return "YES";
        } else if ($volumenum > $qty) {
            return "NO";
        }
    }

    //calculate Unitprice
    private function calUnitPrice($price=0, $qty=0) {
        $price = (float) $price;
        $qty = (int) $qty;
        return $price * $qty;
    }

    //calculate volume price
    private function calvolumePrice($price=0, $qty=0, $volprice = array()) {
        //Unitprice
        $price = (float) $price;
        // Total quantity
        $qty = (int) $qty;
        
        // Volume Quantity
        $vol_qty = (int) key($volprice);
        // Volume Price
        $volumeprice = (float) $volprice[$vol_qty];
        
        //To calculate in volume
        $new_qty_vol_cal= floor ($qty/$vol_qty);
        $new_vol_price=$volumeprice * $new_qty_vol_cal;
        
        //To calculate in Unitprice
        $new_qty_unit_cal=$qty%$vol_qty;
        $new_unit_price =$this->calUnitPrice($price,$new_qty_unit_cal);
        
        //Total price
        $total_price=$new_vol_price+$new_unit_price;
        return $total_price;
    }

    // calculate Subtotal of a item.
    private function subTotal($item = array()) {
        //print_r($item);
        // Product Id.
        echo " pid : " . $item[item]->id;

        // get the quantity of a item.
        echo " Quantity : ";
        echo $qty = $this->getItemqty($item[item]->id);

        // check volumePricing OR UnitPricing 
        $pricetype = $item[item]->checkPricetype();
        
        if ($pricetype === "volumePricing") {
            $volumeNum = $this->getVolumeNum($item[item]);
            $check_rule_applied = $this->chkVolumeRule($qty, $volumeNum);
            if ($check_rule_applied === "NO") {
                $item_price = $this->calUnitPrice($item[item]->price, $qty);
            }
            if ($check_rule_applied === "YES") {
                $item_price = $this->calvolumePrice($item[item]->price, $qty, $item[item]->volprices);
                echo " [Volume Pricing applied] ";
            }
        } //

        if ($pricetype === "UnitPricing") {
            $item_price = $this->calUnitPrice($item[item]->price, $qty);
        }//

        echo "  subtotal : $item_price ";
        echo "<br>";
        $this->total = $this->total + $item_price;
    }

    // Calculate the total 
    public function total() {
        echo "<br>" . 'Cart Contents (' . $this->count() . ' items)';
        echo "<br>";
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $this->subTotal($item);
            }
            echo "Total : " . number_format((float)$this->total,2,'.','') ;
        }
    }

}

// End of ShoppingCart class.

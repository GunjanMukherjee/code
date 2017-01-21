<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Gunjan Mukherjee's Assignment</title>
    </head>
    <body>
        <?php
        // Turn off error reporting
        error_reporting(0);
        ini_set('display_errors', 'OFF');
        
        // Create the cart:
        try {
            // This script uses the ShoppingCart and Item classes.
            require('ShoppingCart.php');
            require('Item.php');

            //ABCDABAA; Verify the total price is $32.40.
            // Create items and AddRule
            // A is a product available for "$2.00 each or 4 for $7.00".
            $a = new Item('A', 2.00, array("4" => "7.00"));  // as of PHP 5.4 $a = new Item('A', 2.00,['4'=>'7.00']); 
            // B is a product available for $12.00 each.
            $b = new Item('B', 12.00);
            // C is a product available for "$1.25 or $6 for a six pack".
            $c = new Item('C', 1.25, array("6" => "6.00")); // as of PHP 5.4 $c = new Item('C', 1.25,[6=>6.00]);
            // D is a product available for $0.15 each.
            $d = new Item('D', 0.15);
            
            $cart1 = new ShoppingCart();

            // Add the items to the cart:
            $cart1->addItem($a);
            $cart1->addItem($b);
            $cart1->addItem($c);
            $cart1->addItem($d);

            $cart1->addItem($a);
            $cart1->addItem($b);
            $cart1->addItem($a);
            $cart1->addItem($a);

            $cart1->total();
            
            $cart2 = new ShoppingCart();
            
            // Add the items to the cart:
            $cart2->addItem($c);
            $cart2->addItem($c);
            $cart2->addItem($c);
            $cart2->addItem($c);
            $cart2->addItem($c);
            $cart2->addItem($c);
            $cart2->addItem($c);
            
            $cart2->total();

            $cart3 = new ShoppingCart();
            
            $cart3->addItem($a);
            $cart3->addItem($b);
            $cart3->addItem($c);
            $cart3->addItem($d);

            $cart3->total();
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
        ?>
    </body>
</html>

<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Error , Direct Access to Script Not Allowed');
}

/*
 * Shopping Cart Library : Version 1.0
 * License: GPL
 * Copyright (c) 2015 - 2016, University Institute of Information Technology | ( UIIT-UAAR )
 */

/**
 * Description of Cart:
 * A PHP Class for Creating a Shopping Cart And Handling its following Operations:
 * 1. Adding Items to Cart.
 * 2. Deleting Items from Cart.
 * 3. Updating Items in Cart.
 * 4. Save Cart in Session.
 * 5. Displaying All items in Cart in Reverse Order.
 * 6. Destroy the Cart (usually after Placing Order).
 *
 * @author Ahmed Rehan
 */
class Cart {

    protected $CartContents;

    public function __construct() {
        
        if(!isset($_SESSION)){
           // echo "no hay sessoin";
            session_start();
        }


        // Grab the shopping cart array from the session array
        if (isset($_SESSION['ShoppingCart'])) {
            $this->CartContents = $_SESSION['ShoppingCart'];
        } elseif ($this->CartContents === NULL) {
            
            // No cart exists so we'll set some base values
            $this->CartContents = array('cart_total' => 0, 'total_items' => 0,'items' => []);
        }
    }

    //add items to cart
    public function insert($item = array()) {
        // Was any cart data passed?... 
        if (!is_array($item) || count($item) === 0) {
            die('Error , The insert method must be passed an array containing data.');
            return FALSE;
        } else {

           
            if (isset($item['ID']) && isset($item['post_title']) && isset($item['price']) && isset($item['post_content'])) {
                $rowid = md5($item['ID']);
                if (isset($this->CartContents['items'][$rowid])) {
                    $old_quantity = $this->CartContents['items'][$rowid]['quantity'];
                    $this->update(
                            array(
                                'rowid' => $rowid,
                                'ID' => $item['ID'],
                                'post_title' => $item['post_title'],
                                'post_content' => $item['post_content'],
                                'quantity' => $old_quantity + 1,
                                'price' => $item['price'],
                                'image_url' => (isset($item['image_url'])) ? $item['image_url'] : NULL
                            )
                    );
                    return TRUE;
                }
                $item['rowid'] = $rowid;
                $this->CartContents['items'][$rowid] = $item;
                $this->save_cart(); 

                return TRUE;
            } else {
                die('Error , The cart array must contain a product ID, price, and name.');
                return FALSE;
            }
        }
    }

    //
    //update cart
    //
    public function update($item = array()) {
        if (!is_array($item) || count($item) === 0 || empty($item['rowid'])) {
            die('Error , The update method must be passed an array containing rowid.');
            return FALSE;
        } else {
            $rowid = $item['ID'];
            if (isset($this->CartContents[$rowid])) {
                if (isset($item['price'])) {
                    $item['price'] = (int) $item['price'];
                }
                if (isset($item['quantity'])) {
                    if ($item['quantity'] === 0) {
                        $this->remove($rowid);
                        return TRUE;
                    } else {
                        $item['quantity'] = (int) $item['quantity'];
                    }
                }
                
                array_push($this->CartContents['items'], $item);
                
                $this->save_cart();
            }
            return TRUE;
        }
    }

    //
    //calculate prices and total amount
    //
    protected function save_cart() {
        $this->CartContents['total_items'] = $this->CartContents['cart_total'] = 0;
        foreach ($this->CartContents['items'] as $key => $val) {
            

            $this->CartContents['cart_total'] += ($val['price'] * $val['quantity']);
            $this->CartContents['total_items'] += $val['quantity'];
            $this->CartContents['items'][$key]['subtotal'] = ($this->CartContents['items'][$key]['price'] * $this->CartContents['items'][$key]['quantity']);
        }
        if (count($this->CartContents['items']) <= 2) {
            unset($_SESSION);
            return FALSE;
        }
        $_SESSION['ShoppingCart'] = $this->CartContents;
        return TRUE;
    }

    //cart total
    public function total() {
        return $this->CartContents['cart_total'];
    }

    //cart total
    public function total_items() {
        return $this->CartContents['total_items'];
    }

    //remove item
    public function remove($rowid) {
        // unset & save
        $r = settype($rowid, 'string');
        if (isset($this->CartContents[$r])) {
            unset($this->CartContents[$r]);
            $this->save_cart();
            return TRUE;
        } else {
            die('Error , The item doesn\'t exist');
        }
    }
    public function contents() {
        
        
        $contents = array();
        
        foreach ($this->CartContents['items'] as $item) {
        
            print_r($item);
            if (is_array($item) && isset($item['ID'], $item['post_title'], $item['quantity'], $item['price'])) {
                $obj = new stdClass();
                $obj->ID = $item['ID'];
                $obj->post_title = $item['post_title'];
                $obj->image_url = $item['image_url'];
                $obj->quantity = $item['quantity'];
                $obj->post_content = $item['post_content'];
                $obj->price = $item['price'];
                $contents[] = $obj;
            }
        }


        return $contents;
    }

    public function destroy() {
        $this->CartContents = array('cart_total' => 0, 'total_items' => 0,'items' => []);
        unset($_SESSION['ShoppingCart']);
    }

}

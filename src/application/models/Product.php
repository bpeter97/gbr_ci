<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class Product extends CI_Model
{
    private $id,
            $mod_name,
            $mod_cost,
            $mod_short_name,
            $monthly,
            $item_type,
            $rental_type,
            $order_id,
            $product_qty,
            $product_cost,
            $product_type;

    public function get_id() { return $this->id; }
    public function get_mod_name() { return $this->mod_name; }
    public function get_mod_cost() { return $this->mod_cost; }
    public function get_mod_short_name() { return $this->mod_short_name; }
    public function get_monthly() { return $this->monthly; }
    public function get_item_type() { return $this->item_type; }
    public function get_rental_type() { return $this->rental_type; }
    public function get_order_id() { return $this->order_id; }
    public function get_product_quantity() { return $this->product_qty; }
    public function get_product_cost() { return $this->product_cost; }
    public function get_product_type() { return $this->product_type; }
    
    public function set_id($id) { $this->id = $id; return $this; }
    public function set_mod_name($name) { $this->mod_name = $name; return $this; }
    public function set_mod_cost($cost) { $this->mod_cost = $cost; return $this; }
    public function set_mod_short_name($name) { $this->mod_short_name = $name; return $this; }
    public function set_monthly($cost) { $this->monthly = $cost; return $this; }
    public function set_item_type($type) { $this->item_type = $type; return $this; }
    public function set_rental_type($type) { $this->rental_type = $type; return $this; }
    public function set_order_id($id) { $this->order_id = $id; return $this; }
    public function set_product_quantity($qty) { $this->product_qty = $qty; return $this; }
    public function set_product_cost($cost) { $this->product_cost = $cost; return $this; }
    public function set_product_type($type) { $this->product_type = $type; return $this; }

    public function __construct($id = NULL)
    {
        parent::__construct();
        
        if( $id !== NULL )
        {
            $this->set_product_data((int)$id);
        }
    }

    // previously called getDetails()
    public function get_product_info($id = NULL)
    {
        if( $id !== NULL )
        {
            // Return user info based on supplied ID.
            return $this->db->get_where('modifications', ['id' => $id])->row();
        }
        else
        {
            // Return user info based on user model ID.
            return $this->db->get_where('modifications', ['id' => $this->get_id()])->row();
        }
    }

    public function set_product_data($id = NULL)
    {
        if(is_int($id))
        {
            $product = $this->get_product_info($id);
        }
        else
        {
            $product = $id;
        }

        // Use setters to setup this objects properties using the object passed in.
        if(is_array($product))
        {
            $this->set_id($product['id'])
                 ->set_mod_name($product['mod_name'])
                 ->set_mod_cost($product['mod_cost'])
                 ->set_mod_short_name($product['mod_short_name'])
                 ->set_monthly($product['monthly'])
                 ->set_item_type($product['item_type'])
                 ->set_rental_type($product['rental_type']);
        } 
        elseif(is_object($product))
        {
            // Use object parameters.
            $this->set_id($product->id)
                 ->set_mod_name($product->mod_name)
                 ->set_mod_cost($product->mod_cost)
                 ->set_mod_short_name($product->mod_short_name)
                 ->set_monthly($product->monthly)
                 ->set_item_type($product->item_type)
                 ->set_rental_type($product->rental_type);
        }
        else
        {
            // Throw an error
            throw new Exception('The variable passed in is not an object or an array.');
        }

        return $this;
    }

    public function count_products($where = NULL)
    {
        if( $where !== NULL )
        {
            return $this->db->get('modifications')->num_rows();
        }
        else
        {
            // $where must be an array!
            return $this->db->get_where('modifications', $where)->num_rows();
        }
    }

    // previously called getProducts
    // $where must be an array. If $limit is used, there must be an offset set as $start.
    public function get_products($where = NULL, $limit = NULL, $start = NULL, $or = NULL)
    {
        // If limit is not null then check where
        if( $limit !== NULL )
        {
            // If where is not null do limit with where
            if( $where !== NULL )
            {
                
                if( $or == TRUE )
                {
                    // WHERE something OR something OR something
                    $this->db->select('*')->from('modifications');

                    $x = 0;
                    foreach($where as $array)
                    {
                        if($x == 0)
                        {
                            $this->db->where($array);
                        }
                        else
                        {
                            $this->db->or_where($array);
                        }

                        $x++;
                    }

                    $product_array = $this->db->get()->result_array();
                }
                else
                {
                    // WHERE something AND something AND something
                    $product_array = $this->db->get_where('modifications', $where, $limit, $start)->result_array();
                }
            }
            // else do limit with no where
            else
            {
                $product_array = $this->db->get_where('modifications', $where, $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( $where !== NULL )    
        {
            if( $or == TRUE )
            {
                $product_array = array();

                // WHERE something OR something OR something
                $this->db->select('*')->from('modifications');

                // Run a for loop starting at 0 up to the amount of items in the array (minus one since we are starting at zero). 
                for( $x = 0; $x <= count($where)-1; $x++ )
                {
                    foreach($where[$x] as $key => $value)
                    {
                        if($x == 0)
                        {
                            $this->db->where(array($key => $value));
                        }
                        else
                        {
                            $this->db->or_where(array($key => $value));
                        }
                    }
                }
                
                $product_array = $this->db->get()->result_array();

            }
            else
            {
                $product_array = $this->db->get_where('modifications', $where)->result_array();
            }
        }
        // else get all of the products
        else
        {
            $product_array = $this->db->get('modifications')->result_array();
        }

        if($product_array)
        {
            $products = array();

            foreach($product_array as $prod)
            {
                $product = new Product((int)$prod['id']);
                array_push($products, $product);
            }

            return $products;
        }
        else
        {
            throw new Exception('There was no products returned.');
        }
    }

    // Not ordered product because it may be a quoted product therefore it's a requested product.
    public function delete_requested_product($id, $type)
    {
        if( $type == 'order' )
        {
            return $this->db->delete('product_orders',['order_id'=>$id]);
        }
        elseif( $type == 'quote' )
        {
            return $this->db->delete('product_orders',['quote_id'=>$id]);
        }
        else 
        {
            return FALSE;
        }
    }

    // TODO: Verify that the products returned do not need to be objects?
    public function search($string)
    {
        // Return an array of the products that match the search.
        return $this->db->select('*')
                        ->from('modifications')
                        ->like('mod_name', $string)
                        ->like('mod_short_name', $string)
                        ->get()
                        ->result_array();
    }

    public function update()
    {
        $data = array(
            'mod_name'      =>  $this->get_mod_name(),
            'mod_cost'      =>  $this->get_mod_cost(),
            'mod_short_name'=>  $this->get_mod_short_name(),
            'monthly'       =>  $this->get_monthly(),
            'item_type'     =>  $this->get_item_type(),
            'rental_type'   =>  $this->get_rental_type()
        );

        // Update this product object in the database.
        return $this->db->update('modifications', $data, ['id' => $this->get_id()]);
    }

    public function delete($id = NULL)
    {
        // Delete the modification by using an ID.
        if(is_null($id))
        {
            // Delete the modification by using object's id property.
            return $this->db->delete('modifications', ['id'=>$this->get_id()]);
        } 
        else 
        {
            // Delete the modification by using parameter id.
            return $this->db->delete('modifications', ['id'=>$id]);
        }
    }

    public function create()
    {
        // insert the object into the database
        if($this->db->insert('modifications', array(
            'mod_name'      =>  $this->get_mod_name(),
            'mod_cost'      =>  $this->get_mod_cost(),
            'mod_short_name'=>  $this->get_mod_short_name(),
            'monthly'       =>  $this->get_monthly(),
            'item_type'     =>  $this->get_item_type(),
            'rental_type'   =>  $this->get_rental_type()
            ))) 
        {

            // Return the ID
            return $this->db->insert_id();

        } 
        else 
        {

            // log error
            db_elogger($this->db->error());   

            // return FALSE
            return FALSE;

        }
    }

    public function get_rental_array()
    {
        $rental_array = array();

        $res = $this->db->get_where('modifications',['rental_type'=>'Rental'])->result_array();

        foreach($res as $mod)
        {
            array_push($rental_array, $mod['mod_short_name']);
        }

        return $rental_array;
    }

    // pud = pickup/delivery
    public function get_pud_array()
    {
        $pud_array = array();
        
        $res = $this->db->select('*')
                        ->from('modifications')
                        ->where('item_type', 'pickup')
                        ->or_where('item_type', "delivery")
                        ->get()
                        ->result_array();

        foreach($res as $mod)
        {
            array_push($pud_array, $mod['mod_short_name']);
        }

        return $pud_array;
    }

    public function get_container_array()
    {
        $container_array = array();
        
        $res = $this->db->get_where('modifications', ['item_type'=>'container']);

        foreach($res as $mod)
        {
            array_push($container_array, $mod['mod_short_name']);
        }

        return $container_array;
    }
}
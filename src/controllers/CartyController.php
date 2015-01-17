<?php

namespace Dersam\Carty;

use Config;
use DB;
use Input;
use Log;
use Response;
use Session;
use Validator;
use View;

class CartyController extends \BaseController{

    /**
     * Get the storefront page that displays products
     *
     * If the user doesn't have a cart yet, create one
     *
     * @return \Illuminate\View\View
     */
    function getStorefront(){
        return View::make('carty::shop');
    }

    /**
     * Initialize a new cart in the DB
     *
     * @return int id of the current cart
     */
    function initCart(){
        $cart = new Cart(array(
            'began_shopping_at' => date('Y-m-d H:i:s'),
            'ip' => \Request::getClientIp()
        ));
        $cart->save();

        Session::set('cart_id',$cart->id);

        return $cart->id;
    }

    /**
     * Get current contents of the cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function getCart(){
        $cart_id = Session::get('cart_id',false);

        if(!$cart_id) {
            $cart_id = $this->initCart();
        }
        else{
            $cart = Cart::find(Session::get('cart_id'));

            if($cart == null){
                $cart_id = $this->initCart();
            }
        }

        $contents = DB::select("select
product_id,
quantity,
`name`,
price_per_unit
from cart_contents
inner join products on product_id = products.id
where cart_id = ?",array($cart_id));;

        $json = array(
            'cart_id'=>$cart_id,
            'products'=>array(),
            'subtotal'=>0,
            'gst'=>null,
            'pst'=>null,
            'total'=>0
        );

        foreach($contents as $row){
            $product = array(
                'id'=>$row->product_id,
                'quantity'=>$row->quantity,2,
                'price_per_unit'=>$row->price_per_unit,
                'total'=> $row->quantity*$row->price_per_unit
            );

            $json['subtotal'] += $product['total'];

            $json['products'][]=$product;
        }

        $json['gst'] = Config::get('carty::GST')*$json['subtotal'];
        $json['pst'] = Config::get('carty::PST')*$json['subtotal'];
        $json['total'] = $json['subtotal'] + $json['gst'] + $json['pst'];

        return Response::json($json);
    }

    /**
     * Adds a product to the cart
     *
     * If the product is already in the cart, updates the quantity
     */
    function addProductToCart(){
        $product_id = Input::json('product_id');
        $cart_id = Session::get('cart_id');
        $quantity = Input::json('quantity');

        $validator = Validator::make(
            array(
                'product_id'=>$product_id,
                'quantity'=>$quantity
            ),
            array(
                'product_id'=>array('required','integer'),
                'quantity'=>array('required','numeric')
            )
        );

        if($validator->fails()){
            Log::error(print_r($validator->messages()->all(),true),array('__CLASS__','__FUNCTION__'));
            return Response::json(array('success'=>false,'code'=>400,'message'=>'invalid request'));
        }

        DB::insert("
INSERT INTO cart_contents SET cart_id=?,product_id=?, quantity=?, created_at=?, updated_at=?
ON DUPLICATE KEY UPDATE quantity = ?, updated_at=?
"
            ,array(
                $cart_id,$product_id,$quantity,time(),time(),
                $quantity,time()
            ));

        return Response::json(array('success'=>true));
    }

    /**
     * Remove a specified product from the current cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function removeProductFromCart(){
        $product_id = Input::json('product_id');
        $cart_id = Session::get('cart_id');

        $validator = Validator::make(
            array(
                'product_id'=>$product_id
            ),
            array(
                'product_id'=>array('required','integer')
            )
        );

        if($validator->fails()){
            Log::error(print_r($validator->messages()->all(),true),array('__CLASS__','__FUNCTION__'));
            return Response::json(array('success'=>false,'code'=>400,'message'=>'invalid request'));
        }

        DB::table('cart_contents')->where('product_id','=',$product_id)->where('cart_id','=',$cart_id)->delete();

        return Response::json(array('success'=>true));
    }

    /**
     * Empty the current cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function emptyCart(){
        $cart_id = Session::get('cart_id');

        DB::table('cart_contents')->where('cart_id','=',$cart_id)->delete();

        return Response::json(array('success'=>true));
    }
}
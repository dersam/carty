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
        return View::make('carty::shop',array(
            'title'=>'Shopping Demo',
            'products'=>Product::all()
        ));
    }

    function getCartView(){

        return View::make('carty::cart',array(
            'title'=>'Carty'
        ));
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

        Session::set('carty.cart_id',$cart->id);

        return $cart->id;
    }

    /**
     * Get current contents of the cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function getCart(){
        $cart_id = Session::get('carty.cart_id',false);

        if(!$cart_id) {
            $cart_id = $this->initCart();
        }
        else{
            $cart = Cart::find(Session::get('carty.cart_id'));

            if($cart == null){
                $cart_id = $this->initCart();
            }
        }

        try {
            $contents = DB::select("SELECT
product_id,
quantity,
`name`,
price_per_unit
FROM cart_contents
INNER JOIN products ON product_id = products.id
WHERE cart_id = ?", array($cart_id));
        } catch(\Exception $e){
            Log::error($e->getMessage(),array(__CLASS__,__FUNCTION__));
            Log::error($e->getTraceAsString(),array(__CLASS__,__FUNCTION__));

            return Response::json(array(
                'success'=>false,
                'message'=>"error retrieving cart"
            ), 500);
        }

        $cart_contents = array(
            'success'=>true,
            'cart_id'=>$cart_id,
            'products'=>array(),
            'subtotal'=>0,
            'gst'=>0,
            'pst'=>0,
            'total'=>0
        );

        foreach($contents as $row){
            $total = $row->quantity*$row->price_per_unit;
            $product = array(
                'id'=>$row->product_id,
                'name'=>$row->name,
                'quantity'=>$row->quantity,
                'price_per_unit'=>number_format($row->price_per_unit,2),
                'total'=> number_format($total,2)
            );

            $cart_contents['subtotal'] += $total;

            $cart_contents['products'][]=$product;
        }

        $cart_contents['gst'] = number_format(Config::get('carty::taxes.GST')*$cart_contents['subtotal'],2);
        $cart_contents['pst'] = number_format(Config::get('carty::taxes.PST')*$cart_contents['subtotal'],2);
        $cart_contents['total'] = number_format($cart_contents['subtotal'] + $cart_contents['gst'] + $cart_contents['pst'],2);

        $cart_contents['subtotal'] = number_format($cart_contents['subtotal'],2);

        return Response::json($cart_contents);
    }

    /**
     * Adds a product to the cart
     *
     * If the product is already in the cart, updates the quantity
     */
    function addProductToCart(){
        $product_id = Input::json('product_id');
        $cart_id = Session::get('carty.cart_id');
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
            Log::error(print_r($validator->messages()->all(),true),array(__CLASS__,__FUNCTION__));
            return Response::json(array('success'=>false,'code'=>400,'message'=>'invalid request'),400);
        }

        try {
            if($quantity > 0) {
                DB::insert("
INSERT INTO cart_contents SET cart_id=?,product_id=?, quantity=?, created_at=NOW(), updated_at=NOW()
ON DUPLICATE KEY UPDATE quantity = ?, updated_at=NOW()
"
                    , array(
                        $cart_id, $product_id, $quantity,
                        $quantity
                    ));
            }
            else{
                DB::table('cart_contents')->where('cart_id','=',$cart_id)->where('product_id','=',$product_id)->delete();
            }
        } catch(\Exception $e){
            Log::error($e->getMessage(),array(__CLASS__,__FUNCTION__));
            Log::error($e->getTraceAsString(),array(__CLASS__,__FUNCTION__));

            return Response::json(array(
                'success'=>false,
                'code'=>500,
                'message'=>"An error ocurred while attempting to update your cart"
            ), 500);
        }

        return Response::json(array('success'=>true));
    }

    /**
     * Remove a specified product from the current cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function removeProductFromCart(){
        $product_id = Input::json('product_id');
        $cart_id = Session::get('carty.cart_id');

        $validator = Validator::make(
            array(
                'product_id'=>$product_id
            ),
            array(
                'product_id'=>array('required','integer')
            )
        );

        if($validator->fails()){
            Log::error(print_r($validator->messages()->all(),true),array(__CLASS__,__FUNCTION__));
            return Response::json(array('success'=>false,'message'=>'invalid request'),400);
        }

        try {
            DB::table('cart_contents')->where('product_id', '=', $product_id)->where('cart_id', '=', $cart_id)->delete();
        }catch(\Exception $e){
            Log::error($e->getMessage(),array(__CLASS__,__FUNCTION__));
            Log::error($e->getTraceAsString(),array(__CLASS__,__FUNCTION__));

            return Response::json(array(
                'success'=>false,
                'message'=>"error updating cart"
            ), 500);
        }

        return Response::json(array('success'=>true));
    }

    /**
     * Empty the current cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function emptyCart(){
        $cart_id = Session::get('carty.cart_id');

        try {
            DB::table('cart_contents')->where('cart_id', '=', $cart_id)->delete();
        } catch(\Exception $e){
            Log::error($e->getMessage(),array(__CLASS__,__FUNCTION__));
            Log::error($e->getTraceAsString(),array(__CLASS__,__FUNCTION__));

            return Response::json(array(
                'success'=>false,
                'message'=>"error emptying cart"
            ), 500);
        }

        return Response::json(array('success'=>true));
    }
}
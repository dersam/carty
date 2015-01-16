<?php

namespace Dersam\Carty;

use DB;
use Input;
use Session;
use View;

class CartyController extends \BaseController{

    /**
     * Get the storefront page that displays products
     * @return \Illuminate\View\View
     */
    function getStorefront(){
        if(!Session::get('cart_id',false)) {
            $cart = new Cart(array(
                'began_shopping_at' => date('Y-m-d H:i:s'),
                'ip' => \Request::getClientIp()
            ));
            $cart->save();

            Session::set('cart_id',$cart->id);
        }
        else{
            $cart = Cart::find(Session::get('cart_id'));
        }

        return View::make('carty::shop');
    }

    function getCartView(){

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

        DB::insert("
INSERT INTO cart_contents SET cart_id=?,product_id=?, quantity=?, created_at=?, updated_at=?
ON DUPLICATE KEY UPDATE quantity = ?, updated_at=?
"
            ,array(
                $cart_id,$product_id,$quantity,time(),time(),
                $quantity,time()
            ));
    }

    function removeProductFromCart(){
        $product_id = Input::json('product_id');
        $cart_id = Session::get('cart_id');

        DB::table('cart_contents')->where('product_id','=',$product_id)->where('cart_id','=',$cart_id)->delete();
    }

    function emptyCart(){
        $cart_id = Session::get('cart_id');
        DB::table('cart_contents')->where('cart_id','=',$cart_id)->delete();
    }
}
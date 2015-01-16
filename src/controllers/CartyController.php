<?php

namespace Dersam\Carty;

use Input;

class CartyController extends \BaseController{

    /**
     * Get the storefront page that displays products
     * @return \Illuminate\View\View
     */
    function getStorefront(){
        if(!\Session::get('cart_id',false)) {
            $cart = new Cart(array(
                'began_shopping_at' => date('Y-m-d H:i:s'),
                'ip' => \Request::getClientIp()
            ));
            $cart->save();

            \Session::set('cart_id',$cart->id);
        }
        else{
            $cart = Cart::find(\Session::get('cart_id'));
        }

        return \View::make('carty::shop');
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
        $cart_id = Input::json('cart_id');
        $quantity = Input::json('quantity');
    }

    function removeProductFromCart(){

    }

    function emptyCart(){

    }
}
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

    function addProductToCart(){
        $product_id = Input::json('product_id');
        $cart_id = Input::json('cart_id');
    }

    function removeProductFromCart(){

    }

    function emptyCart(){

    }
}
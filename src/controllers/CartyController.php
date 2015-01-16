<?php

namespace Dersam\Carty;

class CartyController extends \BaseController{
    function getStorefront(){
        if(!\Session::get('cart_id',false)) {
            $cart = new Cart(array(
                'began_shopping_at' => date('Y-m-d H:i:s'),
                'ip' => \Request::getClientIp()
            ));
            $cart->save();
        }
        else{
            $cart = Cart::find(\Session::get('cart_id'));
        }

        return $cart->began_shopping_at;
    }
}
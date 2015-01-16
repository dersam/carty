<?php

namespace Dersam\Carty;

class CartyController extends \BaseController{

    /**
     * Get the storefront page that displays products
     * @return mixed
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

        return \View::make('carty::layout');
    }
}
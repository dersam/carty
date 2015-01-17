<?php

Route::group(array('prefix'=>'carty'),function(){
    //Store
    Route::get('/', array('as'=>'store','uses'=>'Dersam\Carty\CartyController@getStorefront'));

    //Cart
    Route::get('/cart',array('as'=>'cart','uses'=>'Dersam\Carty\CartyController@getCartView'));
});
<?php

Route::group(array('prefix'=>'carty'),function(){
    //Get the storefront page
    Route::get('/', array('as'=>'store','uses'=>'Dersam\Carty\CartyController@getStorefront'));

    //Cart
    Route::group(array('prefix'=>'cart'),function(){
        //Get the cart page
        Route::get('/',array('as'=>'cart','uses'=>'Dersam\Carty\CartyController@getCartView'));

        //Get the JSON cart contents
        Route::get('/contents',array('as'=>'cart-contents','uses'=>'Dersam\Carty\CartyController@getCart'));

        //Update an item in the cart
        Route::post('/contents','Dersam\Carty\CartyController@addProductToCart');

        //Remove an item from the cart
        Route::delete('/contents','Dersam\Carty\CartyController@removeProductFromCart');

    });
});
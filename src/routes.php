<?php

Route::group(array('prefix'=>'carty'),function(){
    //Store
    Route::get('/','Dersam\Carty\CartyController@getStorefront');

    //Cart

    //Checkout

});
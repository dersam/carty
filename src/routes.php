<?php

Route::group(array('prefix'=>'carty'),function(){
    Route::get('',function(){
        return 'Hello World';
    });
});
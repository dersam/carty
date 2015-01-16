<?php

Route::group(array('prefix'=>'carty'),function(){
    Route::get('test',function(){
        return 'Hello World';
    });
});
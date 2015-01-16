<?php

namespace Dersam\Carty;

class Cart extends \Eloquent{
    protected $table = 'carts';
    protected $fillable = array('began_shopping_at','ip');
}
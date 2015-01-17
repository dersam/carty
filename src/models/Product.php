<?php

namespace Dersam\Carty;

class Product extends \Eloquent {
    protected $table = 'products';
    protected $fillable = array('name','description','price_per_unit','image_url');
}
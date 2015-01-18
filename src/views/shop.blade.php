@extends('carty::layout')

@section('content')
<div style="padding-top: 10px"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h3></h3>
        </div>
        <div class="col-md-2 pull-right">
           <a href="{{URL::route('cart')}}"> <span class="glyphicon glyphicon-shopping-cart" style="font-size: 50px" aria-hidden="true"></span>
            <div>View Cart</div></a>
        </div>
    </div>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-2 col-xs-2 col-md-offset-1">
            <div class="row">
                {{HTML::image($product->image_url,'',array('class'=>'img-responsive'))}}
            </div>
            <div class="row carty-product-box-spacer">
                <strong>{{$product->name}}</strong>
            </div>
            <div class="row carty-product-box-spacer">
                ${{number_format($product->price_per_unit,2)}}
            </div>
            <div class="row carty-product-box-spacer">
                <button class="btn btn-success" style="width:100%">Add to Cart</button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@stop


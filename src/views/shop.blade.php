@extends('carty::layout')

@section('content')
<div style="padding-top: 10px"></div>
<div class="container">
    <input type="hidden" id="page-context" value="shop"/>
    <input type="hidden" id="starting-item-count" value="{{$item_count}}"/>
    <div class="row">
        <div class="col-md-4 pull-left">
            <h1>Local Gear Shop</h1>
        </div>
        <div class="col-md-2 pull-right text-center">
           <a href="{{URL::route('cart')}}">
               <span class="glyphicon glyphicon-shopping-cart" style="font-size: 50px" aria-hidden="true"></span>
                <p>View Cart <span id="item-count">({{$item_count}})</span></p>
           </a>
        </div>
    </div>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-2 col-sm-6 col-xs-6 carty-product-box">
            <div class="row">
                {{HTML::image($product->image_url,'',array('class'=>'img-responsive', 'height'=>'195px'))}}
            </div>
            <div class="row carty-product-box-spacer carty-product-info">
                <strong>{{$product->name}}</strong>
            </div>
            <div class="row carty-product-box-spacer">
                ${{number_format($product->price_per_unit,2)}}
            </div>
            <div class="row carty-product-box-spacer">
                @if(!in_array($product->id, $in_cart))
                <button data-role="add-product" data-incart="no" data-product="{{$product->id}}" class="btn btn-success" style="width:100%">Add to Cart</button>
                @else
                <button data-role="add-product" data-incart="yes" data-product="{{$product->id}}" class="btn btn-default" style="width:100%">In Cart</button>
                @endif
                <div data-role="loader" data-product="{{$product->id}}" style="display: none">
                    {{HTML::image('packages/dersam/carty/img/button-loader.gif','',array('class'=>'img-responsive'))}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div id="loader" style="display: none">
    {{HTML::image('packages/dersam/carty/img/button-loader.gif','',array('class'=>'img-responsive'))}}
</div>
@stop


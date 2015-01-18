@extends('carty::layout')

@section('content')
    <div style="padding-top: 10px"></div>
    <div class="container">
        <input type="hidden" id="page-context" value="cart"/>

        <div class="row">
            <div class="col-md-3">
                <h1>Shopping Cart</h1>
            </div>
            <div class="col-md-2 pull-right text-center">
                <a href="{{URL::route('store')}}">
                    <span class="glyphicon glyphicon-home" style="font-size: 50px" aria-hidden="true"></span>
                    <p>Back to Shop</p>
                </a>
            </div>
        </div>
        <div class="row">
            <hr/>
        </div>
        <div class="row">
            <div id="loader-image">
                {{HTML::image('packages/dersam/carty/img/squares.gif','loading image',array('class'=>'carty-loading-image'))}}
            </div>
        </div>

        <div id="shopping-cart" class="row"></div>
    </div>
@stop
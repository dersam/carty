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
            <span class="sr-only">View Cart</span></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="row">
                {{HTML::image('packages/Dersam/Carty/img/arai_signet_q_zero_helmet.jpg','helmet',array('class'=>'img-responsive'))}}
            </div>
            <div class="row">
                <button class="btn btn-success" style="width:100%">Add to Cart</button>
            </div>
        </div>
    </div>
</div>
@stop


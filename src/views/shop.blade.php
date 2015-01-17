@extends('carty::layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h3></h3>
        </div>
        <div class="col-md-2 pull-right">
            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
            View Cart
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


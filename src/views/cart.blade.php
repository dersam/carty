@extends('carty::layout')

@section('content')
    <div class="container">
        <input type="hidden" id="page-context" value="cart"/>
        <div id="loader-image">
            {{HTML::image('packages/Dersam/Carty/img/squares.gif','loading image',array('class'=>'carty-loading-image'))}}
        </div>
        <div id="shopping-cart"></div>
    </div>
@stop
@extends('carty::layout')

@section('content')
    <div class="container">
        <div id="loader-image">
            {{HTML::image('packages/Dersam/Carty/img/squares.gif','loading image',array('class'=>'carty-loading-image'))}}
        </div>
        <div id="shopping-cart"></div>
    </div>
@stop
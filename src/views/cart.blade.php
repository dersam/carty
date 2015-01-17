@extends('carty::layout')

@section('content')
    <div style="padding-top: 10px"></div>
    <div class="container">
        <h1>Shopping Cart ({{$cart['cart_id']}})</h1>
        @if(count($cart['products'])==0)
        <p>Your cart is empty!</p>
        @else
        <div class="row">
            <table class="table table-hover table-striped carty-cart-table">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th class="carty-cart-col-quantity">Quantity</th>
                    <th class="carty-cart-col-total">Total</th>
                </tr>
                @foreach($cart['products'] as $product)
                <tr>
                    <td>{{$product['name']}}</td>
                    <td>${{number_format($product['price_per_unit'],2)}}</td>
                    <td>{{$product['quantity']}}</td>
                    <td>${{number_format($product['total'],2)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>Subtotal</td>
                    <td>${{number_format($cart['subtotal'],2)}}</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>GST</td>
                    <td>${{number_format($cart['gst'],2)}}</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>PST</td>
                    <td>${{number_format($cart['pst'],2)}}</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>Grand Total</td>
                    <td>${{number_format($cart['total'],2)}}</td>
                </tr>
            </table>
            <table class="table">

            </table>
        </div>
        @endif
    </div>
@stop
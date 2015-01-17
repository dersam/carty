@extends('carty::layout')

@section('content')
    <script id="cart-template" type="text/x-handlebars-template">
    <div style="padding-top: 10px"></div>
    <div class="row">
        <h1>Shopping Cart</h1>
        <div class="row">
            <table class="table table-hover table-striped carty-cart-table">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th class="carty-cart-col-quantity">Quantity</th>
                    <th class="carty-cart-col-total">Total</th>
                </tr>
                {{#each products}}
                <tr>
                    <td>{{name}}</td>
                    <td>${{price_per_unit}}</td>
                    <td>{{quantity}}</td>
                    <td>${{total}}</td>
                </tr>
                {{/each}}
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>Subtotal</td>
                    <td>${{subtotal}}</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>GST</td>
                    <td>${{gst}}</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>PST</td>
                    <td>${{pst}}</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>Grand Total</td>
                    <td>${{total}}</td>
                </tr>
            </table>
        </div>
    </div>
    </script>
@stop
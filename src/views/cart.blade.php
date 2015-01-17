@extends('carty::layout')

@section('content')
    <div style="padding-top: 10px"></div>
    <div class="container">
        <h1>Shopping Cart</h1>
        <div class="row">
            <table class="table table-hover table-striped carty-cart-table">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th class="carty-cart-col-quantity">Quantity</th>
                    <th class="carty-cart-col-total">Total</th>
                </tr>
                <tr>
                    <td>product1</td>
                    <td>100</td>
                    <td>1</td>
                    <td>100</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>Subtotal</td>
                    <td>100</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>GST</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>PST</td>
                    <td>9.98</td>
                </tr>
                <tr>
                    <td class="carty-hidden-table-cell"></td>
                    <td class="carty-hidden-table-cell"></td>
                    <td>Grand Total</td>
                    <td>114.98</td>
                </tr>
            </table>
            <table class="table">

            </table>
        </div>
    </div>
@stop
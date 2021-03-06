@extends('app')

@section('page-title')
    Current orders
@endsection

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>
            <div class="col-sm-9">
                <h2>Current orders</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Order</th>
                        <th>Name</th>
                        <th>Collection time</th>
                        <th>Order status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>
                                @foreach($order->order_lines as $line)
                                    @if($line->product->type == 'drink')
                                        {{ $coffeeShop->getSizeDisplayName($line->size) }}
                                    @endif
                                    {{ $coffeeShop->getNameFor($line->product) }}<br>
                                @endforeach
                            </td>
                            <td>
                                {{ $order->user->name }}
                            </td>
                            <td>
                                {{ $order->pickup_time }}
                            </td>
                            <td>
                                {{ $order->status }}
                                <a href="{{ route('next-order-status', [ $order ]) }}"
                                   class="btn btn-success btn-xs pull-right">
                                    Set as {{ $order->getNextStatus() }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

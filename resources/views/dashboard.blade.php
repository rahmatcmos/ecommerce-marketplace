@extends('app')

@section('page-title')
    Your coffee shop
@endsection

@section('content')
    <div class="container-fluid">
        @include('dashboard._header')
        <div class="row">
            <div class="col-sm-3">
                @include('dashboard._menu')
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-xs-12">
                        <h4><a class="btn btn-primary android" href="https://play.google.com/store/apps/details?id=com.ionicframework.koolbeans44126">Download the android application</a></h4>
                    </div>
                </div>
                @if ( $coffeeShop->views > 10)    
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>You had {{ $coffeeShop->views }} visitors in total!</h4>
                        </div>
                        <div class="col-xs-12">

                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-xs-12">
                            <h2>Thanks for joining KoolBeans!</h2>
                        </div>
                    </div>
                @endif

                @if ($coffeeShop->stripe_user_id)
                    @if ($coffeeShop->status != 'published')
                        <div class="row">
                            <div class="col-xs-12">
                                <h3>If you have finished your profile you can now publish your shop!</h3>
                            </div>
                            <div class="col-xs-12">
                                <a href="{{ route('publish-my-shop') }}" class="btn btn-success">Publish your shop</a>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12">
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
                        <div class="col-xs-12">
                            <h2>Most bought products</h2>
                            <ul class="list-group">
                                @foreach($mostBought as $product)
                                    <li class="list-group-item">
                                        {{$coffeeShop->getNameFor($coffeeShop->findProduct($product->product_id))}}:
                                        {{$product->aggregate}} times
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12">
                        <h2 class="bg-danger text-warning" style="padding: 15px; font-size: 20px;">Hi {{ current_user()->name }}, <a href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id={{ config('services.stripe.client_id') }}&scope=read_write">Connect to stripe</a>. You will be unable to publish your shop until stripe has been connected!</h2>
                    </div>
                    <div class="col-xs-12">
                        <h4>You can also <a href="{{ route('coffee-shop.gallery.index', ['coffee_shop' => $coffeeShop]) }}">add images</a>, <a target="_blank" href="{{ route('coffee-shop.opening-times') }}">set your opening times</a>, <a href="{{ route('coffee-shop.products.index', ['coffee_shop' => current_user()->coffee_shop]) }}">choose your menu</a> and <a href="{{ route('coffee-shop.show', ['coffeeshop' => $coffeeShop]) }}">Review your shop</a></h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

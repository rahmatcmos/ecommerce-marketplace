@extends('app')

@section('page-title')
    Order successfully placed!
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>@yield('page-title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Your order</th>
                        <th>Total: £{{ number_format((float)$order->price / 100, 2, '.', '') }}</th>
                    </tr>
                    </thead>
                    @foreach($order->order_lines as $line)
                        <tr>
                            <td>
                                {{$line->product->type == 'drink' ? $coffeeShop->getSizeDisplayName($line->size) : ''}}
                                {{$coffeeShop->getNameFor($line->product)}}
                            </td>
                            <td>£{{ number_format((float)$line->price / 100, 2, '.', '') }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td>Processing fee</td>
                            <td>20p</td>
                        </tr>
                </table>

                <p class="offers">
                    Current offer applying:<br>
                    {{ Session::has('offer-used') ? display_offer(Session::get('offer-used')) : "" }}
                </p>

                @if ( $order->make_on_arriving == 1)
                    <h4>Make On Arrival</h4>
                @else
                    <h4>Pickup time: {{$order->pickup_time}}</h4>
                @endif

                <p>Tweet about this order and you will get 5 KB points! How cool is that?</p>
                <a href="https://twitter.com/share" data-size="large" class="twitter-share-button" data-count="none" data-url="https://koolbeans.co.uk/" data-text="Just ordered a coffee from {{ $order->coffee_shop->name }} using @KoolBeansUK!">Tweet</a>
                <script>       window.twttr = (function (d, s, id) {
            var t, js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
            return window.twttr || (t = {
                _e: [],
                ready: function (f) {
                    t._e.push(f)
                }
            });
        }(document, "script", "twitter-wjs"));
                </script>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
            $('.twitter-share-button').hide();
       
            function handleTweetEvent(event){
                if (event) {
                    $.ajax('{{ route('order.tweet', $order->id) }}');
                    $('.twitter-share-button').hide();
                }
            }
            setTimeout(function () {
                $('.twitter-share-button').show();
                twttr.events.bind('click', function(e) {
                    
                    handleTweetEvent(e);
                });
            }, 1500);

    </script>
@stop

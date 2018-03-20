<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Home') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/master.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- <script src="cartajax.js" type="text/javascript"> </script> -->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Home') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li><a class="nav-link" href="{{ route('dishes.index') }}">Dishes</a></li>
                        <li><a class="nav-link" href="{{ route('contact') }}">Contacts</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                            @if(Auth::check())
                            <li><a class="nav-link" href="{{ route('reservations.index') }}">Reservations</a></li>
                            <li><a class="nav-link" href="{{ route('orders.index') }}">Orders</a></li>
                            @endif

                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li><a class="nav-link" href="{{ route('register')}}">Register</a></li>
                        @else
                            <li class="nav-item dropdown">


                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if(Auth::check() && Auth::user()->role == 'admin')
                                    <a class="dropdown-item" href="{{ route('users.index') }}">
                                        Users
                                    </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">
                                        My profile
                                    </a>


                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>


                                </div>
                            </li>
                        @endguest
                            <li id="cart">
                                <a class="nav-link" href="{{  route('cart') }}">
                                    Cart (<span id="cart_size" class="cart-size">{{Cart::count(csrf_token())}}</span>)
                                    <small>
                                        <span id="cart_total" class="cart-total">{{Cart::total(csrf_token())}}</span>
                                    </small>
                                </a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">

    $(document).ready(function(){


        $(".js-add-to-cart").submit(function(e){
            e.preventDefault();   // reikalingas, kad nenukeliautų į kitą puslapį


            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),

                error: function(msg){
                    console.log(msg);
                },

                success: function(data){
                    let total_amount = parseFloat($("#cart_total").html().replace(',', ''));
                    let cart_count = $("#cart_size").html() * 1;
                    let cart = $.parseJSON(data);
                    total_amount += cart.price;
                    cart_count++;
                    $("#cart_total").text(total_amount.toLocaleString('en-GB', {minimumFractionDigits: 2}));
                    $("#cart_size").text(cart_count);


                        // Sukuriam success message:

                    let alert = $("<div></div>");
                    alert.addClass("alert alert-success sticky-top");
                    alert.attr("role", "alert");
                    alert.text("Added to cart " + cart.dish.title + " for price " + cart.price + "€");

                    alert.hide();
                    $('main .alert').fadeOut();
                    $('main .container').prepend(alert.fadeIn());


                },

            });  //ajaxo pabaiga

        })

    })






    </script>

</body>
</html>

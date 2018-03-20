<div class="card">

      <div class="card-body">
        <h5 class="card-title card-header">{{$dish->title}}</h5>
        <img class="card-img-top" src="{{$dish->image_url}}" alt="Card image cap">
        <p>Price: <span class="badge badge-success">{{number_format($dish->price, 2)}}&euro;</span></p>
        <p class="card-text">{{str_limit($dish->description, 200)}}</p>

      </div>

      <form class="js-add-to-cart" action="{{ route('cart.store') }}" method="POST" >
            @csrf
            <input id="dish_id" type="hidden" name="dish_id" value="{{ $dish->id }}">
            <button class=" btn btn-success btn-block" >Add to cart</button>
      </form>
      @if(Auth::check() && Auth::user()->role == 'admin')
      <div>
          <a href="{{ route('dishes.edit', $dish->id) }}" class="btn btn-secondary btn-block">Edit</a>
      </div>

          <form class="" action="{{ route('dishes.destroy', $dish->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-warning btn-block" name="button">Delete Dish</button>
          </form>
         @endif
</div>

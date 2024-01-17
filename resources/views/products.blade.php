@extends('layouts.app')
@section('content')
<div class="container mt-5 mb-5">
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach ($products as $product)
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{ substr($product->description, 0, 130) }}...</p>
                        <a href="/productDetail/{{$product->id}}" class="btn btn-primary">просмотр</a>
                    </div>
                </div>
            </div>
        @endforeach
      </div>
</div>
@endsection

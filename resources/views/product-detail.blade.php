@extends('layouts.app')
@section('content')
<div class="container mt-5 mb-5">
    <div class="row g-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Name: {{$product->name}}</h5>
                <p class="card-text">Price: {{ $product->price }}</p>
                <p class="card-text">Discount: {{ $product->discount }}</p>
                <p class="card-text">Type: {{ $product->type }}</p>
                <p class="card-text">ExternalCode: {{ $product->external_code }}</p>
                <p class="card-text">Barcode: {{ $product->barcode }}</p>
                <p class="card-text">Description: {{ $product->description }}</p>
                <h5 class="card-title">Доп. поле: </h5>
                @foreach ($product->attributes as $attribute)
                    <p class="card-text">{{$attribute->key}}: {{ $attribute->value }}</p>
                @endforeach
                <h5 class="card-title">Images: </h5>
                @foreach ($product->images as $image)
                    <p class="card-text">{{$image->path}}</p>
                @endforeach
            </div>
        </div>
      </div>
</div>
@endsection

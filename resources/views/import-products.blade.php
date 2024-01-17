@extends('layouts.app')
@section('content')
<div class="container">
    <form method="POST" action="{{route('import')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="file" class="form-label">Upload File</label>
          <input type="file" class="form-control" name="file">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@endsection

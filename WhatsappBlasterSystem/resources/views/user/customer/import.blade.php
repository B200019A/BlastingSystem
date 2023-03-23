@extends('layouts.app')
@section('content')
<div class="container col-sm-12   mt-3">
    <h3>Upload Excel</h3>
        <form class="row g-3" method="POST" action="{{route('import_customer')}}" enctype="multipart/form-data">
            @csrf
        <input type="file" class="form-control" name="customer_excel">
        <button type="submit" class="btn btn-primary">Upload</button>
        @error('customer_excel')
            <span class="text-danger">{{$message}}</span>
        @enderror
        </form>
<div>
@endsection
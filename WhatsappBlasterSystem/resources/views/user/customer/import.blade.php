@extends('layouts.app')
@section('content')
    <div>
        <div class="container">
            <div class="row">
                <div class="col col-12 col-md-3"></div>
                <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                    <h2 class="text-center mb-5">Upload Excel</h2>
                    <form class="row g-3" method="POST" action="{{ route('import_customer') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="customer_excel">
                        <input type="hidden" name="blaster_id" value='{{ $blaster_id }}'>
                        <input type="hidden" name="current_existed" value='{{ $current_existed }}'>
                        {{-- <button type="submit" class="btn btn-primary">Upload</button> --}}
                        <button onclick="submitForm(this)" class="btn btn-primary">Upload</button>
                        @error('customer_excel')
                            <span class="text-danger">{{ str_replace(', txt', '', $message) }}</span>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-3"></div>
            <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                <h2 class="text-center mb-5">Create new list</h2>
                @if (isset($blaster))
                    <form action="{{ route('blaster_update') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('blaster_add') }}" method="POST" enctype="multipart/form-data">
                @endif
                @CSRF

                <div class="form-group">
                    <input class="form-control" type="hidden" id="blaster_id" name="blaster_id" value="{{ isset($blaster->id) ? $blaster->id : null }}">
                    <label for="blaster_name">Name</label>
                    <input class="form-control" type="text" id="blaster_name" name="blaster_name"
                        value="{{ isset($blaster->name) ? $blaster->name : null }}" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">{{ isset($blaster) ? 'Upadte' : 'Create' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

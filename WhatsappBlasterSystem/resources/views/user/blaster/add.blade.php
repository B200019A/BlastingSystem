@extends('layouts.app')
@section('content')
    <div class="container col-sm-12   mt-3">
        <h3>Create new list</h3>
            <form action="{{ route('blaster_add') }}" method="POST" enctype="multipart/form-data">
                @CSRF

                <div class="form-group">
                    <label for="blaster_name">Name</label>
                    <input class="form-control" type="text" id="w" name="blaster_name" required>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>
            <div>
@endsection

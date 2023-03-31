@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-3"></div>
            <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                <h2 class="text-center mb-5">Create new list</h2>
                <form action="{{ route('blaster_add') }}" method="POST" enctype="multipart/form-data">
                    @CSRF

                    <div class="form-group">
                        <label for="blaster_name">Name</label>
                        <input class="form-control" type="text" id="w" name="blaster_name" required>
                    </div>
                     <br>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-3"></div>
            <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                <h2 class="text-center mb-5">Testing</h2>
                <form action="{{ route('test') }}" method="POST" enctype="multipart/form-data">
                    @CSRF

                    <div class="form-group">
                        <label for="blaster_name">Name</label>
                        <input class="form-control" type="text" id="w" name="blaster_name">
                    </div>
                     <br>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-3"></div>
            <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                <h3>Profile</h3>
                @if ($check == 'admin')
                    <form action="{{ route('profile_update_user') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('profile_update') }}" method="POST" enctype="multipart/form-data">
                @endif
                @CSRF
                <div class="form-group">

                    <input class="form-control" type="hidden" id="id" name="id" value="{{ $profile->id }}">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" id="name" name="name" value="{{ $profile->name }}"
                        required>
                    <br>
                    <label for="email">Email</label>
                    <input class="form-control" type="text" id="email" name="email" value="{{ $profile->email }}"
                        disabled>
                    <br>
                    <label for="email">Phone Number</label>
                    <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror"
                        name="phone" value="{{ $profile->phone }}" required autocomplete="phone">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container col-sm-12   mt-3">
        <h3>Profile</h3>
        <form action="{{ route('profile_update') }}" method="POST" enctype="multipart/form-data">
            @CSRF
            <div class="form-group">

                <input class="form-control" type="hidden" id="id" name="id" value="{{ $profile->id }}">
                <label for="name">Name</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $profile->name }}" required>
                <label for="email">Email</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ $profile->email }}" disabled>
                <label for="email">Phone Number</label>
                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror"
                    name="phone" value="{{ $profile->phone }}" required autocomplete="phone">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <div>
        @endsection

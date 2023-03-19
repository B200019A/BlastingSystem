@extends('layouts.app')
@section('content')
    <div class="container col-sm-12   mt-3">
        <h3>On Send API Key</h3>
        @if ($check == 'none')
            <form action="{{ route('api_edit') }}" method="POST" enctype="multipart/form-data">
                @CSRF

                <div class="form-group">
                    <label for="key">API Key</label>
                    <input class="form-control" type="text" id="key" name="key" value="{{ $api }}"
                        readonly>
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>


            </form>
        @else
            <form action="{{ route('api_update') }}" method="POST" enctype="multipart/form-data">
                @CSRF
                <div class="form-group">
                    <label for="key">API Key</label>
                    <input class="form-control" type="text" id="key" name="key" value="{{ $api }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        @endif
        <div>
@endsection

@extends('layouts.app')
@section('content')
            <div class="container">
                <div class="row">
                    <div class="col col-12 col-md-3"></div>
                    <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                        <h3>On Send API Key</h3>
                        @if ($check == 'none')
                            <form action="{{ route('api_edit') }}" method="POST" enctype="multipart/form-data">
                                @CSRF

                                <div class="form-group">
                                    <label for="key">API Key</label>
                                    <input class="form-control" type="text" id="key" name="key"
                                        value="{{ $api }}" readonly>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Edit</button>


                            </form>
                        @else
                            <form action="{{ route('api_update') }}" method="POST" enctype="multipart/form-data">
                                @CSRF
                                <div class="form-group">
                                    <label for="key">API Key</label>
                                    <input class="form-control" type="text" id="key" name="key"
                                        value="{{ $api }}" required>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endsection

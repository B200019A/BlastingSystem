@extends('layouts.app')
@section('content')
    <section class="mt-sm-5">
        <div class="container">
            <div class="row mb-sm-3">
                <h1 style="text-align:center">Customer List</h1>
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="row">
                        <form action="{{ route('blaster_update') }}" method="POST" enctype="multipart/form-data">
                            @CSRF
                            <div class="input-group">
                                <input type="hidden" value="{{ $blaster->id }}" name="blaster_id">
                                <h5 style="padding-top:6px; padding-right:5px;">Blaster Name: </h5>
                                <div class="custom-file">
                                    <input class="form-control" type="text" id="blaster_name" name="blaster_name"
                                        value="{{ $blaster->name }}">
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit"><i
                                            class="fa fa-edit"></i></button>
                                </div>
                            </div>
                        </form>
                        @CSRF
                        <div class="input-group">
                            <h5 style="padding-top:6px; padding-right:5px;">Import: </h5>
                            <div class="custom-file">
                            </div>
                            <div class="input-group-append">
                                <a class="btn btn-outline-secondary"  href="{{ route('import_view', ['id' => $blaster->id]) }}"><i
                                        class="fa fa-upload"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">

                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Attribute1</th>
                                <th>Attribute2</th>
                                <th>Attribute3</th>
                                <th>Attribute4</th>
                                <th>Attribute5</th>
                                <th>Attribute6</th>
                                <th>Attribute7</th>
                                <th>Operate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($blaster->customers->isNotEmpty())
                                @foreach ($blaster->customers as $key => $customer)
                                    <tr>
                                        <th>{{ $key + 1 }}</th>
                                        <td>{{ $customer->attribute1 }}</td>
                                        <td>{{ $customer->attribute2 }}</td>
                                        <td>{{ $customer->attribute3 }}</td>
                                        <td>{{ $customer->attribute4 }}</td>
                                        <td>{{ $customer->attribute5 }}</td>
                                        <td>{{ $customer->attribute6 }}</td>
                                        <td>{{ $customer->attribute7 }}</td>
                                        <td>
                                            <a href="{{ route('blaster_delete', ['id' => $blaster->id]) }}"
                                                onClick="return confirm('Are you sure to delete?')"
                                                class="btn btn-danger btn-xs">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">Add Customer List now!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-2"></div>
            </div>

        </div>
    </section>
@endsection

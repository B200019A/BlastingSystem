@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                    <h1 class="text-center mb-md-3 mt-md-3">Blaster List</h1>
                </div>
                <div class="p-4">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Quantity/300</th>
                                <th>Operates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($blasters->isNotEmpty())
                                @foreach ($blasters as $key => $blaster)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $blaster->name }} </td>
                                        <td> {{ $blaster->customers->count() }}</td>
                                        <td><a href="{{ route('blaster_view_customer', ['id' => $blaster->id]) }}"
                                                class="btn btn-primary btn-xs">view customer</a>
                                            <a href="{{ route('blaster_delete', ['id' => $blaster->id]) }}"
                                                onClick="return confirm('Are you sure to delete?')"
                                                class="btn btn-danger btn-xs">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Add Blaster List now!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

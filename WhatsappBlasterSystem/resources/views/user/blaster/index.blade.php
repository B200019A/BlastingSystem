@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                      @if ($blasters == 'blaster_history_null')
                        <h1 class="text-center mb-md-3 mt-md-3">Recently Deleted Blaster List</h1>
                    @elseif($blasters->isNotEmpty() && $blasters[0]->deleted_at != null)
                        <h1 class="text-center mb-md-3 mt-md-3">Recently Deleted Message List</h1>
                    @else
                        <h1 class="text-center mb-md-3 mt-md-3">Blaster List</h1>
                    @endif
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
                            @if ($blasters)
                                @if($blasters == "blaster_history_null")
                                 <tr>
                                    <td colspan="5" class="text-center">Empty Deleted Blaster</td>
                                </tr>
                                @else
                                @foreach ($blasters as $key => $blaster)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $blaster->name }} </td>
                                        <td> {{ $blaster->customers->count() }}</td>
                                        @if($blaster->deleted_at== null)
                                        <td><a href="{{ route('blaster_view_customer', ['id' => $blaster->id]) }}"
                                                class="btn btn-primary btn-xs">view customer</a>
                                            <a href="{{ route('blaster_delete', ['id' => $blaster->id]) }}"
                                                onClick="return confirm('Are you sure to delete?')"
                                                class="btn btn-danger btn-xs">Delete</a>
                                        </td>
                                        @else
                                        <td> <a href="{{ route('blaster_restore', ['id' => $blaster->id]) }}"
                                                    onClick="return confirm('Are you sure to restore?')"
                                                    class="btn btn-success btn-xs">Recovery</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @endif
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

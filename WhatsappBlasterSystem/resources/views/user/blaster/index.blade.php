@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <br><br>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity/300</th>
                        <th>Operates</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($blasters->isNotEmpty())
                        @foreach ($blasters as $blaster)
                                <tr>
                                    <td>{{ $blaster->name }}</td>
                                    <td> {{ $blaster->customers->count() }}</td>
                                    <td><a href="{{ route('blaster_edit_view', ['id' => $blaster->id]) }}" class="btn btn-primary btn-xs">Edit</a>
                                        <a href="{{ route('blaster_delete', ['id' => $blaster->id]) }}"
                                             onClick="return confirm('Are you sure to delete?')" class="btn btn-primary btn-xs">Delete</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Add Blasting List now!</td>
                            </tr>
                        @endif
                </tbody>
            </table>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection

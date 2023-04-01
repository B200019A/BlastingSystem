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
                                <th>Image</th>
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
                                        <td><a class="viewImage" data-toggle="modal"
                                                data-id="{{ asset('images') }}/{{ $blaster->image }}"
                                                data-target="#imageModal">{{ $blaster->image }}</a></td>
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
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Blaster Image</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img alt="" class="img-fluid image">
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script>
        //for using bootstrap js need to use '$(document).ready(function (){' and above src to call
        $(document).ready(function() {
            //id should be unique so instead of using id it is better to use class
            $('.viewImage').click(function() {

                var image = $(this).data('id');
                console.log(image);
                $('.image').attr('src', image);
                $('#imageModal').modal('show');
            });
        });
    </script>
@endsection

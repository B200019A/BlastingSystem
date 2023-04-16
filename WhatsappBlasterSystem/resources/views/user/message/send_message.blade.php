@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                    <h1 class="text-center mb-md-3 mt-md-3">History Send Message List</h1>
                </div>
                <div class="p-4">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Meesage</th>
                                <th>List Name</th>
                                <th>Send time</th>
                                <th>Image</th>
                                <th>Operates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($sendMessages))
                                @foreach ($sendMessages as $key => $sendMessage)
                                    <tr>
                                    <td>{{ $key+1}}</td>

                                        <td>{{ $sendMessage->messages->message }}</td>
                                        <td>{{ $sendMessage->blasters->name }}</td>
                                        <td>{{ $sendMessage->send_time }}</td>
                                        @if (isset($sendMessage->messages->image))
                                            <td><a class="viewImage" data-toggle="modal"
                                                    data-id="{{ asset('images') }}/{{ $sendMessage->messages->image }}"
                                                    data-target="#imageModal">{{ $sendMessage->messages->image }}</a></td>
                                        @else
                                            <td style="color:grey;">None</td>
                                        @endif
                                        <td> <a href="{{ route('history_customer_view', ['id' => $sendMessage->send_time]) }}"
                                                class="btn btn-primary btn-xs">View</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Empty Send Message History</td>
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

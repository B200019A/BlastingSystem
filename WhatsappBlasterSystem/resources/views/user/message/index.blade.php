@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                    @if ($messages == 'message_history_null')
                        <h1 class="text-center mb-md-3 mt-md-3">Recently Deleted Message List</h1>
                    @elseif($messages->isNotEmpty() && $messages[0]->deleted_at != null)
                        <h1 class="text-center mb-md-3 mt-md-3">Recently Deleted Message List</h1>
                    @else
                        <h1 class="text-center mb-md-3 mt-md-3">Message List</h1>
                    @endif
                </div>
                <div class="p-4">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Meesage</th>
                                <th>List Name</th>
                                <th>Auto Send time</th>
                                <th>Image</th>
                                <th>Operates</th>
                                @if (isset($messages))
                                    <th>Send Option</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($messages == 'message_history_null')
                                <tr>
                                    <td colspan="7" class="text-center">Empty Deleted Messages</td>
                                </tr>
                            @elseif ($messages->isNotEmpty())
                                @foreach ($messages as $key => $message)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $message->message }}</td>
                                        <td>{{ isset($message->blasters->name) ? $message->blasters->name : 'none' }}</td>
                                        <td>{{ $message->send_time }}</td>
                                        @if (isset($message->image))
                                            <td><a class="viewImage" data-toggle="modal"
                                                    data-id="{{ asset('images') }}/{{ $message->image }}"
                                                    data-target="#imageModal">{{ $message->image }}</a></td>
                                        @else
                                            <td style="color:grey;">None</td>
                                        @endif
                                        @if ($message->deleted_at == null)
                                            <td><a href="{{ route('message_edit_view', ['id' => $message->id]) }}"
                                                    class="btn btn-success btn-xs">Edit</a>
                                                <a href="{{ route('message_delete', ['id' => $message->id]) }}"
                                                    onClick="return confirm('Are you sure to delete?')"
                                                    class="btn btn-danger btn-xs">Delete</a>
                                            </td>
                                            <td><a href="{{ route('send_now', ['id' => $message->id]) }}"
                                                    class="btn btn-primary btn-xs">Send Now</a>
                                                <a href="" class="btn btn-secondary btn-xs">Send Later</a>
                                            </td>
                                        @else
                                            <td> <a href="{{ route('message_restore', ['id' => $message->id]) }}"
                                                    onClick="return confirm('Are you sure to restore?')"
                                                    class="btn btn-success btn-xs">Recovery</a>
                                            </td>
                                            <td style="color:grey">None</td>
                                        @endif

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Add Message List now!</td>
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

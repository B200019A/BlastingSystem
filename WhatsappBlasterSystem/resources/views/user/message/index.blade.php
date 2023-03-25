@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                    <h1 class="text-center mb-md-3 mt-md-3">Message List</h1>
                </div>
                <div class="p-4">
                        <table id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Meesage</th>
                                    <th>List Name</th>
                                    <th>Send time</th>
                                    <th>Phone</th>
                                    <th>Operates</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($messages->isNotEmpty())
                                    @foreach ($messages as $key => $message)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td>{{ $message->blasters->name }}</td>
                                            <td>{{ $message->send_time }}</td>
                                            <td>{{ $message->phone }}</td>
                                            <td><a href="{{ route('message_edit_view', ['id' => $message->id]) }}"
                                                    class="btn btn-secondary btn-xs">Edit</a>
                                                <a href="{{ route('message_delete', ['id' => $message->id]) }}"
                                                    onClick="return confirm('Are you sure to delete?')"
                                                    class="btn btn-danger btn-xs">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">Add Message List now!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                    @if ($messages == 'history_null')
                        <h1 class="text-center mb-md-3 mt-md-3">History Message List</h1>
                    @elseif($messages->isNotEmpty() && $messages[0]->deleted_at != null)
                        <h1 class="text-center mb-md-3 mt-md-3">History Message List</h1>
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
                                <th>Send time</th>
                                <th>Phone</th>
                                <th>Operates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($messages == 'history_null')
                                <tr>
                                    <td colspan="6" class="text-center">Empty History</td>
                                </tr>
                            @elseif ($messages->isNotEmpty())
                                @foreach ($messages as $key => $message)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $message->message }}</td>
                                        <td>{{ $message->blasters->name }}</td>
                                        <td>{{ $message->send_time }}</td>
                                        <td>{{ $message->phone }}</td>
                                        @if ($message->deleted_at == null)
                                            <td><a href="{{ route('message_edit_view', ['id' => $message->id]) }}"
                                                    class="btn btn-secondary btn-xs">Edit</a>
                                                <a href="{{ route('message_delete', ['id' => $message->id]) }}"
                                                    onClick="return confirm('Are you sure to delete?')"
                                                    class="btn btn-danger btn-xs">Delete</a>
                                            </td>
                                        @else
                                            <td> <a href="{{ route('history_customer_view', ['id' => $message->id]) }}"
                                                    class="btn btn-primary btn-xs">View</a></td>
                                        @endif
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

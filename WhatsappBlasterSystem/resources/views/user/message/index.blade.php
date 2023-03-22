@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <br><br>
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Meesage</th>
                        <th>List Name</th>
                        <th>Send time</th>
                        <th>Operates</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($messages->isNotEmpty())
                        @foreach ($messages as $key=>$message)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ $message->blasters->name }}</td>
                                <td>{{ $message->send_time }}</td>
                                <td><a href="{{ route('message_edit_view', ['id' => $message->id]) }}"
                                        class="btn btn-primary btn-xs">Edit</a>
                                    <a href="{{ route('message_delete', ['id' => $message->id]) }}"
                                        onClick="return confirm('Are you sure to delete?')"
                                        class="btn btn-primary btn-xs">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">Add Message List now!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection

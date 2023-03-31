@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card p-0 rounded-4">
                <div class="card-header">
                    <h1 class="text-center mb-md-3 mt-md-3">Customer List</h1>
                </div>
                <div class="p-4">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>List Name</th>
                                <th>Customer Id</th>
                                <th>Message</th>
                                <th>Phone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customersMessages as $key => $customersMessage)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $customersMessage->blasters->name }}</td>
                                    <td>{{ $customersMessage->customers->id }}</td>
                                    <td>{{ $customersMessage->full_message }}</td>
                                    <td>{{ $customersMessage->phone }}</td>
                                    {{-- mean that resend successful  --}}
                                    @if($customersMessage->pass_at != null)
                                       <td style="color:green">Successful</td>
                                    @else
                                        <td><a href="{{ route('resend_message', ['id' => $customersMessage->id]) }}" class="btn btn-primary btn-xs">Resend</a></td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

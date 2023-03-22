@extends('layouts.app')
@section('content')
    @inject('carbon', 'Carbon\Carbon')

    <div class="container col-sm-12   mt-3">
        <h3>Create new blasting message list</h3>
        @if (isset($message))
            <form action="{{ route('message_update') }}" method="POST" enctype="multipart/form-data">
            @else
                <form action="{{ route('message_add') }}" method="POST" enctype="multipart/form-data">
        @endif
        @CSRF

        <div class="form-group">
            <select name="blaster_id" id="blaster_id" class="form-control">
                @foreach ($blasters as $blaster)
                    @if ($message->blaster_id == $blaster->id)
                        <option value="{{ $blaster->id }}" selected>{{ $blaster->name }}</option>
                    @else
                        <option value="{{ $blaster->id }}">{{ $blaster->name }}</option>
                    @endif
                    @endforeach
            </select>
            <label for="blasting_name">message</label>
            <input class="form-control" type="text" id="message" name="message"
                value="{{ $message->message ?? null }}">
            <p>The available field name:
                [attribute1],[attribute2],[attribute3],[attribute4],[attribute5],[attribute6],[attribute7] (<small>You
                    can copy the attribute apply to your message</small>)</p>

            <label for="date">Date</label>
            <input class="form-control" type="date" id="date" name="date"
                value="{{ isset($message->send_time) ? $carbon::parse($message->send_time)->format('Y-m-d') : null }}">
            <label for="time">Time</label>
            <input class="form-control" type="time" id="time" name="time"
                value="{{ isset($message->send_time) ? $carbon::parse($message->send_time)->format('H:i') : null }}">

        </div>


        <button type="submit" class="btn btn-primary">Create</button>
        </form>
        <div>
        @endsection

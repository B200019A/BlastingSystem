@extends('layouts.app')
@section('content')
    @inject('carbon', 'Carbon\Carbon')

    <div class="container col-sm-12   mt-3">
        <h3>Create new blaster message list</h3>
        @if (isset($message))
            <form action="{{ route('message_update') }}" method="POST" enctype="multipart/form-data">
            @else
                <form action="{{ route('message_add') }}" method="POST" enctype="multipart/form-data">
        @endif
        @CSRF

        <div class="form-group">
            <select name="blaster_id" id="blaster_id" class="form-control">
                @foreach ($blasters as $blaster)
                    @if (isset($message->blaster_id) == $blaster->id)
                        <option value="{{ $blaster->id }}" selected>{{ $blaster->name }}</option>
                    @else
                        <option value="{{ $blaster->id }}">{{ $blaster->name }}</option>
                    @endif
                @endforeach
            </select>
            <label for="message">message</label>
            <input class="form-control" type="text" id="message" name="message"
                value="{{ $message->message ?? null }}">
            @error('message')
                <span class="invalid-message" style="color:red;" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <p>The available field name:
                [attribute1],[attribute2],[attribute3],[attribute4],[attribute5],[attribute6],[attribute7] (<small>You
                    can copy the attribute apply to your message</small>)</p>
            <select name="phone" id="phone" class="form-control">
                @if (isset($message))
                    <option value="attribute1" {{ $message->phone == 'attribute1' ? 'selected' : '' }}>Attribute1</option>
                    <option value="attribute2" {{ $message->phone == 'attribute2' ? 'selected' : '' }}>Attribute2</option>
                    <option value="attribute3" {{ $message->phone == 'attribute3' ? 'selected' : '' }}>Attribute3</option>
                    <option value="attribute4" {{ $message->phone == 'attribute4' ? 'selected' : '' }}>Attribute4</option>
                    <option value="attribute5" {{ $message->phone == 'attribute5' ? 'selected' : '' }}>Attribute5</option>
                    <option value="attribute6" {{ $message->phone == 'attribute6' ? 'selected' : '' }}>Attribute6</option>
                    <option value="attribute7" {{ $message->phone == 'attribute7' ? 'selected' : '' }}>Attribute7</option>
                @else
                    <option value="attribute1">Attribute1</option>
                    <option value="attribute2">Attribute2</option>
                    <option value="attribute3">Attribute3</option>
                    <option value="attribute4">Attribute4</option>
                    <option value="attribute5">Attribute5</option>
                    <option value="attribute6">Attribute6</option>
                    <option value="attribute7">Attribute7</option>
                @endif
            </select>
            <br>
            <label for="date">Date</label>
            <input class="form-control" type="date" id="date" name="date"
                value="{{ isset($message->send_time) ? $carbon::parse($message->send_time)->format('Y-m-d') : null }}">
            @error('date')
                <span class="invalid-message" style="color:red;" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <label for="time">Time</label>
            <input class="form-control" type="time" id="time" name="time"
                value="{{ isset($message->send_time) ? $carbon::parse($message->send_time)->format('H:i') : null }}">
            @error('time')
                <span class="invalid-message" style="color:red;" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>


        <button type="submit" class="btn btn-primary">Create</button>
        </form>
        <div>
        @endsection

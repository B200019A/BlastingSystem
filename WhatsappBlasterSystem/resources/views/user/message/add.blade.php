@extends('layouts.app')
@section('content')
    @inject('carbon', 'Carbon\Carbon')

    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-3"></div>
            <div class="col col-12 col-md-6 mt-md-5 border p-2 p-md-5 rounded-5 form-background">
                <h2 class="text-center mb-5">Create new message list</h2>
                @if (isset($message))
                    <form action="{{ route('message_update') }}" method="POST" enctype="multipart/form-data">
                    @else
                        <form action="{{ route('message_add') }}" method="POST" enctype="multipart/form-data">
                @endif
                @CSRF

                <div class="form-group">
                    <input type="hidden" name="meesage_id" value={{ isset($message->id) ? $message->id : null }}>
                    <select name="blaster_id" id="blaster_id" class="form-control" value="{{ isset($message) ? '' : '1' }}"
                        required>
                        @foreach ($blasters as $blaster)
                            @if (isset($message))
                                @if ($message->blaster_id == $blaster->id)
                                    <option value="{{ $blaster->id }}" selected>{{ $blaster->name }}</option>
                                @else
                                    <option value="{{ $blaster->id }}">{{ $blaster->name }}</option>
                                @endif
                            @else
                                <option value="{{ $blaster->id }}">{{ $blaster->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="message">message</label>
                     <textarea  class="form-control" id="message" name="message" rows="4" cols="50">{{ $message->message ?? null }}</textarea>
                    @error('message')
                        <span class="invalid-message" style="color:red;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p>The available field name:
                        [attribute1],[attribute2],[attribute3],[attribute4],[attribute5],[attribute6],[attribute7]
                        (<small>You
                            can copy the attribute apply to your message</small>)</p>
                    <select name="phone" id="phone" class="form-control">
                        @if (isset($message))
                            <option value="attribute1" {{ $message->phone == 'attribute1' ? 'selected' : '' }}>Attribute1
                            </option>
                            <option value="attribute2" {{ $message->phone == 'attribute2' ? 'selected' : '' }}>Attribute2
                            </option>
                            <option value="attribute3" {{ $message->phone == 'attribute3' ? 'selected' : '' }}>Attribute3
                            </option>
                            <option value="attribute4" {{ $message->phone == 'attribute4' ? 'selected' : '' }}>Attribute4
                            </option>
                            <option value="attribute5" {{ $message->phone == 'attribute5' ? 'selected' : '' }}>Attribute5
                            </option>
                            <option value="attribute6" {{ $message->phone == 'attribute6' ? 'selected' : '' }}>Attribute6
                            </option>
                            <option value="attribute7" {{ $message->phone == 'attribute7' ? 'selected' : '' }}>Attribute7
                            </option>
                        @else
                            <option value="attribute1" selected>Attribute1</option>
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
                    <input class="form-control" type="date" id="date" name="date" min=""
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
                    <br>
                    <button type="submit" class="btn btn-primary">{{ isset($message) ? 'Update' : 'Create' }} </button>
                </div>
                </form>
            </div>
            <div class="col col-12 col-md-3"></div>
        </div>
    </div>

    <script>
        var dateRange = document.querySelector("#date");
        var date_now = new Date().getTime();
        var date_now = new Date(date_now);

        to_YY_MM_DD = function(date) {

            let year = date.getFullYear();
            let month = date.getMonth() + 1;
            let day = date.getDate();

            month = (month < 10) ? '0' + month : month;
            day = (day < 10) ? '0' + day : day;
            return year + '-' + month + '-' + day;
        }

        var min = to_YY_MM_DD(date_now);

        dateRange.setAttribute("min", min);
    </script>
@endsection

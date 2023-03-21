@extends('layouts.app')
@section('content')
    <div class="container col-sm-12   mt-3">
        <h3>Create new blasting message list</h3>
        <form action="{{ route('message_add') }}" method="POST" enctype="multipart/form-data">
            @CSRF

            <div class="form-group">
                <select name="blasting_id" id="blasting_id" class="form-control" >
                    @foreach ($blastingLists as $blastingList)
                        <option value="{{ $blastingList->id }}">{{ $blastingList->name }}</option>
                    @endforeach
                </select>
                <label for="blasting_name">message</label>
                <input class="form-control" type="text" id="message" name="message" >

                <label for="date">Date</label>
                <input class="form-control" type="date" id="date" name="date" >
                <label for="time">Time</label>
                <input class="form-control" type="time" id="time" name="time" >

            </div>


            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        <div>
        @endsection

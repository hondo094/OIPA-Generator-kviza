@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>Promjena lozinke<span class="dot">.</span></p>
</div>
@stop


@section('content')
<div class="wrapper">
    <form action="{{ action('RemindersController@postRemind') }}" method="POST">
        <div class="formInput">
            <label>Upišite e-mail adresu:</label><br>
            <input type="email" name="email" class="formInputArea">
            <br>
            <input class="btn" type="submit" value="Pošalji e-mail.">
        </div
    </form>
</div>
@stop


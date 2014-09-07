@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>Promjena lozinke<span class="dot">.</span></p>
</div>
@stop

@section('content')
<div class="wrapper">
    <div class="formInput">
        <form action="{{ action('RemindersController@postReset') }}" method="POST">
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="formInput">
                <label>E-mail adresa:</label><br>
                <input type='text' name='email' class="formInputArea"> 
            </div>
            <div class="formInput">
                <label>Nova lozinka:</label><br>
                 <input type='password' name='password' class="formInputArea">
            </div>
            <div class="formInput">
                <label>Nova lozinka (još jednom):</label><br>
                <input type='password' name='password_confirmation' class="formInputArea"> 
            </div>
            <input class="btn" type="submit" value="Potvrdi" class="formInputArea">
        </form>
    </div>
</div>
@stop

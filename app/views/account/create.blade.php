@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>Registracija<span class="dot">.</span></p>
</div>
@stop

@section('content')
<div class="wrapper">
<form action="{{ URL::route('account-create-post') }}" method="post">
    
     <div class="formInput">
        <label for="firstName">Ime:</label><br>
        <input type='text' id="firstName" name='firstName'{{ (Input::old('firstName')) ? ' value="' . e(Input::old('firstName')) . '"' : '' }} class="formInputArea" >        
        @if($errors->has('firstName'))
            {{{ $errors->first('firstName') }}}
        @endif
     </div>
     <div class="formInput">
        <label for="lastName">Prezime:</label><br>
        <input type='text' id="lastName" name='lastName'{{ (Input::old('lastName')) ? ' value="' . e(Input::old('lastName')) . '"' : '' }} class="formInputArea" >        
        @if($errors->has('lastName'))
            {{{ $errors->first('lastName') }}}
        @endif
     </div>
    <div class="formInput">
        <label for="email">Email:</label><br>
        <input type='text' id="email" name='email'{{ (Input::old('email')) ? ' value="' . e(Input::old('email')) . '"' : '' }} class="formInputArea" > 
        @if($errors->has('email'))
            {{{ $errors->first('email') }}}
        @endif
    </div>
    <div class="formInput">
        <label for="username">Username:</label><br>
        <input type='text' id="username" name='username'{{ (Input::old('username')) ? ' value="' . e(Input::old('username')) . '"' : '' }} class="formInputArea" >  
         @if($errors->has('username'))
            {{{ $errors->first('username') }}}
        @endif
    </div>
    <div class="formInput">
        <label for="password">Lozinka:</label><br>
        <input type='password' id="password" name='password' class="formInputArea" > 
        @if($errors->has('password'))
            {{{ $errors->first('password') }}}
        @endif
    </div>
    <div class="formInput">
        <label for="passwordAgain">Lozinka ponovno:</label><br>
        <input type='password' id="passwordAgain" name='password_again' class="formInputArea" > 
         @if($errors->has('password_again'))
            {{{ $errors->first('password_again') }}}
        @endif
    </div>
    
    <div class="formInput">
        <div class="captchaArea">
            <label for="inputCaptcha">Unesite tekst sa slike:</label>
            <div class="klasa">
                <div class="leftCaptcha">
                    {{ HTML::image(Captcha::img(), 'alt text capcha image') }}<br>
                </div>
                <div class="rightCaptcha">
                    <input type='text' name='captcha' class="formCaptchaInput" id="inputCaptcha"> 
                </div>
            </div>
        </div>
    </div>
    <div class="formInputArea">
        <div class="centerBtn">
            <input type="submit" value='registriraj se' class='btn'>
        </div>
    </div>
    {{ Form::token() }}
    
</form>
    </div>
        
        
@stop
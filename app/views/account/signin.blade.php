@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>Login<span class="dot">.</span></p>
</div>
@stop


@section('content')
    <div class="wrapper">
    <div class="formArea">

        <form action="{{ URL::route('account-sign-in-post') }}" method="post">

            <div class="formInput">
                <label for="inputUsername">Email:</label>
                <div>
                    <input type='text' name='email'{{ (Input::old('email')) ? ' value="' . e(Input::old('email')) . '"' : '' }} class="formInputArea" id="inputEmail">      
                    @if($errors->has('email'))
                        {{{ $errors->first('email') }}}
                    @endif
                </div>
            </div>
             <div class="formInput">
                <label for="inputPassword">Lozinka:</label>
                <div>
                    <input type='password' name='password' class="formInputArea" id="inputPassword"> 
                    @if($errors->has('password'))
                       {{{ $errors->first('password') }}}
                   @endif     
                </div>
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
                    <input type="submit" value='login' class='btn'>
                </div>
            </div>
            {{ Form::token() }}
        </form>
        <div class="formInputArea">
        <div class="centerBtn">
        @if(Session::has('loginMsg'))
            <p>{{ Session::get('loginMsg') }}</p>
        @endif
        </div>
        </div>
    </div>
</div>
@stop


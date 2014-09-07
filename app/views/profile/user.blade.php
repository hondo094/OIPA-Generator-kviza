@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>{{ Auth::user()->username }}<span class="dot">.</span></p>
   
</div>
@stop


@section('content')
<div class="wrapper">

    <div class="sideBySide">
        <div class="left" >
            <div class="listBackground">
                <div class="uploadArea">
                    <h3>Upload kviza:</h3><br>
                    {{ Form::open(['route'=>'upload-post', 'files'=>true]) }}
                    {{ Form::file('file') }}

                    <br><br>
                    {{ Form::label('Odaberite razinu privatnosti:') }}<br>
                    <label>
                        {{ Form::radio('radio', 'public', true) }} <span>javno</span>
                    </label><br>
                    <label>
                        {{ Form::radio('radio', 'private') }} <span>privatno</span>
                    </label> <br>
                    @if( $membership )
                    <label>                        
                        {{ Form::radio('radio', 'restricted') }} <span>ograničeno</span>
                    </label><br>
                    @endif
                    <br><br>
                    {{ Form::submit('upload') }}

                    {{ Form::close() }}       
                    @if(Session::has('message'))
                    <p>{{ Session::get('message') }}</p>
                    @endif    
                </div>
            </div>
            <br>
            <div class="listBackground">
                <h3>Promjena lozinke:</h3><br>
                <a href="{{ URL::action('RemindersController@getRemind') }}">Klikni ovdje za promjenu lozinke.</a>
            </div>
            <br>
            <div class="listBackground">
                <h3>Grupa za komentiranje:</h3><br>
                <form action="{{ URL::route('join-post') }}" method="post">
                    <input type="radio" name="radio_join" value=1>pridruži se grupi<br>
                    <input type="radio" name="radio_join" value=0>napusti grupu<br>
                    <br>
                    <input type="submit" value="Potvrdi">
                    @if(Session::has('joinMessage'))
                    <p>{{ Session::get('joinMessage') }}</p>
                    @endif 
                    {{ Form::token() }}
                </form>
            </div>
            <br>
        </div>


        <div class="right">
            <div class="listBackground">
                <h3>Popis vaših kvizova:</h3> <br>
                @if(Session::has('editMessage'))
                <p>{{ Session::get('editMessage') }}</p>
                @endif  
                <table>                   
                    @foreach ( $userQuizzes as $id => $name )
                    <tr>                        
                        <td class="edit"><a href="{{ route('quizz-edit',  $id); }}">[uredi]</a></td>           
                        <td class="edit"><a href="{{ route('quizz-delete',  $id); }}">[obriši]</a></td>
                        <td class="name"><a href="{{ route('quizz-display',  $id); }}">{{ $name }}</a></td>
                    </tr>
                    @endforeach                    
                </table>

            </div>
        </div>
    </div>
</div>
@stop
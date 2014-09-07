@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>Generator kviza<span class="dot">.</span></p>
</div>
@stop

@section('content')    
 

    <div class="wrapper">
        <div class="sideBySide">
            <div class="left" >
                <div class="listBackground">
                    <h2>Popis javnih kvizova: </h2>
                    <br>
                    <ul>
                        @foreach ( $publicQuizzes as $id => $name )
                            <li><a href="{{ route('quizz-display',  $id); }}">{{ $name }}</a></li>            
                        @endforeach
                    </ul>
                </div>
            </div>
@if(Auth::check() && $membership===1) 
            <div class="right">
                <div class="listBackground">
                                   
                <h2>Popis ograničenih kvizova: </h2>
                <br>
                <ul>
                    @foreach ( $restrictedQuizzes as $id => $name )
                        <li><a href="{{ route('quizz-display',  $id); }}">{{ $name }}</a></li>            
                    @endforeach
                </ul>
                
            </div>
            </div>
@endif
        </div>

    </div>




@stop
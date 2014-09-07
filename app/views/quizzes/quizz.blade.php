@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>{{ $title }}<span class="dot">.</span></p>
<!--    <p>ne, ne.<span class="dot"> :)</span></p>-->
   
</div>
@stop


@section('content')
<div class="bodyContent">
    <div class="wrapper">
        
        <form action="{{ URL::route('quizz-display-post', $quizzName) }}" method="post">
        @foreach ( $questions as $key => $value )
            <p>{{{ $value['question'] }}}</p>
            
            @foreach ( $value['answers'] as $answer )            
                @if ($value['type'] == 'SINGLE')
                    <input type="radio" name="radio_{{{ $key }}}" value="{{{ $answer }}}">{{{ $answer }}}<br>
                @elseif ($value['type'] == 'MULTIPLE')
                    <input type="checkbox" name="checkbox_{{{ $key }}}[]" value="{{{ $answer }}}">{{{ $answer }}}<br>
                @elseif ($value['type'] == 'CUSTOM')
                    <input type="textbox" name="textbox_{{{ $key }}}" value="{{{ $answer }}}"><br>
                @endif
            @endforeach
        <br>
        @endforeach
        
        <input type="submit" value="Potvrdi">
        {{ Form::token() }}
        </form>
        
    </div>
</div>
@stop
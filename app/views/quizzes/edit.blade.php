@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>Uredi kviz<span class="dot">.</span></p>
   
</div>
@stop


@section('content')
<div class="bodyContent">
    <div class="wrapper">

        <form action="{{ URL::route('quizz-edit-post', $quizzName) }}" method="post">
            <p>Naslov kviza: </p>
                <input class="editQuestion" type="text" name="new_title" value="{{ $title }}"><br><br>
            @foreach ( $data as $key => $value )
                <p>Obriši pitanje: </p>
                <input type="checkbox" name="deleteQuestion_{{ $key }}" value=1><br>
                <p>Pitanje: </p>
                <input class="editQuestion" type="text" name="newQuestion_{{ $key }}" value="{{ $value['question'] }}"><br>
                @if ($value['type'] == 'SINGLE' || $value['type'] == 'MULTIPLE')
                    <p>Odgovori: </p>
                @endif
                @foreach ( $value['answers'] as $answer )  
                    @if ($value['type'] == 'SINGLE')                
                        <input class="editAnswer" type="text" name="newAnswer_{{ $key }}[]" value="{{ $answer }}"><br>
                    @elseif ($value['type'] == 'MULTIPLE')                
                        <input class="editAnswer"  type="text" name="newAnswer_{{ $key }}[]" value="{{ $answer }}"><br>
                    @endif
                @endforeach
            <p>Točan odgovor (više točnih odgovora odvojiti zarezom): </p>
                <input class="editAnswer" type="text" name="newCorrect_{{ $key }}" value="{{ $value['correctAnswers'] }}"><br>
            <br>
            @endforeach

            <p>Promijeni dozvolu kviza: </p>
            <input type="radio" name="radio_join" value="public">javno<br>
            <input type="radio" name="radio_join" value="private">privatno<br>
            @if($member)
            <input type="radio" name="radio_join" value="restricted">ograničeno<br>
            @endif
            <br><br>
            <input type="submit" value="Potvrdi">
            {{ Form::token() }}
        </form>
        
    </div>
    
    

</div>



@stop
@extends('layout.main')

@section('titleBody')
<div class="titleArea">
    <p>{{ $title }}<span class="dot">...</span></p>
<!--    <p>ne, ne.<span class="dot"> :)</span></p>-->
   
</div>
@stop


@section('content')

<div class="bodyContent">
    <div class="wrapper">
        <div class="sideBySide">

            <div class="left">
                <table style="color: black">
                    <tr>
                        <td class="tableAnswer">Vaš odgovor: </td>
                        <td class="tableAnswer">Točan odgovor:</td>
                        <td class="tableStatus"></td> 
                    </tr>
                   
                    @for ($i=0; $i<$numTotal; $i++)
                    <tr>
                        <td class="tableAnswer"><hr>{{{ ($received[$i]!="") ? $received[$i] : "-" }}}</td>
                        <td class="tableAnswer"><hr>{{{ $correct[$i] }}}</td>
                        <td class="tableStatus"><hr>{{{ $result[$i] }}}</td> 
                    </tr>
                    @endfor                    
                </table><hr>
            </div>
            <div class="right">
                {{ HTML::image('/stats/img.png', 'alt-text') }}

            </div>
        </div>
    </div>
</div>
@stop
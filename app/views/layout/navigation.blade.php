<ul id="navbar" class="navigationLinks">
    <li><a href="{{ URL::route('home') }}">početna</a></li>

    @if(Auth::check())
        <li><a href="{{ route('profile-user',  Auth::user()->username); }}">profil</a></li>
       
        <li><a href="{{ URL::route('account-sign-out') }}">log out</a></li>
    @else      
        <li><a href="{{ URL::route('account-create') }}">registriraj se</a></li>
        <li><a href="{{ URL::route('account-sign-in') }}">login</a></li>
    @endif
</ul>

</script>
<script>
$('.navigationLinks a').click(function(){
    $('.navigationLinks a').removeClass("active");
    $(this).addClass("active");
});
</script>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            Pozdrav ,<br><br>
            Zatražili ste promjenu korisničke lozinke. <br>
            Kako biste promijenili lozinku, slijedite link u nastavku:
            <br><br/>----<br/>
            {{ URL::to('password/reset', array($token)) }}
            <br/>---<br/><br>
            Ovaj link vrijedi {{ Config::get('auth.reminder.expire', 60) }} minuta.
            <br><br>
            OIPA generator kviza
        </div>
    </body>
</html>

<!DOCTYPE>

<html>
    <head>
        <title>OIPA</title>
            
            {{ HTML::style('css/blank.css') }}
            {{ HTML::style('css/main.css') }}
            {{ HTML::style('css/forms.css') }}
    </head>
    <body>
        <div class="container">
            <div class="header">
                <div class="navWrapper">
                    <div class="wrapper">
                        <div class="mainMenu">                
                            @include('layout.navigation') 
                        </div>                    
                    </div>                    
                </div>
                <div class="wrapper">
                    <div class="circle"> 
                        <div class="logo">
                            <div class="logoText"
                                 <p>oipa<span class="dot">.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mainContent">
                <div class="wrapper">                    
                    @yield('titleBody')
                </div>
                <div class="content">
                    
                    <div class="wrapper">
                        @if(Session::has('global'))
                        <p>{{ Session::get('global') }}</p>
                        @endif                    
                        @if(Session::has('status'))
                        <p>{{ Session::get('status') }}</p>
                        @endif
                        @if(Session::has('error'))
                        <p>{{ Session::get('error') }}</p>
                        @endif
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
            
            <div class="footer">
                <div class="wrapper">
                    @2014
                </div>
            </div>

        </div>
    </body>

</html>
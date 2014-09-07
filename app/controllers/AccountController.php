<?php

class AccountController extends BaseController {
    
    public function getSignIn(){        
        return View::make('account.signin');
    }

    public function postSignIn(){ 
         $validator=Validator::make(Input::all(),
                array(
                    'email'     => 'required|email',
                    'password'  => 'required',
                    'captcha'   => 'required|captcha'
                )
         );
         
         if($validator->fails()){
             return Redirect::route('account-sign-in')
                     ->withErrors($validator)
                     ->withInput();
         } else {
             $auth = Auth::attempt(array(
                 'email' => Input::get('email'),
                 'password' => Input::get('password')                
             )); 
             if ($auth){
                 return Redirect::route('profile-user', Auth::user()->username);
             } else {
                 return Redirect::route('account-sign-in')
                    ->with('loginMsg', 'Krivi podaci.');    
             }         
         }
         
         return Redirect::route('account-sign-in')
                 ->with('loginMsg', 'Login nije uspio. Jeste li registrirani?');
         
    }
    
    public function getSignOut(){ 
        Auth::logout(); 
        return Redirect::route('home');
    }

    public function getCreate() {
        return View::make('account.create');        
    }
    
    public function postCreate(){
        
        $validator=Validator::make(Input::all(),
                array(
                    'lastName'          => 'required',
                    'firstName'         => 'required',
                    'email'             => 'required|max:50|email|unique:sspusers',
                    'username'          => 'required|max:20|min:3|unique:sspusers',
                    'password'          => 'required|min:6',
                    'password_again'    => 'required|same:password',
                    'captcha'           => 'required|captcha'
                )
        );
        
        if($validator->fails()){
            return Redirect::route('account-create')
                    ->withErrors($validator)
                    ->withInput();
        } else {            
            $firstName  = Input::get('firstName');
            $lastName   = Input::get('lastName');
            $email      = Input::get('email');
            $username   = Input::get('username');
            $password   = Input::get('password');
            
            // Activation code
            $code = str_random(60);
            
            $user = Sspuser::create(array(
                'firstName' => $firstName,
                'lastName' => $lastName,                
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'code' => $code             
            ));
            
            if ($user){
                return Redirect::route('account-sign-in-post')
                        ->with('global', 'Registrirani ste!');
            }           
        }               
    }
    
    
    public function getChangePasswordRequest(){
        return View::make('account.sendEmail');
    }
    
    
    public function postChangePasswordRequest(){
        $validator = Validator::make(Input::all(), 
                array(
                    'email' => 'required|email'
                )
        );
        
        if ($validator->fails()) {
            return Redirect::route('account-change-password-request')
                    ->withErrors($validator);
        } else {           
            $email = Input::get('email');
            //Activation code
            $code = str_random(60);            
            
            $user = Sspuser::find(auth::user()->id);            
            $user->code = $code;
            $username=$user->username;
            var_dump($user->code);die();
            if($user->save()){
                $emailToSend=array('email' => $email);
                Mail::send('emails.auth.changePasswordRequest', array('username' => $username, 'url' => URL::route('account-change-password', $code)), function($message) use ($emailToSend){
                    $message->to($emailToSend['email'])->subject('Zahtjev za promjenom lozinke');
                });
                return Redirect::route('home')
                        ->with('global', 'Poslan Vam je e-mail.');
            } 
        } 
        return Redirect::route('home')
                ->with('global', 'Trenutno nije moguće promijeniti lozinku. Pokušajte kasnije.');
    }
    
    
    public function getChangePassword($code) {
        return View::make('account.password');
    }
    
    
    public function postChangePassword() {
        $validator = Validator::make(Input::all(), 
                array(
                    'old_password'   => 'required',
                    'password'       => 'required|min:6|different:old_password',
                    'password_again' => 'required|same:password'
                )
        );        
        if($validator->fails()){
            return Redirect::route('account-change-password')
                    ->withErrors($validator);
        } else{
            $user = Sspuser::find(auth::user()->id);          
            $old_password = Input::get('old_password');
            $password = Input::get('password');
            
            if(Hash::check($old_password, $user->getAuthPassword())){                
                $user->password = Hash::make($password);
                $user->code = '';                
                if($user->save()){
                    return Redirect::route('home')
                            ->with('global', 'Vaša lozinka je promijenjena!');
                }
            } else {
                return Redirect::route('account-change-password')
                ->with('global', 'Stara lozinka nije ispravna.');        
            }            
        }        
        return Redirect::route('account-change-password')
                ->with('global', 'Vaša lozinka ne može biti promijenjena!');        
    }
}
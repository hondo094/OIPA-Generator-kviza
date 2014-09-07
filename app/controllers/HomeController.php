<?php

class HomeController extends BaseController {    
    
    public function home() {
        $restrictedQuizzes = array();
        $membership = 0;
        if (Auth::check()) {
            $user = Sspuser::where('username', '=', Auth::user()->username)->first();
            $membership = $user->member;
        }
        $publicQuizzes = Sspquizz::where('level', '=', 'public')->lists('quizzTitle', 'quizzName');
        $restrictedQuizzes = Sspquizz::where('level', '=', 'restricted')->lists('quizzTitle', 'quizzName');
   
        return View::make('home')
                        ->with('publicQuizzes', $publicQuizzes)
                        ->with('restrictedQuizzes', $restrictedQuizzes)
                        ->with('membership', $membership);
    }

}

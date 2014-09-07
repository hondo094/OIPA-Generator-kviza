<?php

class ProfileController extends BaseController {

    public function user($username) {
        $user = Sspuser::where('username', '=', $username);
        if ($user->count()) {
            $user = $user->first();
            $membership=$user->member;
            
            //samo koji nisu obrisani
            $userQuizzes = Sspquizz::where('creator', '=', $username)->lists('quizzTitle', 'quizzName');
            
            return View::make('profile.user')
                            ->with('user', $user)
                            ->with('userQuizzes', $userQuizzes)
                            ->with('membership', $membership);
        }
        return App::abort(404);      
    }

    public function postUpload() {
        $message="Potrebno je odabrati datoteku za upload.";
        $file = Input::file('file');
        if (Input::hasFile('file')) {           
            if (Input::file('file')->isReadable()) {
                if ("text/plain" === Input::file('file')->getMimeType()) {
                    $destination_path = public_path() . '/../app/uploads/quizzes';
                    $filename = str_random(12);
                    $radio = Input::get('radio');
                    if (!in_array($radio, ["private", "public", "restricted"])){
                        $radio="private";
                    }                    
                    try {            
                        $file = Input::file('file')->move($destination_path, $filename);                        
                        $content = File::get($destination_path ."/". $filename);                        
                        $parsedContent=QuizzHelper::parseFile($content);                        
                        $quizz = Sspquizz::create(array(
                                'quizzName' => $filename,
                                'creator' => Auth::user()->username,
                                'quizzTitle' => $parsedContent['title'],
                                'level' => $radio
                        ));                        
                        if ($quizz) {
                            $message = "Datoteka je uspješno uploadana.";                          
                            foreach ($parsedContent['data'] as $key => $data) {                              
                                $quizzContent = Sspquestions::create(array(
                                            "sspquizz_id" => $quizz->id,
                                            "question_number" => $key,
                                            "type" => $data['type'],
                                            "question" => $data['question'],
                                            "answers" => $data['answers'],
                                            "correct" => $data['correctAnswers']
                                ));                                
                                if (!$quizzContent) {
                                    $message = "Došlo je do greške, pokušajte ponovno.";
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $message = 'Upload datoteke nije uspio. Pokušajte kasnije.';
                    }                    
                } else {
                    $message = 'Odaberite .txt datoteku.';
                }
            } else {
                $message = 'Upload datoteke nije uspio. Pokušajte ponovno.';
            }
        } 
        return Redirect::route('profile-user', Auth::user()->username)
                        ->with('message', $message);
    }
    
    
    public function postJoin() {
        $newStatus = Input::get('radio_join');
        if (in_array(intval($newStatus), [0, 1])) {
            $user = Sspuser::where('username', '=', Auth::user()->username)->first();
            $oldStatus = $user->member;
            if ($newStatus != $oldStatus) {
                $user->member = $newStatus;
                $user->save();
                if ($oldStatus===0){
                    $joinMessage = "Pridružili ste se grupi.";                    
                } else {
                     Sspquizz::where('creator', '=', $user->username)
                        ->where('level', '=', 'restricted')
                        ->update(array(
                            'level' => 'private'
                        ));
                     $joinMessage = "Napustili ste grupu.";
                }
            } else {
                $oldStatus === 0 ? $joinMessage = "Niste ni bili član grupe." : $joinMessage = "Već jeste član grupe.";
            }
        } else {
            $joinMessage = "Došlo je do greške.";
        }
        return Redirect::route('profile-user', Auth::user()->username)
                ->with('joinMessage', $joinMessage);
    }
    
}

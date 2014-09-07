<?php

class QuizzController extends BaseController {

    public function display($quizzName) {
        $permission = false;
        $quizz = Sspquizz::where('quizzName', '=', $quizzName)->first();
        $questions = $quizz->questions()->orderBy('question_number')->get();
        $title = $quizz->quizzTitle;
        $level = $quizz->level;       
        $quizzQuestions = [];
        foreach ($questions as $question) {
            $num = $question->question_number;
            $quizzQuestions[$num]['type'] = $question->type;
            $quizzQuestions[$num]['question'] = $question->question;
            $quizzQuestions[$num]['answers'] = explode(",", $question->answers);
        }
        if ($level == 'public') {
            $permission = true;
        } else {
            $username = Auth::user()->username;
            $creator = $quizz->creator;
            $user = Sspuser::where('username', '=', $username)->first();
            $membership = $user->member;
            if ($level === 'private') {
                if ($username === $creator) {
                    $permission = true;
                }
            } else if ($level == 'restricted') {
                if ($membership === 1) {
                    $permission = true;
                }
            }
        }
        if ($permission) {
            return View::make('quizzes.quizz')
                            ->with('questions', $quizzQuestions)
                            ->with('title', $title)
                            ->with('quizzName', $quizzName);
        } else {
            App::abort(403, 'Unauthorized action.');
        }
    }

    public function evaluate($quizzName) {
        $input = array();
        $result = array();
        $quizz = Sspquizz::where('quizzName', '=', $quizzName)->first();
        $questions = $quizz->questions()->orderBy('question_number')->get();
        foreach ($questions as $key => $value) {
            $input[$key] = "";
            $correct[$key] = $value['correct'];
            $questions[$key] = $value['question'];
            if (Input::get('checkbox_' . $key) != null) {
                $input[$key] = implode(",", Input::get('checkbox_' . $key));
            } else if (Input::get('radio_' . $key) != null) {
                $input[$key] = Input::get('radio_' . $key);
            } else if (htmlentities(Input::get('textbox_' . $key)) != "") {
                $input[$key] = htmlentities(Input::get('textbox_' . $key));
            }
            $result[$key] = QuizzHelper::is_correct($correct[$key], $input[$key]);
        }
        $numCorrect = 0;
        $numTotal = 0;
        foreach ($result as $item) {
            if ($item === 'točno!') {
                $numCorrect++;
            }
            $numTotal++;
        }
        $numWrong = $numTotal - $numCorrect;
        QuizzHelper::generate_stats($numTotal, $numCorrect, $numWrong);
        return View::make('quizzes.results')
                        ->with('title', "Rezultati")
                        ->with('correct', $correct)
                        ->with('received', $input)
                        ->with('result', $result)
                        ->with('numTotal', $numTotal);
    }

    public function deleteQuizz($quizzName) {
        $quizzId = Sspquizz::where('quizzName', '=', $quizzName)->first()->id;
        try {
            Sspquizz::where('id', $quizzId)->delete();
            Sspquestions::where('sspquizz_id', $quizzId)->delete();
            $message = "Kviz je obrisan.";
        } catch (Exception $exc) {
            $message = "Došlo je do greške, pokušajte ponovno.";
        }
        return Redirect::route('profile-user', Auth::user()->username)
                        ->with('editMessage', $message);
    }

    public function editQuizz($quizzName) {
        $quizz = Sspquizz::where('quizzName', '=', $quizzName)->first();
        $creator = $quizz->creator;
        if (Auth::check()) {
            (Auth::user()->username === $creator) ? $permission = true : $permission = false;
        }
        if ($permission) {
            $questions = $quizz->questions()->orderBy('question_number')->get();
            $quizzQuestions = [];
            foreach ($questions as $question) {
                $num = $question->question_number;
                $quizzQuestions[$num]['type'] = $question->type;
                $quizzQuestions[$num]['question'] = $question->question;
                $quizzQuestions[$num]['answers'] = explode(",", $question->answers);
                $quizzQuestions[$num]['correctAnswers'] = $question->correct;
            }
            $membership = Sspuser::where('username', '=', $creator)->first()->member;
            return View::make('quizzes.edit')
                            ->with('title', 'Uredi kviz')
                            ->with('data', $quizzQuestions)
                            ->with('title', $quizz->quizzTitle)
                            ->with('quizzName', $quizzName)
                            ->with('member', $membership);
        } else {
            App::abort(403, 'Unauthorized action.');
        }
    }

    public function postEditQuizz($quizzName) {
        $input = Input::all();
        $quizz = Sspquizz::where('quizzName', '=', $quizzName)->first();
        $quizzId = $quizz->id;
        $questions = $quizz->questions()->orderBy('question_number')->get();
        try {            
            if ($input['new_title'] !== $quizz->quizzTitle) {
                $quizz->update(array(
                    'quizzTitle' => $input['new_title']
                ));
            }
            foreach ($questions as $key => $value) {
                $num = $value->question_number;     
                $question=Sspquestions::where("sspquizz_id", "=", $quizzId)
                            ->where('question_number', '=', $num);
                if (array_key_exists('deleteQuestion_' . $num, $input)) {                   
                    $question->delete();
                    $message = "Uspješno ste preuredili kviz.";
                } else {
                    if (array_key_exists('newQuestion_' . $num, $input)) {
                        if ($input['newQuestion_' . $num] !== $value->question) {
                            $question->update(array(
                                        'question' => $input['newQuestion_' . $num]
                            ));
                        }
                    }
                    if (array_key_exists('newAnswer_' . $num, $input)) {
                        $newAnswer = implode(",", $input['newAnswer_' . $num]);
                        if ($newAnswer !== $value->answers) {
                            $question->update(array(
                                        'answers' => $newAnswer
                            ));
                        }
                    }
                    if (array_key_exists('newCorrect_' . $num, $input)) {
                        if ($input['newCorrect_' . $num] !== $value->correct) {
                           $question->update(array(
                                        'correct' => $input['newCorrect_' . $num]
                            ));
                        }
                    }
                }
            }
            if (array_key_exists('radio_join', $input)) {
                $newLevel = $input['radio_join'];
                if (in_array($newLevel, ["private", "public", "restricted"])) {
                    if ($quizz->level !== $newLevel) {
                        $quizz->update([
                            'level' => $newLevel
                        ]);
                    }
                }
            }
            $message = "Promjene su spremljene.";
        } catch (Exception $exc) {
            $message = "Došlo je do greške, pokušajte ponovno.";
        }

        return Redirect::route('profile-user', Auth::user()->username)
                        ->with('editMessage', $message);
    }

}

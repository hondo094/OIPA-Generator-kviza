<?php

define('SINGLE', 1);
define('MULTIPLE', 2);
define('CUSTOM', 3);

class QuizzHelper {

    public static function parseFile($content) {
        $title="noname";
        $parsedContent=[];
        $lines = explode("\n", $content);
        $pattern = '/(.+){([123])}:(.*);(.+)/';
        foreach ($lines as $line) {            
            $line = trim($line);
            if (starts_with($line, "!")) {
                $title = trim(ltrim($line, '!'));
            } else if (!(starts_with($line, "#") || $line == "")) {
                if (preg_match($pattern, $line, $matches)) {
                    $type = $matches[2];
                    $question = $matches[1];
                    $answers = $matches[3];
                    $correct = $matches[4];
                    
                    if ($type === "1") {
                        $type = "SINGLE";
                    } else if ($type === "2") {
                        $type = "MULTIPLE";
                    } else if ($type === "3") {
                        $type = "CUSTOM";
                    }
                    $parsedContent[] = array(
                        "type" => $type,
                        "question" => $question,
                        "answers" => $answers,
                        "correctAnswers" => $correct
                    );
                }
            }
        }        
        $data = array(
            "title" => $title,
            "data" => $parsedContent
        );
        return $data;
    }
    
    
    public static function is_correct($expected, $received) {
        $corr = mb_strtolower(trim($expected));
        $usr = mb_strtolower(trim($received));
        return ($corr === $usr) ? 'točno!' : 'netočno';
    }
    
    
    public static function generate_stats($total, $correct, $wrong) {
        
        $data = array($correct, $wrong);
        $x_fld = array('tocno', 'krivo');
        $max = 0;
        for ($i = 0; $i < 2; $i++) {
            if ($data[$i] > $max) {
                $max = $data[$i];
            }
        }
        $im = imagecreate(320, 255);
        
        $color = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im, 0, 0, $color);
       
        $black = imagecolorallocate($im, 0, 0, 0);
        $gray_dark = imagecolorallocate($im, 0x7f, 0x7f, 0x7f);

        //just in case
        //$white = imagecolorallocate($im, 255, 255, 255);        
        //$gray = imagecolorallocate($im, 0xcc, 0xcc, 0xcc);
        //$gray_lite = imagecolorallocate($im, 0xee, 0xee, 0xee);        
        //$green = imagecolorallocate($im, 0, 153, 0);

        imageline($im, 10, 5, 10, 230, $black);
        imageline($im, 10, 230, 300, 230, $black);

        $x = 75;
        $y = 230;
        $x_width = 65;
        $y_ht = 0;

        if ($total === 0) {
            for ($i = 0; $i < 2; $i++) {
                imagefilledrectangle($im, $x, $y, $x + $x_width, $y, $gray_dark);
                imagestring($im, 2, $x + 5, $y + 1, $x_fld[$i] . " (" . $data[$i] . ")", $black);
                $x += ($x_width + 20);
            }
        } else {
            for ($i = 0; $i < 2; $i++) {
                $y_ht = ($data[$i] / $max) * 100;
                imagefilledrectangle($im, $x, $y, $x + $x_width, ($y - $y_ht), $gray_dark);
                imagestring($im, 2, $x + 5, $y + 1, $x_fld[$i] . " (" . $data[$i] . ")", $black);
                $x += ($x_width + 20);
            }
        }
        
        imagepng($im, app_path()."/../public/stats/img.png");
        imagedestroy($im);
    }
}

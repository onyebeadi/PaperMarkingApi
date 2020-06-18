<?php
namespace App\Http\Controllers;

class AnswerPaper{
    private $answer_paper = "";
    public  $answer_subject = "";
    private $marking_guide_obj;
    public  $string_answers;
    private $answers = array();

    public function __construct(MarkingGuide $obj){
        $this->marking_guide_obj = $obj;

    }

    /*
     * accepts the input and sets answer paper and subject
     * @param $input
     */
    public function set_answer_paper($input){
        if(!empty($input)){
            list($subject,$ques_answers) = explode(':', $input);
            $this->answer_paper = $input;
            $subject = str_replace(array('[',']'),'',$subject);
            $this->answer_subject = $subject;
            $answers= preg_replace('/[0-9]+/','',$ques_answers);
            $answers = str_replace(',','',$answers);
            $this->string_answers = $answers;
            $this->answers = explode(';',$answers);
            unset($this->answers[(count($this->answers)-1)]);
        }else{
            return false;
        }

        return true;
    }

    /*
     * marks answer paper using the marking guide
     */

    public function mark_paper(){
        $marking_guide_answers = explode(';', $this->marking_guide_obj->answers);
        unset($marking_guide_answers[count($marking_guide_answers)-1]);
        $score = 0;

        for ($i = 0 ; $i < count($this->answers); $i++){
            if($this->answers[$i] == $marking_guide_answers[$i] ){
                $score++;
            }
        }
        $output = array($score , count($marking_guide_answers) );
        return $output;


    }
}
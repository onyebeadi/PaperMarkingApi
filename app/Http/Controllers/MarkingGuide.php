<?php
namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: onyebeadi.chimdindu
 * Date: 28/04/2020
 * Time: 23:48
 */

class MarkingGuide {
    public $marking_guide;
    public $subjects;
    public $subjects_answers;
    public $answers = "";

    function __construct (){
        $this->subjects = array();
        $this->subjects_answers = array();
        $this->marking_guide = array();

    }

    /*
     * saves marking guide and overrides saved marking guide if it exists
     * @param input
     */
    public function save_marking_guide($input){

        if (!empty($input)){
            list($subject,$ques_answers) = explode(':', $input);
            $subject = str_replace(array('[',']'),'',$subject);
            $answers= preg_replace('/[0-9]+/','',$ques_answers);
            $answers = str_replace(',','',$answers);
            $this->answers = $answers;
            $marking_guide_answers = explode(';',$answers);
            unset($marking_guide_answers[count($marking_guide_answers)-1]);
            $key = array_search($subject , $this->subjects);

            if(array_key_exists($subject , $this->subjects_answers)){
                $this->update_marking_guide($input,$key,$marking_guide_answers, $subject);
            }else{
                array_push($this->marking_guide, $input);
                array_push($this->subjects, $subject);
                $this->subjects_answers[$subject]= $marking_guide_answers;
            }
        }else{
            return false;
        }
        return true;
    }

    /*
     * deletes marking guide
     * @param $index
     */
    public function delete_marking_guide($index){
        $index--;

        if(array_key_exists($index,$this->marking_guide)){
            $subject = $this->subjects[$index];
            unset($this->marking_guide[$index]);
            unset($this->subjects[$index]);
            unset($this->subjects_answers[$subject]);
            $this->marking_guide = array_values($this->marking_guide);
            $this->subjects = array_values($this->subjects);
            $this->subjects_answers = array_values($this->subjects_answers);
            return true;
        }else{
            return false;
        }

    }

    /*
     * lists all available marking guides
     *
     */
    public function list_marking_guide(){

        if (isset($this->marking_guide) && !empty($this->marking_guide)){
            echo"\e[1;31;40m********************************************\e[1;32;40m\n";
            foreach($this->marking_guide as $key => $values){
                echo"(".(++$key).")  ".$values."\n";
            }
            echo"\e[1;31;40m********************************************\e[1;32;40m \n";

        }else{
            echo"No available marking guide\n";
        }


    }
    /*
     * updates marking guide if marking guide exists
     * @param input
     * @param key
     * @param subject
     */
    public function update_marking_guide($input,$key,$answers, $subject){
        $this->marking_guide[$key] = $input;
        $this->subjects[$key] = $subject;
        $this->subjects_answers[$subject] = $answers;
    }
    /*
     * validates marking guide input to ensure it conforms to the outlined format
     * then returns true or false
     */
    public function validate_input($input){
       if(preg_match("/^\[[\w]+\]:([\d],[A-Z];)+$/", $input)){
           return true;
       }else{
           return false;
       }
    }


}






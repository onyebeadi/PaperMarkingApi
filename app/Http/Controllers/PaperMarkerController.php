<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\MarkingGuide as MarkingGuideModel;
use App\AnswerPaper as AnswerPaperModel;
use App\Traits\ApiResponser;


class PaperMarkerController extends Controller
{
    private $marking_guide_obj;
    private $answer_paper_obj;
    use ApiResponser;

    public function __construct()
    {
        $this->marking_guide_obj = new MarkingGuide();
        $this->answer_paper_obj = new AnswerPaper($this->marking_guide_obj);
    }

    /*
     * Returns a list of all marking guides
     */
    public function list_marking_guides(){
        $marking_guide = MarkingGuideModel::all();
        return $this->successResponse($marking_guide);

    }

    /*
     * Returns a list of all answer papers
     */
    public function list_answer_papers(){
        $answer_paper = AnswerPaperModel::all();
        return $this->successResponse($answer_paper);

    }

    /*
     * stores marking guide
     */
    public function store_marking_guide($guide){
        $status = $this->marking_guide_obj->validate_input($guide);
        if($status){
            $this->marking_guide_obj->save_marking_guide($guide);
            $guideObj = MarkingGuideModel::create(array(
                'subject_name'=> strtolower($this->marking_guide_obj->subjects[0]),
                'answers'=> $this->marking_guide_obj->answers
            ));
            $guideObj->save();
            return $this->successResponse($guideObj);

        }else{
            return "Invalid marking guide format";
        }

    }

    /*
     * stores and marks answer paper
     */
    public function store_answer_paper($name,$answer_paper){
        $status = $this->marking_guide_obj->validate_input($answer_paper);
        if($status){
            $this->answer_paper_obj->set_answer_paper($answer_paper);
            $markingGuide = MarkingGuideModel::where('subject_name',strtolower($this->answer_paper_obj->answer_subject))->first();
            if(isset($markingGuide)){
                $this->marking_guide_obj->answers = $markingGuide['answers'];
                $result = $this->answer_paper_obj->mark_paper();
                $answerPaper = AnswerPaperModel::create([
                    'marking_guide_id'=>$markingGuide['id'],
                    'student_name'=>$name,
                    'subject_name'=>$markingGuide['subject_name'],
                    'answers'=> $this->answer_paper_obj->string_answers,
                    'score'=> ($result[0]/$result[1]*100)
                ]);
                $answerPaper->save();
                return $this->successResponse($answerPaper);
            }else{
                return $this->errorResponse('No marking guide available for answer paper',HTTP_E_RESPONSE);
            }

        }else{
            return "Invalid answer paper format";
        }

    }


    /*
     * Remove an existing marking guide
     * @return Illuminate\Http\Response
     */
    public function destroy_marking_guide($id){
        $marking_guide = MarkingGuideModel::findOrFail($id);

        $marking_guide->delete();

        return $this->successResponse($marking_guide);
    }

    /*
     * Remove an existing answer paper
     * @return Illuminate\Http\Response
     */
    public function destroy_answer_paper($id){
        $answer_paper = AnswerPaperModel::findOrFail($id);

        $answer_paper->delete();

        return $this->successResponse($answer_paper);
    }








}

<?php

namespace App\Http\Controllers\CorpHRM;
use App\Models\CorpHRM\Training\TrainingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\CorpHRM\Training\TrainingMaster;
use App\Models\CorpHRM\Training\TrainingFacilitator;
use App\Models\CorpHRM\Department;
use App\Models\CorpHRM\Branch;
use App\Models\CorpHRM\Grade;
use App\Models\CorpHRM\Designation;
use App\Models\CorpHRM\EmployeeProfile;

use App\Traits\SubscriptionTrait;

class TrainingController extends Controller
{
    use SubscriptionTrait;   /**
     * Get the training master page
                              *
     * @return type
     */
    public function getTrainingMaster()
    {
        if (Auth::check()) {
            return view('CorpHRM.Training.trainingMaster');
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    
    public function list_training_master(){
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $trainingmasters = TrainingMaster::where('company_id',$company_id)->get();
            return view('CorpHRM.Training.listtrainingMaster',['trainingmasters' => $trainingmasters]);
        }
        else
        {
            return Redirect::intended('login');
        }       
    }

    /**
     * Handle trainingMaster form
     *
     * @param  Request $request
     * @return type
     */
    public function postTrainingMaster(Request $request)
    {
        //todo: Validate
        if (Auth::check()) {
            $trainingMaster = new TrainingMaster();
            $trainingMaster->training_name = $request->training_name;
            $trainingMaster->description = $request->desc_of_training;
            $trainingMaster->company_id = Auth::user()->company_id;
            $trainingMaster->save();
            $success = true;
            return view('CorpHRM.Training.trainingMaster', compact('success'));
        }
        else
        {
            return Redirect::intended('login');
        }
    }
    
    /**
     * Get the training facilitator
     */
    public function getTrainingFacilitator()
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $details = TrainingMaster::where('company_id',$company_id)->get();
            return view('CorpHRM.Training.trainingFacilitator', compact('details'));
        }
        else
        {
                return Redirect::intended('login');
        }
    }

    public function listTrainingFacilitator()
    {
        if (Auth::check()) {
            $company_id = Auth::user()->company_id;
            $TrainingFacilitator = TrainingFacilitator::where('company_id',$company_id)->get();
            return view('CorpHRM.Training.listtrainingFacilitator', ['TrainingFacilitators' => $TrainingFacilitator]);
        }
        else
        {
                return Redirect::intended('login');
        }
    }
    
    public function postTrainingFacilitator(Request $request)
    {
        if (Auth::check()){
        $trainingFacilitator = new TrainingFacilitator();
        $trainingFacilitator->training_name = $request->training_name;
        $trainingFacilitator->facilitator_name = $request->facilitator_name;
        $trainingFacilitator->contact_person_name = $request->contact_person_name;
        $trainingFacilitator->mobile_no = $request->mobile_no;
        $trainingFacilitator->address = $request->address;
        $trainingFacilitator->facilitator_email = $request->email;
          $trainingFacilitator->company_id = Auth::user()->company_id;
            $trainingFacilitator->save();
        $success = true;
//        return view('CorpHRM.Training.trainingFacilitator',compact('success'));
            return redirect()->back()->with(compact('success'));
        }
        else
        {
                return Redirect::intended('login');
        }
    }
    
    /**
     * Get the training plan
     */
    public function getTrainingPlan()
    {
        if (Auth::check()){
            $train_masters = TrainingMaster::all();
            $facilitators = TrainingFacilitator::all();
            $departments = Department::all();
            $branches = Branch::all();
            $designations = Designation::all();
            $grades = Grade::all();
            return view('CorpHRM.Training.trainingPlan',[
                'grades' => $grades,
                'branches' => $branches,
                'departments' => $departments,
                'designations' => $designations,
                'train_masters' => $train_masters,
                'facilitators' => $facilitators
            ]);
        }
        else
        {

                return Redirect::intended('login');
        }
    }

    public function listTrainingPlan()
    {
        if (Auth::check()){

            $company_id = Auth::user()->company_id;
            $TrainingPlan = TrainingPlan::where('company_id',$company_id)->get();
            // foreach($TrainingPlans as  $TrainingPlan){

            //     $grade = Grade::where([''])->first();
            // }
            return view('CorpHRM.Training.listtrainingPlan',['TrainingPlans' => $TrainingPlan]);
        }
        else
        {

                return Redirect::intended('login');
        }
    }

      public function postTrainingPlan(Request $request){
          $this->validate($request,[
              'training_title' => 'required',
              'grade' => 'required',
              'department' => 'required',
              'facilitator' => 'required',
              'branch' => 'required',
              'select_designation' => 'required',
              'venue_time' => 'required',
              'training_budget' => 'required',
              'training_objective' => 'required',
              'training_type' => 'required',
              'mode_of_delivery' => 'required',
          ]);

          $trainingplan  = new TrainingPlan();
          $trainingplan->title = $request['training_title'];
          $trainingplan->grade = $request['grade'];
          $trainingplan->department = $request['department'];
          $trainingplan->facilitator = $request['facilitator'];
          $trainingplan->branch = $request['branch'];
          $trainingplan->designation = $request['select_designation'];
          $trainingplan->venue_time = $request['venue_time'];
          $trainingplan->training_budget = $request['training_budget'];
          $trainingplan->objectives = $request['training_objective'];
          $trainingplan->training_type = $request['training_type'];
          $trainingplan->mode_of_delivery = $request['mode_of_delivery'];
          $trainingplan->company_id = Auth::user()->company_id;
          $trainingplan->save();
        //   return redirect()->back()->with(compact('success'));
        $eligible_employees = $this->listeligibleemployees($request['grade'], $request['department'], $request['branch'], $request['select_designation']);
        return view('CorpHRM.Training.selecteligibleemployees',['eligible_employees' => $eligible_employees]);
      }

    public function listeligibleemployees($grade,$department,$branch,$designation){

        $eligible_employees =  EmployeeProfile::where(['grade' => $grade, 'department' => $department,'branch' => $branch,'designation' => $designation])->get();
        return $eligible_employees;
    }
}

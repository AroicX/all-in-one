<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->call(function () {
        //     DB::table('recent_users')->delete();
        // })->daily();
        $schedule->call(function () {
            $this->three_days_interview_reminder_email();
            $this->seven_days_interview_reminder_email();
            $this->one_days_interview_reminder_email();
        })->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        include base_path('routes/console.php');
    }


    public function  three_days_interview_reminder_email(){

        $company_id = Auth::user()->company_id; 
        $company_details = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($company_details as $company_detail){
            $company_name = $company_detail->name;
            $company_email = $company->email;
        }
        //$date = date('Y-m-d');
        $new_date = date('Y-m-d', strtotime('-3 day', strtotime(date('Y-m-d'))));;
        $interview_processes = DB::select(DB::raw("SELECT * FROM interview_processes where from_date = '$new_date' "));
        foreach ($interview_processes as $interview_process){
         $interviewers = explode(',', $interview_process->interviewers);
         foreach ($interviewers as $interviewer){
            $employees = DB::select(DB::raw("SELECT * FROM employees where employee_id = '$interviewer' "));
            $employees_profile = DB::select(DB::raw("SELECT * FROM employee_profiles where id = '$interviewer' "));
            foreach ($employees as $employee){
            foreach ($employees_profile as $employee_profile){
        $data = [

            'company_name'=>$company_name,
            'company_email'=>$company_email,
            'name'=> $employee->firstname,
            'date' => $interview_process->from_date,
            'recepient' => $employee_profile->official_email_address

        ];
        Mail::queue(

            'Mail.reminder', $data, function ($message) use ($recepient, $interviewer_name) {
                $message->to($recepient, $interviewer_name)->subject('Interview Reminder');
                $message->from('noreply@corperm.com', $company_name);
            }
        );

        }
        }
    }
    }
    }

    public function  seven_days_interview_reminder_email(){

        $company_id = Auth::user()->company_id; 
        $company_details = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($company_details as $company_detail){
            $company_name = $company_detail->name;
            $company_email = $company->email;
        }
        //$date = date('Y-m-d');
        $new_date = date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))));;
        $interview_processes = DB::select(DB::raw("SELECT * FROM interview_processes where from_date = '$new_date' "));
        foreach ($interview_processes as $interview_process){
         $interviewers = explode(',', $interview_process->interviewers);
         foreach ($interviewers as $interviewer){
            $employees = DB::select(DB::raw("SELECT * FROM employees where employee_id = '$interviewer' "));
            $employees_profile = DB::select(DB::raw("SELECT * FROM employee_profiles where id = '$interviewer' "));
            foreach ($employees as $employee){
            foreach ($employees_profile as $employee_profile){
        $data = [

            'company_name'=>$company_name,
            'company_email'=>$company_email,
            'name'=> $employee->firstname,
            'date' => $interview_process->from_date,
            'recepient' => $employee_profile->official_email_address

        ];
        Mail::queue(

            'Mail.reminder', $data, function ($message) use ($recepient, $interviewer_name) {
                $message->to($recepient, $interviewer_name)->subject('Interview Reminder');
                $message->from('noreply@corperm.com', $company_name);
            }
        );

        }
        }
    }
    }
    }

        public function  one_days_interview_reminder_email(){

        $company_id = Auth::user()->company_id; 
        $company_details = DB::select(DB::raw("SELECT * FROM company where id = '$company_id' "));
        foreach ($company_details as $company_detail){
            $company_name = $company_detail->name;
            $company_email = $company->email;
        }
        $new_date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));;
        $interview_processes = DB::select(DB::raw("SELECT * FROM interview_processes where from_date = '$new_date' "));
        foreach ($interview_processes as $interview_process){
         $interviewers = explode(',', $interview_process->interviewers);
         foreach ($interviewers as $interviewer){
            $employees = DB::select(DB::raw("SELECT * FROM employees where employee_id = '$interviewer' "));
            $employees_profile = DB::select(DB::raw("SELECT * FROM employee_profiles where id = '$interviewer' "));
            foreach ($employees as $employee){
            foreach ($employees_profile as $employee_profile){
        $data = [

            'company_name'=>$company_name,
            'company_email'=>$company_email,
            'name'=> $employee->firstname,
            'date' => $interview_process->from_date,
            'recepient' => $employee_profile->official_email_address

        ];
        Mail::queue(

            'Mail.reminder', $data, function ($message) use ($recepient, $interviewer_name) {
                $message->to($recepient, $interviewer_name)->subject('Interview Reminder');
                $message->from('noreply@corperm.com', $company_name);
            }
        );

        }
        }
    }
    }
    }
}

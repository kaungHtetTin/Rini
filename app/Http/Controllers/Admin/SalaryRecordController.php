<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryRecord;
use App\Models\Financial;
use App\Models\Employee;

class SalaryRecordController extends Controller
{
    public function add(Request $req){
        $employee_id = $req->employee_id;
        $employee = Employee::find($employee_id);

        $validated = false;
        if(isset($req->salary)){
            $req->validate([
                'salary' =>'numeric',
            ]);
            $title = "Salary to ".$employee->name;
            $financial = new Financial();
            $financial->financial_type_id = 2;
            $financial->financial_category_id = 1;
            $financial->title = $title;
            $financial->amount = $req->salary;
            $financial->save();

            $salary_record = new SalaryRecord();
            $salary_record->employee_id = $employee->id;
            $salary_record->financial_id = $financial->id;
            $salary_record->save();
            $validated = true;
        }
     

        if(isset($req->bonus)){
            $req->validate([
                'bonus'=>'numeric'
            ]);
            $title = "Bonus to ".$employee->name;
            $financial = new Financial();
            $financial->financial_type_id = 2;
            $financial->financial_category_id = 2;
            $financial->title = $title;
            $financial->amount = $req->bonus;
            $financial->save();

            $salary_record = new SalaryRecord();
            $salary_record->employee_id = $employee->id;
            $salary_record->financial_id = $financial->id;
            $salary_record->save();
            $validated = true;
        }

        if(!$validated){
            $req->validate([
                'salary' =>' required',
                'bonus'=>'required'
            ]);
        }

        return back()->with('msg','New payment was successfully added');
    }

    public function destroy($id){
        $record = SalaryRecord::find($id);
        $financial = Financial::find($record->financial_id);
        $financial->delete();

        return back()->with('msgRecordDelete','The record was successfully deleted');
    }
}

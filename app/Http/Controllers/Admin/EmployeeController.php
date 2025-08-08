<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\SalaryRecord;

class EmployeeController extends Controller
{
    public function index(){
        $employees = Employee::orderBy('disable','asc')->paginate(100);
        return view('admin.employees',[
            'page_title'=>'Employee',
            'employees'=>$employees,
        ]);
    }

    public function add(){
        $departments = Department::all();

        return view('admin.employees-add',[
            'page_title'=>'Employee Setting',
            'departments'=>$departments,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'image'=>'required',
            'name'=>'required',
            'phone'=>'required',
            'nrc_id'=>'required',
            'salary'=>'required|numeric',
            'address'=>'required',
            'department_id'=>'required',
        ]);
 
        if(isset($req->email)) $email = $req->email;
        else $email = "";
      
        if($req->hasFile('image')){
            $image = $req->file('image');
            $path = $image->store('images/employees', 'public');
             
            $employee = new Employee();
            $employee->department_id = $req->department_id;
            $employee->name = $req->name;
            $employee->phone = $req->phone;
            $employee->email = $email;
            $employee->nrc_id = $req->nrc_id;
            $employee->salary = $req->salary;
            $employee->address = $req->address;
            $employee->disable = 0;
            $employee->image_url = $path;
            $employee->save();

            return back()->with('msg', 'New employee was successfully added');
        }
      

        return back()->with('error', 'Job Fail! An expected error.');
        
    }

    public function show($id){
        $employee = Employee::find($id);
        if(!$employee) return redirect()->route('admin.404');
        $salary_records = SalaryRecord::where('employee_id',$id)->paginate(100);
        return view('admin.employees-show',[
            'page_title'=>'Employee',
            'employee'=>$employee,
            'salary_records'=>$salary_records,
        ]);
    }

    public function edit($id){
        $employee = Employee::find($id);
        $departments = Department::all();
        if(!$employee) return redirect()->route('admin.404');
        return view('admin.employees-edit',[
            'page_title'=>'Employee',
            'employee'=>$employee,
            'departments'=>$departments,
        ]);
    }

    public function modify(Request $req, $id){
        $employee = Employee::find($id);
        if(!$employee) return redirect()->route('admin.404');

        $req->validate([
            'name'=>'required',
            'phone'=>'required',
            'nrc_id'=>'required',
            'salary'=>'required|numeric',
            'address'=>'required',
            'department_id'=>'required',
        ]);

        $image_url = $employee->image_url;
        if($req->hasFile('image')){
            Storage::disk('public')->delete($image_url); // Delete old image
            $image = $req->file('image');
            $image_url = $image->store('images', 'public');
        }

        if(isset($req->email)) $email = $req->email;
        else $email = "";

        $employee->department_id = $req->department_id;
        $employee->name = $req->name;
        $employee->phone = $req->phone;
        $employee->email = $email;
        $employee->nrc_id = $req->nrc_id;
        $employee->salary = $req->salary;
        $employee->address = $req->address;
        $employee->disable = 0;
        $employee->image_url = $image_url;
        $employee->save();

        return back()->with('msg','The employee was successfully updated');

    }

    public function manageStatus(Request $req, $id){
        $req->validate([
            'status'=>'required|numeric',
        ]);

        $employee = Employee::find($id);
        if(!$employee) return redirect()->route('admin.404');
        $employee->disable = $req->status;
        $employee->save();

        if($req->status == 1) return back()->with('msg','The employee was successfully diabled');
        else return back()->with('msg','The employee was successfully activated');

    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::all();
        return view('admin.departments',[
            'page_title'=>'Employee Setting',
            'departments'=>$departments,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'department'=>'required',
        ]);

        $department = new Department;
        $department->department = $req->department;
        $department->save();

        return back()->with('msg','New department was successfully added');
    }

    public function modify(Request $req, $id){
        $req->validate([
            'department'=>'required',
        ]);

        $department = Department::find($id);
        $department->department = $req->department;
        $department->save();

        return back()->with('msg','Thes department was successfully updated');
    }
}

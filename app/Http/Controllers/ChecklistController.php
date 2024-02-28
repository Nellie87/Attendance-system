<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('checklist', compact('employees'));
    }
    // In your AttendanceController.php

public function store(Request $request)
{
    // Handle storing attendance data here
}

}


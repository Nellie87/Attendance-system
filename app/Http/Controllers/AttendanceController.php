<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AttendanceEmp;
use Illuminate\Http\Request;

use PDF;

class AttendanceController extends Controller
{   
    //show attendance 
    public function index()
    {  
        return view('admin.attendance')->with(['attendances' => Attendance::all()]);
    }

    //show late times
    public function indexLatetime()
    {
        return view('admin.latetime')->with(['latetimes' => Latetime::all()]);
    }

    

    // public static function lateTime(Employee $employee)
    // {
    //     $current_t = new DateTime(date('H:i:s'));
    //     $start_t = new DateTime($employee->schedules->first()->time_in);
    //     $difference = $start_t->diff($current_t)->format('%H:%I:%S');

    //     $latetime = new Latetime();
    //     $latetime->emp_id = $employee->id;
    //     $latetime->duration = $difference;
    //     $latetime->latetime_date = date('Y-m-d');
    //     $latetime->save();
    // }

    public static function lateTimeDevice($att_dateTime, Employee $employee)
    {
        $attendance_time = new DateTime($att_dateTime);
        $checkin = new DateTime($employee->schedules->first()->time_in);
        $difference = $checkin->diff($attendance_time)->format('%H:%I:%S');

        $latetime = new Latetime();
        $latetime->emp_id = $employee->id;
        $latetime->duration = $difference;
        $latetime->latetime_date = date('Y-m-d', strtotime($att_dateTime));
        $latetime->save();
    }
    public function generatePDF()
{
    $data = [
        // Pass any data you want to include in the PDF
        'employees' => Employee::all(),
    ];

    $pdf = PDF::loadView('attendance.pdf', $data);

    return $pdf->download('attendance.pdf');
}
  
public function filter(Request $request)
{
    // Retrieve the input from the form
    $dateFilter = $request->input('date_filter');
    $monthFilter = $request->input('month_filter');

    // Query attendance based on the filters
    if ($dateFilter) {
        $attendances = Attendance::whereDate('attendance_date', $dateFilter)->get();
    } elseif ($monthFilter) {
        $attendances = Attendance::whereMonth('attendance_date', $monthFilter)->get();
    } else {
        // If no filters provided, you might want to return all attendance
        $attendances = Attendance::all();
    }

    // Return the filtered attendance to the view
    return view('admin.sheet-report', ['attendances' => $attendances]);
}

}

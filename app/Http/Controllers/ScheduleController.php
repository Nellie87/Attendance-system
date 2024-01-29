<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\ScheduleEmp;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('admin.schedule')->with('schedules', Schedule::all());
    }

    public function store(ScheduleEmp $request)
    {
        $validatedData = $request->validated();

        $schedule = new Schedule;
        $schedule->slug = $validatedData['slug'];
      //  $schedule->time_in = $validatedData['time_in'];
       // $schedule->time_out = $validatedData['time_out'];
        $schedule->fellowship = $request->input('fellowship');
        $schedule->leader = $request->input('leader');
        $schedule->save();

        flash()->success('Success', 'Schedule has been created successfully!');
        return redirect()->route('schedule.index');
    }

    public function update(ScheduleEmp $request, Schedule $schedule)
    {
        $validatedData = $request->validated();

        $schedule->slug = $validatedData['slug'];
      //  $schedule->time_in = $validatedData['time_in'];
      //  $schedule->time_out = $validatedData['time_out'];
        $schedule->fellowship = $request->input('fellowship');
        $schedule->leader = $request->input('leader');
        $schedule->save();

        flash()->success('Success', 'Schedule has been updated successfully!');
        return redirect()->route('schedule.index');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        flash()->success('Success', 'Schedule has been deleted successfully!');
        return redirect()->route('schedule.index');
    }
}

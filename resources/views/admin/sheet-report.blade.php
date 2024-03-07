@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            Attendance Sheet Report
            <a href="{{ route('attendance.pdf') }}" class="btn btn-primary">Download as PDF</a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-md table-hover" id="printTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Position</th>
                            @php
                                $startDate = now()->startOfYear(); // Get the start of the current year
                                $endDate = now(); // Get the current date
                                $dates = [];
                                for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                                    if ($date->dayOfWeek === 0) { // Check if it's Sunday
                                        $dates[] = $date->format('Y-m-d');
                                    }
                                }
                            @endphp
                            @foreach ($dates as $date)
                                <th style="">
                                    {{ $date }}
                                    <br>
                                    <small>
                                        @php
                                            $sundayAttendance = \App\Models\Attendance::query()
                                                ->where('attendance_date', $date)
                                                ->where('status', 1) // Consider only present employees
                                                ->count();
                                            $totalEmployees = count($employees);
                                            $attendancePercentage = $totalEmployees > 0 ? round(($sundayAttendance / $totalEmployees) * 100, 2) : 0;
                                        @endphp
                                        {{ $attendancePercentage }}% Present
                                    </small>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <input type="hidden" name="emp_id" value="{{ $employee->id }}">
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                @foreach ($dates as $date)
                                    <td>
                                        @php
                                            $check_attd = \App\Models\Attendance::query()
                                                ->where('emp_id', $employee->id)
                                                ->where('attendance_date', $date)
                                                ->first();
                                            $check_leave = \App\Models\Leave::query()
                                                ->where('emp_id', $employee->id)
                                                ->where('leave_date', $date)
                                                ->first();
                                        @endphp
                                        <div class="form-check form-check-inline ">
                                            @if (isset($check_attd))
                                                @if ($check_attd->status==1)
                                                    <i class="fa fa-check text-success"></i>
                                                @else
                                                    <i class="fa fa-check text-danger"></i>
                                                @endif
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </div>
                                       
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

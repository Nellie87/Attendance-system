@extends('layouts.master')

@section('css') 
    {{-- Table css --}}
   <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
        type="text/css" media="screen">
@endsection

@section('content') 

    <div class="card"> 
        <div class="card-body">
        @php
                $today = today();
                $monthName = $today->format('F'); // Get the full month name
            @endphp
            <h2>{{ $monthName }}</h2> <!-- Display the full month name -->
            <div class="table-responsive">
                <table class="table table-responsive table-hover table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>ID</th> 
                            {{-- Display dates --}}
                            @php
                                $today = today();
                                $dates = [];

                                for ($i = 1; $i <= $today->daysInMonth; ++$i) {
                                    $currentDate = $today->copy()->day($i);  // Create a Carbon object for the current day

                                    // Check if the current day is a Sunday (dayOfWeek returns 0 for Sunday)
                                    if ($currentDate->dayOfWeek == 0) {
                                        $dates[] = $currentDate->format('Y-m-d');
                                    }
                                }
                            @endphp

                            @foreach ($dates as $date)
                                <th>{{ $date }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        <form action="{{ route('check_store') }}" method="post">
                            <button type="submit" class="btn btn-success" style="display: flex; margin:10px">Submit Attendance</button>
                            @csrf

                            @foreach ($employees as $employee) 
                                <input type="hidden" name="emp_id" value="{{ $employee->id }}">
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->id }}</td>

                                    {{-- Display checkboxes for each date --}}
                                    @foreach ($dates as $date)
                                        <td>
                                            @php
                                                $date_picker = $date;
                                                $check_attd = \App\Models\Attendance::query()
                                                    ->where('emp_id', $employee->id)
                                                    ->where('attendance_date', $date_picker)
                                                    ->first();
                                                $check_leave = \App\Models\Leave::query()
                                                    ->where('emp_id', $employee->id)
                                                    ->where('leave_date', $date_picker)
                                                    ->first();
                                            @endphp

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" id="check_box_{{ $date_picker }}"
                                                    name="attd[{{ $date_picker }}][{{ $employee->id }}]" type="checkbox"
                                                    @if (isset($check_attd)) checked @endif value="1">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')
@section('content')

    <div class="card">
        <div class="card-header bg-success text-white">
            Attendance Sheet Report
            <a href="{{ route('attendance.pdf') }}" class="btn btn-primary">Download as PDF</a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                @php
                    $startDate = now()->startOfYear(); // Get the start of the current year
                    $endDate = now(); // Get the current date
                    $months = [];
                    for ($date = $startDate; $date->lte($endDate); $date->addMonth()) {
                        $months[$date->format('m-Y')] = $date->format('F Y');
                    }
                @endphp
                @foreach ($months as $monthKey => $month)
                    <button type="button" class="btn btn-primary month-toggle" data-month="{{ $monthKey }}">{{ $month }}</button>
                @endforeach
            </div>
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
                                <th class="sunday-column">{{ $date }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                @foreach ($dates as $date)
                                    <td class="sunday-column">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthButtons = document.querySelectorAll('.month-toggle');
            const sundayColumns = document.querySelectorAll('.sunday-column');

            monthButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedMonth = this.getAttribute('data-month');
                    sundayColumns.forEach(column => {
                        if (column.textContent.includes(selectedMonth)) {
                            column.style.display = 'table-cell';
                        } else {
                            column.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endsection

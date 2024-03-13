@extends('layouts.master')
@section('content')

    <style>
        /* CSS for thick border between months */
        .month-header,
        .month-cell {
            border-right: 4px solid black; /* Adjust the thickness of the border as needed */
        }
    </style>

    <div class="card">
        <div class="card-header bg-success text-white">
            Attendance Sheet Report
            <a href="{{ route('attendance.pdf') }}" class="btn btn-primary">Download as PDF</a>

            <!-- Buttons for filtering by month -->
            <!-- <div class="btn-group ml-2">
                @php
                    $months = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $months[date('F', mktime(0, 0, 0, $i, 1))] = date('m', mktime(0, 0, 0, $i, 1));
                    }
                @endphp
                @foreach ($months as $monthName => $monthNumber)
                    <button type="button" class="btn btn-secondary filter-btn" data-month="{{ $monthNumber }}">{{ $monthName }}</button>
                @endforeach
            </div> -->
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

                                $monthGroups = collect($dates)->groupBy(function($date) {
                                    return \Carbon\Carbon::parse($date)->format('F Y');
                                });
                            @endphp
                            @foreach ($monthGroups as $month => $dates)
                                <th colspan="{{ count($dates) }}" class="month-header">
                                    {{ $month }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            @foreach ($monthGroups as $month => $dates)
                                @foreach ($dates as $date)
                                    <th >{{ \Carbon\Carbon::parse($date)->format('d-m-y') }}</th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <input type="hidden" name="emp_id" value="{{ $employee->id }}">
                            <tr>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->position }}</td>
                                @foreach ($monthGroups as $month => $dates)
                                    @foreach ($dates as $date)
                                        <td >
                                            @php
                                                $check_attd = \App\Models\Attendance::query()
                                                    ->where('emp_id', $employee->id)
                                                    ->where('attendance_date', $date)
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
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // JavaScript for filtering attendance data by month
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const month = this.dataset.month;

                    // Hide all rows initially
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        row.style.display = 'none';
                    });

                    // Show rows with attendance for selected month
                    const rowsToShow = document.querySelectorAll(`tbody td:nth-child(${parseInt(month) + 2})`);
                    rowsToShow.forEach(cell => {
                        const row = cell.closest('tr');
                        row.style.display = '';
                    });
                });
            });
        });
    </script>
@endsection

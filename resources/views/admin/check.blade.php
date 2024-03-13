@extends('layouts.master')

@section('css') 
    {{-- Table css --}}
   <link href="{{ URL::asset('plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }}" rel="stylesheet"
        type="text/css" media="screen">
@endsection

@section('content') 

    <div class="card"> 
        <div class="card-body">
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
                                $year = $today->year;
                                $sundaysByMonth = [];

                                $firstSundayOfYear = \Carbon\Carbon::parse("first sunday of January $year");

                                $currentSunday = $firstSundayOfYear->copy();
                                while ($currentSunday->lte($today)) {
                                    $month = $currentSunday->format('F Y');
                                    $date = $currentSunday->format('Y-m-d');
                                    $sundaysByMonth[$month][] = $date;
                                    $currentSunday->addWeek(); // Move to the next Sunday
                                }
                            @endphp

                            @foreach ($sundaysByMonth as $month => $sundays)
                                <th colspan="{{ count($sundays) }}" class="month-column">
                                    <a href="#" class="toggle-month" data-month="{{ $month }}">{{ $month }}</a>
                                    <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item minimize-month" href="#" data-month="{{ $month }}">Minimize</a>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                        
                        <tr class="date-row">
                            <td></td>
                            <td></td>
                            <td></td>
                            @foreach ($sundaysByMonth as $month => $sundays)
                                @foreach ($sundays as $sunday)
                                    <th class="date-column {{ str_replace(' ', '-', $month) }}">{{ $sunday }}</th>
                                @endforeach
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
                                    @foreach ($sundaysByMonth as $month => $sundays)
                                        @foreach ($sundays as $sunday)
                                            <td class="date-column {{ str_replace(' ', '-', $month) }}">
                                                @php
                                                    $date_picker = $sunday;
                                                    $check_attd = \App\Models\Attendance::query()
                                                        ->where('emp_id', $employee->id)
                                                        ->where('attendance_date', $date_picker)
                                                        ->first();
                                                @endphp

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="check_box_{{ $date_picker }}"
                                                        name="attd[{{ $date_picker }}][{{ $employee->id }}]" type="checkbox"
                                                        @if (isset($check_attd)) checked @endif value="1">
                                                </div>
                                            </td>
                                        @endforeach
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

@section('scripts')
    <script>
        $(document).ready(function(){
            $('.toggle-month').click(function(e){
                e.preventDefault();
                var month = $(this).data('month');
                $('.month-column:contains("'+ month +'")').toggleClass('hidden');
                $('.' + month.split(' ').join('-')).toggleClass('hidden');
            });

            $('.minimize-month').click(function(e){
                e.preventDefault();
                var month = $(this).data('month');
                $('.month-column:contains("'+ month +'")').addClass('hidden');
                $('.' + month.split(' ').join('-')).addClass('hidden');
            });
        });
    </script>
@endsection

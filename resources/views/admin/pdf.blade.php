<!-- attendance/pdf.blade.php -->
@extends('layouts.pdf')

@section('content')
    <table class="table table-responsive table-hover table-bordered table-sm">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>ID</th>
                @foreach ($dates as $date)
                    <th>{{ $date }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->id }}</td>
                    @foreach ($dates as $date)
                        <td>
                            <!-- Render attendance status for each employee and date -->
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

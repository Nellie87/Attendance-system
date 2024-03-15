@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Deleted Employees</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedEmployees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>

                            <td>
                                <!-- Add actions here, like restoring or permanently deleting -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

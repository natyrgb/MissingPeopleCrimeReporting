@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Stations</h3>
            <div class="card-body">
                @if ($stations->count())
                    <table class="table table-bordered table-striped datatable-custom">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Woreda</th>
                                <th>Has Admin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($stations as $item)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->woreda}}</td>
                                    <td>{{ $item->admin != null ? 'Yes' : 'No'}}</td>
                                    <td>
                                        @if ($item->admin == null)
                                            <a onclick="ajaxCall('{{$item->id}}')" type="button" class="btn btn-success">
                                                Assing Admin
                                            </a>
                                        @endif
                                        <a href="{{route('superadmin.stations.edit', $item)}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <form action="{{route('superadmin.stations.destroy', $item)}}" method="post" id="delete{{$item->id}}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger" role="alert">
                        There are no stations available.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="police" tabindex="-1" role="dialog" aria-labelledby="policeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeesLabel">Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="datatable_emp" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="emp_tbody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function ajaxCall(station) {
            $.ajax({
                url: '/superadmin/get_polices/' + station,
                type: 'GET',
                success: function(employees) {
                    $('#emp_tbody').empty();
                    $.each(employees, function(i, employee) {
                        let r ='<tr><td scope="col">'+(++i)+'</td><td>'+employee.name+'</td><td>'+employee.role+'</td>';
                        r += '<td><a class="btn btn-success" href="/superadmin/add_admin/'+station+'/'+employee.id+'">Assign</a></td></tr>'
                        console.log(r);
                        $('#datatable_emp > tbody').append(r);
                    });
                    $('#datatable_emp').DataTable();
                    var myModal = new bootstrap.Modal(document.getElementById("police"), {});
                    myModal.show();
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    </script>
@endsection

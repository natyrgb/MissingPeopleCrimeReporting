@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">All Complaints</h3>
            <div class="card-body">
                @if ($complaints->count())
                    <div class="row">
                        <div class="col-md-2">
                            <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($complaints as $type => $typed_complaints)
                                    <li class="nav-item">
                                        <a class="nav-link @if($i==0) active @endif" id="{{$type}}-tab" href="#{{$type}}" aria-controls="{{$type}}" role="tab" data-toggle="pill" @if($i==0) aria-selected="true" @endif>
                                            <span class="badge badge-success float-right">{{$typed_complaints->count()}}</span>
                                            {{ucwords(str_replace('_', ' ', $type))}}
                                        </a>
                                    </li>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content" id="myTabContent">
                                @php
                                    $j = 0;
                                @endphp
                                @foreach ($complaints as $type => $typed_complaints)
                                    <div class="tab-pane fade @if($j==0) show active @endif" id="{{$type}}" role="tabpanel" aria-labelledby="{{$type}}-tab">
                                        <table class="datatable-custom table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Reporter</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $k = 1;
                                                @endphp
                                                @foreach ($typed_complaints as $item)
                                                    <tr>
                                                        <th scope="row">{{$k}}</th>
                                                        <td>{{$item->user->name}}</td>
                                                        <td>{{ucwords(str_replace('_', ' ', $item->type))}}</td>
                                                        <td>{{ucwords(str_replace('_', ' ', $item->status))}}</td>
                                                        <td>
                                                            @if ($item->status == 'new')
                                                                <a onclick="ajaxCall('{{$type}}', '{{$item->id}}')" type="button" class="btn btn-success">
                                                                    Assign Police
                                                                </a>
                                                            @endif
                                                            <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <i class="far fa-trash-alt"></i>
                                                            </a>
                                                            <form action="{{route('admin.complaints.destroy', $item)}}" method="post" id="delete{{$item->id}}">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $k++;
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @php
                                        $j++;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        There are no complaints.
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
                <h5 class="modal-title" id="employeesLabel">Available Police</h5>
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
                            <th>Department</th>
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
        function ajaxCall(dep, complaint) {
            $.ajax({
                url: '/admin/complaints/get_police/' + dep,
                type: 'GET',
                success: function(employees) {
                    $('#emp_tbody').empty();
                    $.each(employees[0], function(i, employee) {
                        let r ='<tr><td scope="col">'+(++i)+'</td><td>'+employee.name+'</td><td>'+employee.role+'</td><td>'+employee.department.name+'</td>';
                        r += '<td><a class="btn btn-success" href="/admin/complaints/assign_case/'+complaint+'/'+employee.id+'">Assign</a></td>'
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

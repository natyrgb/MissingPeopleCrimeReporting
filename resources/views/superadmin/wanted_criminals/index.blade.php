@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Wanted Criminals</h3>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="wanted-tab" data-toggle="tab" href="#wanted" role="tab" aria-controls="wanted" aria-selected="true">Wanted Criminals</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">All Criminals</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="wanted" role="tabpanel" aria-labelledby="wanted-tab">
                        @if ($wanted_criminals->count())
                            <table class="table table-bordered table-striped datatable-custom">
                                <thead>
                                    <tr>
                                        <th>Citizen Id</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Mugshot 1</th>
                                        <th>Mugshot 2</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wanted_criminals as $item)
                                        <tr>
                                            <th scope="row">{{$item->criminal->citizen_id}}</th>
                                            <td>{{$item->criminal->name}}</td>
                                            <td>{{$item->status}}</td>
                                            <td>
                                                <a data-toggle="tooltip" title="<img src='{{asset($item->criminal->mugshot1)}}' class='img-fluid'>">{{$item->criminal->mugshot1}}</a>
                                            </td>
                                            <td>
                                                <a data-toggle="tooltip" title="<img src='{{asset($item->criminal->mugshot2)}}' class='img-fluid'>">{{$item->criminal->mugshot2}}</a>
                                            </td>
                                            <td>
                                                <a href="{{route('superadmin.wanted_criminals.mark_found', $item)}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    Mark As Found
                                                </a>
                                                <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                                <form action="{{route('superadmin.wanted_criminals.destroy', $item)}}" method="post" id="delete{{$item->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger" role="alert">
                                There are no criminals available.
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @if ($criminals->count())
                            <table class="table table-bordered table-striped datatable-custom">
                                <thead>
                                    <tr>
                                        <th>Citizen Id</th>
                                        <th>Name</th>
                                        <th>Mugshot 1</th>
                                        <th>Mugshot 2</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($criminals as $item)
                                        @if (!$item->wanted_criminal)
                                            <tr>
                                                <th scope="row">{{$item->citizen_id}}</th>
                                                <td>{{$item->name}}</td>
                                                <td>
                                                    <a data-toggle="tooltip" title="<img src='{{asset($item->mugshot1)}}' class='img-fluid'>">{{$item->mugshot1}}</a>
                                                </td>
                                                <td>
                                                    <a data-toggle="tooltip" title="<img src='{{asset($item->mugshot2)}}' class='img-fluid'>">{{$item->mugshot2}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{route('superadmin.make_wanted', $item)}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        Mark As Wanted
                                                    </a>
                                                    <a class="btn btn-danger delete" id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                    <form action="{{route('superadmin.blogs.destroy', [$item])}}" method="post" id="delete{{$item->id}}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger" role="alert">
                                There are no criminals available.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

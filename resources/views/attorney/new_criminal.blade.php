@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Add Criminal</h1>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <h3 class="card-header">Similar Named Criminals</h3>
                <div class="card-body">
                    @if ($criminals->count())
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Citizen Id</th>
                                    <th>Name</th>
                                    <th>Mugshot</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($criminals as $item)
                                    <tr>
                                        <th scope="row">{{$item->citizen_id}}</th>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <img src='{{asset($item->mugshot1)}}' class='img-fluid' width="80">
                                        </td>
                                        <td>
                                            <a href="{{route('attorney.add_to_record', [$suspect, $item])}}" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit">
                                                Add To Record
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-danger" role="alert">
                            There are no similar named criminals.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <h3 class="card-header">New Criminal</h3>
                <div class="card-body">
                    <form action="{{route('attorney.new_criminal_record', $suspect)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="citizen_id">Citizen Id</label>
                            <input type="text" class="form-control" id="citizen_id" name="citizen_id">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" value="{{$suspect->name}}" name="name">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" placeholder="Age" name="age">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" value="{{$suspect->address ? $suspect->address : ''}}" name="address">
                        </div>
                        <div class="form-group">
                            <label for="sex">Gender</label>
                            <select class="form-control" id="sex" name="sex">
                                <option @if($suspect->sex == 'male') selected @endif value="male">Male</option>
                                <option @if($suspect->sex == 'female') selected @endif value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <select class="form-control" id="occupation" name="occupation">
                                <option selected value="employed">Employed</option>
                                <option value="unemployed">Unemployed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mugshot1">Image 1</label>
                            <input type="file" class="form-control-file" id="mugshot1" name="mugshot1">
                        </div>
                        <div class="form-group">
                            <label for="mugshot2">Image 2</label>
                            <input type="file" class="form-control-file" id="mugshot2" name="mugshot2">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

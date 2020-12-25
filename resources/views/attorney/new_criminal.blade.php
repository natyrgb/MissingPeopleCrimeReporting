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
                    <form action="{{route('attorney.new_criminal_record', [$suspect->finding, $suspect])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="citizen_id">Citizen Id</label>
                            <input type="text" class="form-control @error('citizen_id') is-invalid @enderror" id="citizen_id" name="citizen_id">
                            @error('citizen_id')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{$suspect->name}}" name="name">
                            @error('name')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Dirthdate</label>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{date('Y-m-d', strtotime('-18 years'))}}" max="{{date('Y-m-d', strtotime('-17 years'))}}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" value="{{$suspect->address ? $suspect->address : ''}}" name="address">
                            @error('address')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option @if($suspect->sex == 'male') selected @endif value="male">Male</option>
                                <option @if($suspect->sex == 'female') selected @endif value="female">Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="occupation">Occupation</label>
                            <select class="form-control @error('occupation') is-invalid @enderror" id="occupation" name="occupation">
                                <option selected value="employed">Employed</option>
                                <option value="unemployed">Unemployed</option>
                            </select>
                            @error('occupation')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mugshot1">Image 1</label>
                            <input type="file" class="form-control-file @error('mugshot1') is-invalid @enderror" id="mugshot1" name="mugshot1">
                            @error('mugshot1')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mugshot2">Image 2</label>
                            <input type="file" class="form-control-file @error('mugshot2') is-invalid @enderror" id="mugshot2" name="mugshot2">
                            @error('mugshot2')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

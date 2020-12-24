@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-2">Stations</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Add Station</h3>
                <div class="card-body">
                    <form action="{{route('superadmin.stations.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input required type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                            @error('name')
                                <small id="nameHelp" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="woreda">Woreda</label>
                            <select name="woreda" id="woreda" class="form-control" aria-describedby="woredaHelp">
                                <option selected value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            @error('woreda')
                                <small id="woredaHelp" class="form-text text-muted">{{$message}}</small>
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

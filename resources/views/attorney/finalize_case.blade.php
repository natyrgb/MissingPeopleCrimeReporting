@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Finalize Case</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Cases</h3>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab{{$finding->id}}" data-toggle="tab" href="#home{{$finding->id}}" role="tab" aria-controls="home{{$finding->id}}" aria-selected="true">Overall</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="suspects-tab{{$finding->id}}" data-toggle="tab" href="#suspects{{$finding->id}}" role="tab" aria-controls="suspects{{$finding->id}}" aria-selected="false">Suspects</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="files-tab{{$finding->id}}" data-toggle="tab" href="#files{{$finding->id}}" role="tab" aria-controls="files{{$finding->id}}" aria-selected="false">Files</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="home{{$finding->id}}" role="tabpanel" aria-labelledby="home-tab{{$finding->id}}">
                            <div class="row px-4">
                                <div class="col-md-4">
                                    <figure>
                                        <img src="{{asset('images/'.$finding->complaint->attachment->url)}}" alt="" class="img-fluid">
                                        <figcaption><strong>Evidence</strong></figcaption>
                                    </figure>
                                </div>
                                <div class="col-md-8 px-4">
                                    <div class="card">
                                        <h2 class="card-header">Case</h2>
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Case Number:</strong>
                                                <i>{{$finding->id}}</i>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Reporter:</strong>
                                                <i>{{$finding->complaint->user->name}}<a href="#">Show User</a></i>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Crime Type:</strong>
                                                <span>{{$finding->complaint->type}}</span>
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Crime Details: </strong>
                                                <span>{{$finding->complaint->details}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="suspects{{$finding->id}}" role="tabpanel" aria-labelledby="suspects-tab{{$finding->id}}">
                            <div class="card card-danger">
                                <h3 class="card-header">Existing Suspects</h3>
                                <div class="card-body">
                                    @if (!$finding->suspects->count())
                                        <div class="alert alert-danger">
                                            <p class="head">There are no suspects.</p>
                                        </div>
                                    @else
                                        <table class="table datatable-custom table-borderd table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Verdict</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($finding->suspects as $item)
                                                    <tr>
                                                        <th scope="row">{{$item->name}}</th>
                                                        <td>{{$item->verdict}}</td>
                                                        <td>
                                                            <form action="{{route('attorney.give_verdict', [$finding, $item])}}" method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="verdict">Verdict</label>
                                                                    <select name="verdict" id="verdict" class="form-control">
                                                                        <option @if($item->verdict == 'under_investigation') selected @endif value="under_investigation">Under Investigation</option>
                                                                        <option @if($item->verdict == 'guilty') selected @endif value="guilty">Guilty</option>
                                                                        <option @if($item->verdict == 'not_guilty') selected @endif value="not_guilty">Not Guilty</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-success">Give Verdict</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="files{{$finding->id}}" role="tabpanel" aria-labelledby="files-tab{{$finding->id}}">
                            <div class="row d-flex justify-content-center mb-5">
                                <a href="#" class="btn btn-success btn-xl">Finalize Case</a>
                            </div>
                            <div class="card card-danger">
                                <h3 class="card-header">Existing Files</h3>
                                <div class="card-body">
                                    @if (!$finding->attachments->count())
                                        <div class="alert alert-danger">
                                            <p class="head">There are no files.</p>
                                        </div>
                                    @else
                                        <table class="table datatable-custom table-borderd table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($finding->attachments as $item)
                                                    <tr>
                                                        <th scope="row">{{$item->url}}</th>
                                                        <td>
                                                            <a id="{{asset($item->url)}}"class="btn btn-success" data-toggle="modal" data-target="#modal_file">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

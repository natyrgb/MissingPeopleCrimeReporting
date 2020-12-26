@extends('layouts.backend.app')

@section('content')
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
                                    <img src="{{asset($finding->complaint->attachment->url)}}" alt="" class="img-fluid">
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
                                                @if ($item->verdict == 'under_investigation')
                                                    <tr>
                                                        <th scope="row">{{$item->name}}</th>
                                                        <td>{{ucwords(str_replace('_', ' ', $item->verdict))}}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="{{$item->id}}">Verdict</label>
                                                                <select name="verdict" id="{{$item->id}}" class="form-control verdict">
                                                                    <option @if($item->verdict == 'under_investigation') selected @endif value="under_investigation">Under Investigation</option>
                                                                    <option @if($item->verdict == 'guilty') selected @endif value="guilty">Guilty</option>
                                                                    <option @if($item->verdict == 'not_guilty') selected @endif value="not_guilty">Not Guilty</option>
                                                                </select>
                                                            </div>
                                                            <a href="/attorney/give_verdict/{{$item->id}}" id="link{{$item->id}}"></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="files{{$finding->id}}" role="tabpanel" aria-labelledby="files-tab{{$finding->id}}">
                        <div class="row d-flex justify-content-center mb-5">
                            <a href="{{route('attorney.close_case', $finding)}}" class="btn btn-success btn-xl">Close Case</a>
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
@endsection

@section('js')
    <script>
        $(document).on('change', '.verdict', function() {
            let id = parseInt(this.id);
            let locator = `#link${id}`;
            let link = $(locator).attr('href');
            $(locator).attr('href', link+'/'+this.value)
            $(locator)[0].click();
        });
    </script>

    @if(session()->has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire('Error', "{{session('message')}}", 'error');
        })
    </script>
    @endif()
@endsection

@extends('layouts.backend.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h3 class="card-header">Missing People</h3>
            <div class="card-body">
                @if ($missing_people->count())
                <table class="datatable-custom table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Reporter</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($missing_people as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->user->name}}</td>
                                <td>
                                    <a id="{{asset($item->attachment->url)}}"class="btn btn-success" data-toggle="modal" data-target="#modal_missing">
                                        {{$item->attachment->url}}
                                    </a>
                                </td>
                                <td>{{ucwords(str_replace('_', ' ', $item->status))}}</td>
                                <td>
                                    <a href="{{route('police.mark_as_found', $item->id)}}" class="btn btn-success">Mark As Found</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-danger" role="alert">
                        There are no missing people.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('police.partials.modal')

@endsection

@section('js')
<script>
    $('.modal').on('shown.bs.modal', function(e) {
        var src = $(e.relatedTarget).attr('id');
        $(this).find('#missing_img').attr('src', src);
        $('#image_container').show();
    })
</script>
@endsection


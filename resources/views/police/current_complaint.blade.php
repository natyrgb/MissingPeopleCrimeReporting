@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    @if($case)
    <h1 class="display-4">Current Case</h1>
    <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Overall</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="suspects-tab" data-toggle="tab" href="#suspects" role="tab" aria-controls="suspects" aria-selected="false">Suspects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">Files</a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            @include('police.partials.overall', ['case' => $case])
        </div>
        <div class="tab-pane fade" id="suspects" role="tabpanel" aria-labelledby="suspects-tab">
            @include('police.partials.suspects', ['case' => $case])
        </div>
        <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
            @include('police.partials.evidence', ['case' => $case])
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        <p class="lead">You have no case assigned to you.</p>
    </div>
    @endif
</div>

@include('police.partials.modal')
@endsection

@section('js')
<script>
    $('.modal').on('shown.bs.modal', function(e) {
        var src = $(e.relatedTarget).attr('id');
        if(src.endsWith('.jpg') || src.endsWith('.jpeg') || src.endsWith('.png')) {
            $(this).find('#modal_img').attr('src', src);
            $('#image_container').show();
            $('#file_name').hide();
            $('#file_link').hide();
        }
        else {
            $('#modal_image').removeAttr('src').hide();
            $('#image_container').hide();
            $('#file_name').show().html(src);
            $('#file_link').show().attr('href', src);
        }
    })
</script>
@endsection

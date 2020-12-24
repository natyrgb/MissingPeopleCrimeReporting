@extends('layouts.backend.app')

@section('content')
<div class="content-wrapper">
    <h1 class="display-4">Cases</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Cases</h3>
                <div class="card-body">
                    @if ($findings->count())
                        <div class="row">
                            <div class="col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($findings as $finding)
                                        <li class="nav-item">
                                            <a class="nav-link @if($i==0) active @endif" id="{{$finding->id}}-tab" href="#{{$finding->id}}" aria-controls="{{$finding->id}}" role="tab" data-toggle="pill" @if($i==0) aria-selected="true" @endif>
                                                {{ucwords(str_replace('_', ' ', $finding->complaint->type))}}
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
                                    @foreach ($findings as $finding)
                                        <div class="tab-pane fade @if($j==0) show active @endif" id="{{$finding->id}}" role="tabpanel" aria-labelledby="{{$finding->id}}-tab">
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
                                                    @include('attorney.partials.overall', ['case' => $finding->complaint])
                                                </div>
                                                <div class="tab-pane fade" id="suspects{{$finding->id}}" role="tabpanel" aria-labelledby="suspects-tab{{$finding->id}}">
                                                    @include('attorney.partials.suspects', ['finding' => $finding])
                                                </div>
                                                <div class="tab-pane fade" id="files{{$finding->id}}" role="tabpanel" aria-labelledby="files-tab{{$finding->id}}">
                                                    <div class="row d-flex justify-content-center mb-5">
                                                        <a href="{{route('attorney.finalize_case', $finding)}}" class="btn btn-success btn-xl">Finalize Case</a>
                                                    </div>
                                                    @include('attorney.partials.evidence', ['finding' => $finding])
                                                </div>
                                            </div>
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
                            There are no cases assigned.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('attorney.partials.modal')

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

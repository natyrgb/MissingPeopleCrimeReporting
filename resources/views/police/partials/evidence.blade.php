<div class="row d-flex justify-content-center mb-5">
    <a href="{{route('police.send_to_court', $case->finding)}}" class="btn btn-success btn-xl">Send Case To Court</a>
</div>
<div class="row">
    <div class="col-md-6 px-4">
        <div class="card card-danger">
            <h3 class="card-header">Existing Files</h3>
            <div class="card-body">
                @if (!$case->finding->attachments->count())
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
                            @foreach ($case->finding->attachments as $item)
                                <tr>
                                    <th scope="row">{{$item->url}}</th>
                                    <td>
                                        <a id="{{asset($item->url)}}"class="btn btn-success" data-toggle="modal" data-target="#modal_file">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="event.preventDefault(); document.getElementById('delete{{$item->id}}').submit();">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <form action="{{route('police.delete_file', [$item])}}" method="post" id="delete{{$item->id}}">
                                            @csrf
                                            @method('DELETE')
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
    <div class="col-md-6 px-4">
        <div class="card card-success">
            <h3 class="card-header">Add File</h3>
            <div class="card-body">
                <form action="{{route('police.add_file', [$case->finding])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">File (*Optional)</label>
                        <input type="file" class="form-control-file" id="file" name="url" aria-describedby="fileHelp">
                        @error('file')
                            <small id="fileHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

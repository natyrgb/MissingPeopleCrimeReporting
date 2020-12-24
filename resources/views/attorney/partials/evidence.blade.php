<div class="row">
    <div class="col-md-12 px-4">
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
                                        <a class="btn btn-danger delete" data-toggle="tooltip" data-placement="top" title="Delete" onclick="event.preventDefault(); document.getElementById('delete{{$item->id}}').submit();">
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
</div>

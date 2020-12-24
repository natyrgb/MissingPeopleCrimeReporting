<div class="row">
    <div class="col-md-6 px-4">
        <div class="card card-danger">
            <h3 class="card-header">Existing Suspects</h3>
            <div class="card-body">
                @if (!$case->finding->suspects->count())
                    <div class="alert alert-danger">
                        <p class="head">There are no suspects.</p>
                    </div>
                @else
                    <table class="table datatable-custom table-borderd table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($case->finding->suspects as $item)
                                <tr>
                                    <th scope="row">{{$item->name}}</th>
                                    <td>{{ucwords(str_replace('_', ' ', $item->status))}}</td>
                                    <td>
                                        @if ($item->status == 'wanted')
                                        <a href="{{route('police.mark_in_custody', $item->id)}}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="In Custody">
                                            <i class="flaticon-handcuffs"></i>
                                        </a>
                                        @endif
                                        <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="event.preventDefault(); document.getElementById('delete{{$item->id}}').submit();">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                        <form action="{{route('police.delete_suspect', [$item])}}" method="post" id="delete{{$item->id}}">
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
            <h3 class="card-header">Add Suspect</h3>
            <div class="card-body">
                <form action="{{route('police.add_suspect', [$case->finding])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                        @error('name')
                            <small id="nameHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address (*Optional)</label>
                        <input type="text" class="form-control" id="address" name="address" aria-describedby="addressHelp">
                        @error('address')
                            <small id="addressHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" aria-describedby="genderHelp">
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                        </select>
                        @error('gender')
                            <small id="genderHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description (*Optional)</label>
                        <textarea name="description" id="description" class="form-control" aria-describedby="descriptionHelp"></textarea>
                        @error('description')
                            <small id="descriptionHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image (*Optional)</label>
                        <input type="file" class="form-control-file" id="image" name="image" aria-describedby="imageHelp">
                        @error('image')
                            <small id="imageHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" aria-describedby="statusHelp">
                            <option value="wanted" selected>Wanted</option>
                            <option value="in_custody">In Custody</option>
                        </select>
                        @error('status')
                            <small id="statusHelp" class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

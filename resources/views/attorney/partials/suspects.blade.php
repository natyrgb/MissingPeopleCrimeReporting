<div class="col-md-12 px-4">
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
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finding->suspects as $item)
                            <tr>
                                <th scope="row">{{$item->name}}</th>
                                <td>{{ucwords(str_replace('_', ' ', $item->status))}}</td>
                                <td>
                                    <a href="#" class="btn btn-success">
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

<div class="row px-4">
    <div class="col-md-4">
        <figure>
            <img src="{{asset($case->attachment->url)}}" alt="" class="img-fluid">
            <figcaption><strong>Evidence</strong></figcaption>
        </figure>
    </div>
    <div class="col-md-8 px-4">
        <div class="card">
            <h2 class="card-header">Complaints</h2>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Reporter:</strong>
                    <i>{{$case->user->name}}<a href="#">Show User</a></i>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>Crime Type:</strong>
                    <span>{{$case->type}}</span>
                </li>
                <li class="list-group-item">
                    <strong>Crime Details: </strong>
                    <span>{{$case->details}}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

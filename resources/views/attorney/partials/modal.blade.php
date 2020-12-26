<div class="modal fade" id="modal_file" tabindex="-1" role="dialog" aria-labelledby="fileLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeesLabel">Evidence Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="image_container">
                    <img alt="" id="modal_img" class="img-fluid">
                </div>
                <div class="row d-flex justify-content-around">
                    <span id="file_name"></span>
                    <a href="" id="file_link" target="_blank">Download File</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_suspect" tabindex="-1" role="dialog" aria-labelledby="fileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeesLabel">Suspect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div id="sus_image_container">
                            <img alt="" id="sus_img" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Name: </strong><span id="sus_name"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Address: </strong><span id="sus_addr"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Arrested Status: </strong><span id="sus_stat"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

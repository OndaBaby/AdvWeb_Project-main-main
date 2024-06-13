@extends('layouts.master')
@section('content')
<div id="couriers" class="container">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#courierModal">Add <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
    <div class="card-body" style="height: 210px;">
        <input type="text" id='courierSearch' placeholder="--search--">
    </div>
    <div class="table-responsive">
        <table id="ctable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Courier ID</th>
                    <th>Courier Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Service Area</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="cbody">
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="courierModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Courier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="iform" method="#" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="courier_name" class="control-label">Courier Name</label>
                        <input type="text" class="form-control" id="courier_name" name="courier_name">
                    </div>
                    <div class="form-group">
                        <label for="contact_number" class="control-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                    </div>
                    <div class="form-group">
                        <label for="email_id" class="control-label">Email</label>
                        <input type="text" class="form-control" id="email_id" name="email">
                    </div>
                    <div class="form-group">
                        <label for="service_area" class="control-label">Service Area</label>
                        <input type="text" class="form-control" id="service_area" name="service_area">
                    </div>
                    <div class="form-group">
                        <label for="image" class="control-label">Image</label>
                        <input type="file" class="form-control" id="image" name="uploads[]" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="courierSubmit" type="submit" class="btn btn-primary">Save</button>
                <button id="courierUpdate" type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')
@section('content')

<section class="mt-4">
    <div class="container">
        <form class="card">
            <div class="card-header">
                <nav class="nav nav-pills nav-fill">
                    <a class="nav-link tab-pills" href="#">Download template</a>
                    <a class="nav-link tab-pills" href="#">Upload database</a>
                    <a class="nav-link tab-pills" href="#">Import summary</a>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab d-none">
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        <h4>Download template</h4>
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        <h6>Insert your data into the template and upload the file to update the media database.</h6>
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-outline-success and-all-other-classes"><a style="color:inherit" href="{{ route('files.download') }}">Download</a></button>
                    </div>
                </div>

                <div class="tab d-none">
                    <div class="mb-3">
                        <form action="{{ route('files.import') }}" class="dropzone dz-clickable border rounded bg-light p-3">
                            {{ csrf_field() }}
                            <div class="dropzone dz-default dz-message text-center"></div>
                        </form>
                    </div>
                </div>

                <div class="tab d-none">
                    <div class="mb-3">
                        <h2 class="mt-4">Import Summery</h2>
                        <h6 id="importSummeryText" class="mt-4 d-none"></h6>
                        <div class="table-responsive" style="max-height: 500px;">
                            <table id="dynamicTable" class="table table-striped mt-3">
                                <thead>
                                <tr>
                                    <th>Row</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <button type="button" id="back_button" class="btn btn-primary" onclick="back()">Back</button>
                    <button type="button" id="next_button" class="btn btn-primary ms-auto" onclick="next()">Next</button>
                </div>
            </div>
        </form>
    </div>
</section>

@stop

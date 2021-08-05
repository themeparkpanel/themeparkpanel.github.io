@extends('layouts.admin')

@section('page', 'Operator')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h4 class="box-title text-center">Ride Operator Configurator</h4>
                        <i id="sync" class="fas fa-external-link-alt sync"></i>
                    </div>
                    <div class="box-body">
                        <form id="operator-form" class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-addon"><i class="fas fa-tag"></i></span>
                                <input type="text" class="form-control" name="id" placeholder="ID">
                            </div>

                            <div class="settings">
                                <div class="settings-toggle mb-3">
                                    <label class="switcher">
                                        <input id="template_toggle" name="template_toggle" type="checkbox" checked>
                                        <span class="switcher-slider"></span>
                                    </label>
                                </div>

                                <div class="settings-text mb-3">
                                    <p>Use Template</p>
                                </div>
                            </div>

                            <div class="settings" style="display: none">
                                <div class="settings-toggle mb-3">
                                    <label class="switcher">
                                        <input id="is_template" name="is_template" type="checkbox">
                                        <span class="switcher-slider"></span>
                                    </label>
                                </div>

                                <div class="settings-text mb-3">
                                    <p>Is Template</p>
                                </div>
                            </div>

                            <div id="template" class="input-group mb-3">
                                <span class="input-group-addon"><i class="fas fa-tag"></i></span>
                                <input type="text" class="form-control" name="template" placeholder="Template">
                            </div>
                            <div id="permission" class="input-group mb-3" style="display: none">
                                <span class="input-group-addon"><i class="fas fa-lock"></i></span>
                                <input type="text" class="form-control" name="permission" placeholder="Permission">
                            </div>
                            <div id="start_command" class="input-group mb-3" style="display: none">
                                <span class="input-group-addon"><i class="fas fa-terminal"></i></span>
                                <input type="text" class="form-control" name="start_command" placeholder="Start Command">
                            </div>
                            <div id="stop_command" class="input-group mb-3" style="display: none">
                                <span class="input-group-addon"><i class="fas fa-terminal"></i></span>
                                <input type="text" class="form-control" name="stop_command" placeholder="Stop Command">
                            </div>

                            <h3>Items <a class="btn btn-primary">Add Item</a></h3>
                            <div id="items">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h4 class="box-title text-center">Output</h4>
                    </div>
                    <div class="box-body">
                        <span><strong>File Name:</strong> <span id="file_name">panel_id.json</span></span>
                        <pre id="output">Output goes here</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('assets/js/operator.js') }}"></script>
@endsection

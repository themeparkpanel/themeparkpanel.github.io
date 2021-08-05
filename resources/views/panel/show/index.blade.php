@extends('layouts.admin')

@section('page', 'Show Manager')

@section('content')
            <div class="col-lg-8 col-lg-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Search</h3>
                    </div>
                    <div class="box-body">
                        <form id="searchForm">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                                <input id="search" type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Search for Shows by title" autofocus>
                            </div>
                            <button class="btn btn-block btn-primary">{{ __('Search') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-lg-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title" style="margin-top: 8px; width: 100%">Shows<small style="float: right"><a class="btn btn-primary" href="{{ route('panel.show.add') }}">Add</a></small></h3>
                    </div>
                    <div class="box-body">
                        @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @elseif(session('error'))
                        <div class="alert alert-success" role="alert">
                            {{ session('error') }}
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        </div>

                        @endif
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Vault Price</th>
                                <th class="text-center">Seats</th>
                                <th class="text-center" style="width: 155px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($shows->all()))
                            @foreach($shows as $show)
                            <tr>
                                <td>{{ $show->id }}</td>
                                <td>{{ $show->title }}</td>
                                <td class="text-center">€{{ $show->price }}</td>
                                <td class="text-center">{{ $show->vault_price }}</td>
                                <td>{{ $show->seats }}</td>
                                <td style="width: 155px"><a class="btn btn-primary" href="{{ route('panel.show.info', ['id' => $show->id]) }}"><i class="glyphicon glyphicon-info-sign"></i></a> <a class="btn btn-primary" style="margin-left: 2px" href="{{ route('panel.show.edit', ['id' => $show->id]) }}"><i class="glyphicon glyphicon-pencil"></i></a> <a class="btn btn-primary" style="margin-left: 2px" href="{{ route('panel.show.delete', ['id' => $show->id]) }}"><i class="glyphicon glyphicon-trash"></i></a></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td></td>
                                <td>No shows found</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                        @if(!empty($shows->all()))
                        <nav style="float: right">
                            <ul class="pagination">
                                <li @if($page == 1) class="disabled" @endif>
                                    <a @if($page != 1) href="{{ route('panel.ums', ['page' => ($page - 1)]) }}" @endif aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
                                </li>
                                @for($i = 1; $i <= $pages; $i++)
                                <li @if($i == $page) class="active" @endif>
                                    <a @if($i != $page)href="{{ route('panel.ums', ['page' => $i]) }}" @endif><span>{{ $i }}</span></a>
                                </li>
                                @endfor
                                <li @if($page == $pages) class="disabled" @endif>
                                    <a @if($page != $pages) href="{{ route('panel.ums', ['page' => ($page + 1)]) }}" @endif aria-label="Next"><span aria-hidden="true">»</span></a>
                                </li>
                            </ul>
                        </nav>
                        @endif
                    </div>
                </div>
            </div>
@endsection

@section('javascript')
<script>
const search = "{{ $search }}";
const route = "{{ route('panel.show', ['page' => 1]) }}";
$("form#searchForm").submit(function(e) {
    e.preventDefault();
    let term = $("form#searchForm input#search").val();
    if(term === search)
        return;

    window.location.replace(route + "/" + term);
});
</script>
@endsection

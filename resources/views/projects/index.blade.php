@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2>Laravel 8 CRUD </h2>
            <a class="btn btn-success" href="{{ route('projects.create') }}" title="Create a project"> <i class="fas fa-plus-circle fa-2x"></i> </a>
            <a class="btn btn-dark" href="{{ route('apiWithoutKey') }}" title="View Github Public Repository"> <i class="fab fa-github fa-2x"></i> </a>
            <a class="btn btn-dark" href="{{ route('apiWithKey') }}" title="View Dev.to List"> <i class="fab fa-dev fa-2x"></i> </a>
            <a class="btn btn-dark" href="{{ route('createPagination') }}" title="View Dev.to List"> <i class="fas fa-file-alt fa-2x"></i> </a>
        </div>
    </div>
</div>


<div class="">
    <div class="mx-auto pull-right">
        <div class="">
            <form action="{{ route('projects.index') }}" method="GET" role="search">

                <div class="input-group">
                    <span class="input-group-btn mr-5 mt-1">
                        <button class="btn btn-info" type="submit" title="Search projects">
                            <span class="fas fa-search"></span>
                        </button>
                    </span>
                    <input type="text" class="form-control mr-2" name="term" placeholder="Search projects" id="term">
                    <a href="{{ route('projects.index') }}" class=" mt-1">
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button" title="Refresh page">
                                <span class="fas fa-sync-alt"></span>
                            </button>
                        </span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif

<table class="table table-bordered table-responsive-lg">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Introduction</th>
        <th>Location</th>
        <th>Cost</th>
        <th>Date Created</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($projects as $project)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $project->name }}</td>
        <td>{{ $project->introduction }}</td>
        <td>{{ $project->location }}</td>
        <td>{{ $project->cost }}</td>
        <td>{{ date_format($project->created_at, 'jS M Y') }}</td>
        <td>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">

                <a href="{{ route('projects.show', $project->id) }}" title="show">
                    <i class="fas fa-eye text-success  fa-lg"></i>
                </a>

                <a href="{{ route('projects.edit', $project->id) }}">
                    <i class="fas fa-edit  fa-lg"></i>

                </a>

                @csrf
                @method('DELETE')

                <button type="submit" title="delete" style="border: none; background-color:transparent;">
                    <i class="fas fa-trash fa-lg text-danger"></i>

                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{!! $projects->links() !!}

@endsection

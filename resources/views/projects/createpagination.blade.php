@extends('layouts.app')

@section('content')

<style>


</style>
<div class="row mb-3">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2>Github Public Repository</h2>
            <a class="btn btn-primary" href="{{ route('projects.index') }}" title="Go back"> <i class="fas fa-backward fa-2x"></i> </a>
        </div>
    </div>
</div>



<div class="container-fluid mb-5" style="margin-bottom: 150px !important">
    <div class="row mr-4">
 
 <table class="table table-bordered table-responsive-lg">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Url</th>
        <th>Date Created</th> 
    </tr>
    @foreach ($githubRepo as $repo)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $repo['name'] }}</td>
        <td>{{ $repo['url'] }}</td>
        <td>{{ $repo['created_at'] }}</td>
    </tr>
    @endforeach
</table>
{!! $githubRepo->links() !!}
    </div>
</div>


@endsection

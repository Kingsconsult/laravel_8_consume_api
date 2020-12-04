@extends('layouts.app')

@section('content')

<style>


</style>
<div class="row mb-3">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2>Dev.to Article stats</h2>
            <a class="btn btn-primary" href="{{ route('projects.index') }}" title="Go back"> <i class="fas fa-backward fa-2x"></i> </a>
        </div>
    </div>
</div>



<div class="container-fluid mb-5" style="margin-bottom: 150px !important">
    <div class="row mr-4">
        @foreach ($onlyViews as $views)
        @foreach ($responseBody as $response)
        @if ($views == $response->page_views_count)

        <div class="col-xl-3 col-md-6 mb-4 hvr-grow ">
            <div class="card shadow  py-0 rounded-lg ">
                <div class="card-body py-2">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <a href="{{ $response->url }}" class="text-muted">
                                <div class=" font-weight-bold mb-2 mt-2 text-primary text-center text-uppercase mb-1">
                                    {{ Str::limit($response->title, 45) }}
                                </div>
                            </a>
                            <div class="h6 mb-0 text-gray-800 text-center">
                                {{ Str::limit($response->description, 100) }}
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 0" class="mb-2">
                        <hi>Page Views: <strong>{{ number_format($response->page_views_count) }}</strong></hi>
                        <hi class="ml-3"> Reactions: <strong>{{ $response->positive_reactions_count }} </strong></hi>
                    </div>
                </div>
            </div>
        </div>
        @break
        @endif
        @endforeach
        @endforeach
    </div>
</div>

@endsection

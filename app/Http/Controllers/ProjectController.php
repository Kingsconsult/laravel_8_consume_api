<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use PhpParser\Node\Expr\Exit_;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $projects = Project::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($term = $request->term)) {
                    $query->orWhere('name', 'LIKE', '%' . $term . '%')->get();
                }
            }]
        ])
            ->orderBy("id", "desc")
            ->paginate(10);
        // $projects = Project::latest()->paginate(5);

        return view('projects.index', compact('projects'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'introduction' => 'required',
            'location' => 'required',
            'cost' => 'required'
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'introduction' => 'required',
            'location' => 'required',
            'cost' => 'required'
        ]);
        $project->update($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    public function apiWithoutKey()
    {
        $client = new Client(); //GuzzleHttp\Client
        $url = "https://api.github.com/users/kingsconsult/repos";


        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());


        return view('projects.apiwithoutkey', compact('responseBody'));
    }

    public function apiWithKey()
    {
        $client = new Client();
        $url = "https://dev.to/api/articles/me/published";

        $params = [
            //If you have any Params Pass here
        ];

        $headers = [
            'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        ];

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());

        $onlyViews = [];


        foreach ($responseBody as $views) {
            array_push($onlyViews, $views->page_views_count, $views->title);
        }
        arsort($onlyViews);

        return view('projects.apiwithkey', compact('responseBody', 'onlyViews'));
    }

    private function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function createPagination() 
    {
        $client = new Client(); //GuzzleHttp\Client
        $url = "https://api.github.com/users/kingsconsult/repos";


        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());

        
        $responseArray = [];

        foreach ($responseBody as $key => $views) {
            $array = array('id' => $key, 'name' => $views->name, 'url' => $views->url, 'created_at' => $views->created_at);
            array_push($responseArray, $array);
        }

        $githubRepo = $this->paginate($responseArray)->setPath('/projects/createpagination');

        return view('projects.createpagination', compact('githubRepo'))
        ->with('i', (request()->input('page', 1) - 1) * 5)
        ;
    }
}

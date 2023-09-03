<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEndpointRequest;
use App\Models\Endpoint;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EndpointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $siteId)
    {
        if (!$site = Site::with('endpoints.check')->find($siteId)) {
            return back();
        }

        $this->authorize('owner', $site);
//        if (Gate::allows('owner', $site)) {
//        if (Gate::denies('owner', $site)) {
//            return back();
//        }

        $endpoints = $site->endpoints;

        return view('admin.endpoints.index', compact('site', 'endpoints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $siteId)
    {
        if (!$site = Site::with('endpoints')->find($siteId)) {
            return back();
        }

        $this->authorize('owner', $site);

        return view('admin.endpoints.create', compact('site'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateEndpointRequest $request, Site $site)
    {
        $this->authorize('owner', $site);

        $request->request->add(['next_check' => now()->addMinutes($request->get('frequency'))]);
        $site->endpoints()->create($request->all());

        return redirect()->route('endpoints.index', $site->id)->with('message', 'Endpoint criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site, Endpoint $endpoint)
    {
        $this->authorize('owner', $site);
        return view('admin.endpoints.edit', compact('site', 'endpoint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateEndpointRequest $request, Site $site, Endpoint $endpoint)
    {
        $this->authorize('owner', $site);

        $endpoint->update($request->validated());

        return redirect()->route('endpoints.index', $site->id)->with('message', 'Endpoint alterado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site, Endpoint $endpoint)
    {
        $this->authorize('owner', $site);

        $endpoint->delete();

        return redirect()->route('endpoints.index', $site->id)->with('message', 'Endpoint deletado com sucesso');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where('full_name', 'like', "%{$request->search}%")
                  ->orWhere('business_name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.form');
    }

    public function store(StoreClientRequest $request)
    {
        Client::create($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.form', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
@extends('layouts.app')

@section('page-title', 'Client Services')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h5>Client Services</h5>
        <a href="{{ route('client_services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Assign Service
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientServices as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>{{ $service->client->full_name }} @if($service->client->business_name) ({{ $service->client->business_name }}) @endif</td>
                            <td>{{ $service->service->name }}</td>
                            <td>{{ $service->created_at->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('client_services.edit', $service->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('client_services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No client services assigned yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">
                {{ $clientServices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
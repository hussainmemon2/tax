@extends('layouts.app')

@section('page-title', 'Edit Client Service')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Edit Client Service</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('client_services.update', $clientService->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Client -->
                <div class="mb-3">
                    <label class="form-label">Client</label>
                    <select class="form-select" name="client_id" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $clientService->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->full_name }} @if($client->business_name) ({{ $client->business_name }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Service -->
                <div class="mb-3">
                    <label class="form-label">Service</label>
                    <select class="form-select" name="service_id" required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $clientService->service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Service</button>
                <a href="{{ route('client_services.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
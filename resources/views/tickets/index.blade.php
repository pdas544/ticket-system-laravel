{{-- resources/views/tickets/index.blade.php --}}
@extends('layouts.app')

@section('title', 'All Support Tickets')
@section('page-title', 'All Support Tickets')

@section('content')
    <div class="row">
        {{-- Statistics Cards --}}
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Tickets</h5>
                    <h2 class="card-text">{{ $tickets->total() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Open Tickets</h5>
                    <h2 class="card-text">{{ $tickets->where('status', 'open')->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <h2 class="card-text">{{ $tickets->where('status', 'in_progress')->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Resolved</h5>
                    <h2 class="card-text">{{ $tickets->where('status', 'resolved')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Ticket Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Recent Tickets</h4>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Ticket
        </a>
    </div>

    {{-- Tickets List --}}
    @forelse($tickets as $ticket)
        <div class="card ticket-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none">
                                #{{ $ticket->id }}: {{ $ticket->title }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($ticket->description, 150) }}
                        </p>

                        {{-- Categories --}}
                        <div class="mb-2">
                            @foreach($ticket->categories as $category)
                                <span class="badge bg-{{ $category->color }} me-1">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>

                        <small class="text-muted">
                            <i class="fas fa-user"></i> {{ $ticket->user->name }}
                            <i class="fas fa-clock ms-3"></i> {{ $ticket->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="col-md-4 text-end">
                        {{-- Status Badge --}}
                        @php
                            $statusColors = [
                                'open' => 'warning',
                                'in_progress' => 'info',
                                'resolved' => 'success',
                                'closed' => 'secondary'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$ticket->status] ?? 'secondary' }} status-badge mb-2">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>

                        {{-- Priority Badge --}}
                        <span class="badge bg-{{ $ticket->priority == 'high' ? 'danger' : ($ticket->priority == 'medium' ? 'warning' : 'secondary') }} badge-priority me-1">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>

                        {{-- Assigned Agent --}}
                        @if($ticket->agent)
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-user-shield"></i> Assigned to: {{ $ticket->agent->name }}
                                </small>
                            </div>
                        @else
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-exclamation-circle"></i> Unassigned
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No tickets found.
            <a href="{{ route('tickets.create') }}" class="alert-link">Create your first ticket!</a>
        </div>
    @endforelse

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $tickets->onEachSide(1)->links() }}
    </div>


@endsection

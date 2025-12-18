{{-- resources/views/tickets/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id . ' - ' . $ticket->title)
@section('page-title', 'Ticket #' . $ticket->id)

@section('content')
    <div class="row">
        <div class="col-lg-8">
            {{-- Ticket Details Card --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $ticket->title }}</h5>
                    <div>
                        @php
                            $statusColors = [
                                'open' => 'warning',
                                'in_progress' => 'info',
                                'resolved' => 'success',
                                'closed' => 'secondary'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$ticket->status] ?? 'secondary' }} status-badge">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p class="card-text">{{ $ticket->description }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6>Details</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-user text-primary"></i>
                                    <strong>Created by:</strong> {{ $ticket->user->name }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar text-primary"></i>
                                    <strong>Created:</strong> {{ $ticket->created_at->format('M d, Y h:i A') }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-sync-alt text-primary"></i>
                                    <strong>Last Updated:</strong> {{ $ticket->updated_at->diffForHumans() }}
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h6>Classification</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-exclamation-circle text-primary"></i>
                                    <strong>Priority:</strong>
                                    <span class="badge bg-{{ $ticket->priority == 'high' ? 'danger' : ($ticket->priority == 'medium' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-tags text-primary"></i>
                                    <strong>Categories:</strong>
                                    @foreach($ticket->categories as $category)
                                        <span class="badge bg-{{ $category->color }} me-1">
                                        {{ $category->name }}
                                    </span>
                                    @endforeach
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-user-shield text-primary"></i>
                                    <strong>Assigned Agent:</strong>
                                    @if($ticket->agent)
                                        {{ $ticket->agent->name }}
                                    @else
                                        <span class="text-muted">Not assigned</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm float-end">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            {{-- Comments Section (We'll add this later) --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-comments"></i> Comments (Coming Soon)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Comments functionality will be added in Module 6.</p>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Quick Actions Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h6>
                </div>
                <div class="card-body">
                    @if($ticket->status == 'open')
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-info w-100 mb-2">
                                <i class="fas fa-play-circle"></i> Mark as In Progress
                            </button>
                        </form>
                    @endif

                    @if($ticket->status == 'in_progress')
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="resolved">
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-check-circle"></i> Mark as Resolved
                            </button>
                        </form>
                    @endif

                    @if(in_array($ticket->status, ['open', 'in_progress']))
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="closed">
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-times-circle"></i> Close Ticket
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Activity Log (We'll add this later) --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-history"></i> Recent Activity</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <small class="text-muted">Ticket created</small><br>
                            <small>{{ $ticket->created_at->diffForHumans() }}</small>
                        </li>
                        @if($ticket->updated_at != $ticket->created_at)
                            <li class="mb-2">
                                <small class="text-muted">Last updated</small><br>
                                <small>{{ $ticket->updated_at->diffForHumans() }}</small>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // JavaScript for this specific page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Ticket detail page loaded');
        });
    </script>
@endpush

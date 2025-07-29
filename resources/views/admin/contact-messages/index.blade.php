@extends('layouts.contentNavbarLayout')

@section('title', 'Contact Messages')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Contact Messages</h5>
                        <p class="mb-4">Manage incoming contact messages from your website</p>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($messages as $message)
                                        <tr class="{{ $message->status === 'unread' ? 'table-warning' : '' }}">
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->email }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($message->subject, 50) }}</td>
                                            <td>
                                                @if($message->status === 'unread')
                                                    <span class="badge bg-warning">Unread</span>
                                                @elseif($message->status === 'read')
                                                    <span class="badge bg-info">Read</span>
                                                @else
                                                    <span class="badge bg-success">Replied</span>
                                                @endif
                                            </td>
                                            <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.contact-messages.show', $message) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="ti ti-eye"></i> View
                                                    </a>
                                                    @if($message->status === 'unread')
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-info mark-read-btn"
                                                                data-message-id="{{ $message->id }}">
                                                            <i class="ti ti-check"></i> Mark Read
                                                        </button>
                                                    @endif
                                                    @if($message->status !== 'replied')
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-success mark-replied-btn"
                                                                data-message-id="{{ $message->id }}">
                                                            <i class="ti ti-message-reply"></i> Mark Replied
                                                        </button>
                                                    @endif
                                                    <form action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="ti ti-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No contact messages found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark as read functionality
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            const row = this.closest('tr');
            
            fetch(`/admin/contact-messages/${messageId}/mark-read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    row.classList.remove('table-warning');
                    const statusCell = row.querySelector('td:nth-child(4)');
                    statusCell.innerHTML = '<span class="badge bg-info">Read</span>';
                    this.remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking message as read');
            });
        });
    });

    // Mark as replied functionality
    document.querySelectorAll('.mark-replied-btn').forEach(button => {
        button.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            const row = this.closest('tr');
            
            fetch(`/admin/contact-messages/${messageId}/mark-replied`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    row.classList.remove('table-warning');
                    const statusCell = row.querySelector('td:nth-child(4)');
                    statusCell.innerHTML = '<span class="badge bg-success">Replied</span>';
                    this.remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking message as replied');
            });
        });
    });
});
</script>
@endsection 
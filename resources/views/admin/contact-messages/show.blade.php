@extends('layouts.contentNavbarLayout')

@section('title', 'Contact Message Details')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-12">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title text-primary">Contact Message Details</h5>
                            <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back"></i> Back to Messages
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name:</label>
                                    <p class="form-control-plaintext">{{ $contactMessage->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email:</label>
                                    <p class="form-control-plaintext">
                                        <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject:</label>
                                    <p class="form-control-plaintext">{{ $contactMessage->subject }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status:</label>
                                    <p class="form-control-plaintext">
                                        @if($contactMessage->status === 'unread')
                                            <span class="badge bg-warning">Unread</span>
                                        @elseif($contactMessage->status === 'read')
                                            <span class="badge bg-info">Read</span>
                                        @else
                                            <span class="badge bg-success">Replied</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date Received:</label>
                                    <p class="form-control-plaintext">{{ $contactMessage->created_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Updated:</label>
                                    <p class="form-control-plaintext">{{ $contactMessage->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($contactMessage->read_at)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Read At:</label>
                                    <p class="form-control-plaintext">{{ $contactMessage->read_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($contactMessage->replied_at)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Replied At:</label>
                                    <p class="form-control-plaintext">{{ $contactMessage->replied_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Message:</label>
                            <div class="border rounded p-3 bg-light">
                                <p class="mb-0">{{ $contactMessage->message }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            @if($contactMessage->status === 'unread')
                                <button type="button" 
                                        class="btn btn-info mark-read-btn"
                                        data-message-id="{{ $contactMessage->id }}">
                                    <i class="ti ti-check"></i> Mark as Read
                                </button>
                            @endif
                            
                            @if($contactMessage->status !== 'replied')
                                <button type="button" 
                                        class="btn btn-success mark-replied-btn"
                                        data-message-id="{{ $contactMessage->id }}">
                                    <i class="ti ti-message-reply"></i> Mark as Replied
                                </button>
                            @endif

                            <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" 
                               class="btn btn-primary">
                                <i class="ti ti-mail"></i> Reply via Email
                            </a>

                            <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ti ti-trash"></i> Delete Message
                                </button>
                            </form>
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
    const markReadBtn = document.querySelector('.mark-read-btn');
    if (markReadBtn) {
        markReadBtn.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            
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
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking message as read');
            });
        });
    }

    // Mark as replied functionality
    const markRepliedBtn = document.querySelector('.mark-replied-btn');
    if (markRepliedBtn) {
        markRepliedBtn.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            
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
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error marking message as replied');
            });
        });
    }
});
</script>
@endsection 
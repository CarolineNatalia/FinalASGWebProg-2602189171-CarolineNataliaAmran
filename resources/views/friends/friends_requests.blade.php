@extends('layouts.app')
@section('title')
@endsection

@section('style')
    <style>
        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .top-0 {
            top: 0;
        }

        .start-100 {
            left: 100%;
        }

        .translate-middle {
            transform: translate(-50%, -50%);
        }

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .375rem;
        }

        .rounded-pill {
            border-radius: 50rem;
        }

        .bg-danger {
            background-color: #dc3545;
        }
    </style>
@endsection

@section('content')
    <div class="container py-3" style="overflow-y: scroll; height: 80vh;">
        <h1>Friend List</h1>
        <a href="{{route('chats.index')}}" class="btn btn-secondary">Friend List</a>
        @if ($friend_request->count() == 0)
            <p>There are no friend requests currently.</p>
        @else
            @foreach ($friend_requests as $item)
                <div class="card mt-2">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center">
                            <img src="{{ asset('profile/' . $item->picture) }}" alt="profile" class="rounded-circle"
                                width="200" height="200">
                            <div class="ms-3">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <h6 class="card-subtitle mb-1 text-muted">{{ Str::Title($item->gender) }}</h6>
                                <h6 class="card-subtitle mb-1 text-muted">{{ $item->email }}</h6>
                                <p class="card-text p-0 m-0 text-strong fw-bold">{{ $item->job }}</p>
                                @foreach ($item->fields as $temp)
                                    <span class="badge bg-primary">{{ $temp->name }}</span>
                                @endforeach
                            </div>
                        </div>

                        @php
                            // Check if there are unread messages from this friend
                            $unreadMessages = \App\Models\Chat::where('sender_id', $item->id)
                                ->where('receiver_id', auth()->user()->id)
                                ->where('seen', false)
                                ->count();
                        @endphp
                        <div class="d-flex align-items-center">
                            <a href="{{ route('chats.detail', ['id' => $item->id, 'locale' => app()->getLocale()]) }}"
                                class="position-relative">
                                <i class="bi bi-chat fs-3"></i> <!-- Regular chat icon -->
                                @if ($unreadMessages > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadMessages }}
                                    </span>
                                @endif
                            </a>
                            <form action="{{ route('remove_friend', ['locale' => app()->getLocale()]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="friend_id" value="{{ $item->id }}">
                                <button class="text-dark" style="background:none; border:none;">
                                    <i class="bi bi-hand-thumbs-up-fill fs-3 text-primary"></i>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('script')
@endsection

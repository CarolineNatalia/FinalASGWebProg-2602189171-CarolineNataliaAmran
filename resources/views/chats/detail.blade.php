@extends('layouts.app')

@section('title')
Chat
@endsection

@section('style')
    <style>
        .chat-bubble {
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            margin: 10px 0;
            /* Increase the margin here to add more space between chats */
            position: relative;
        }


        .chat-sender {
            background-color: white;
            border: 2px solid var(--bs-primary);
            color: var(--bs-primary);
            align-self: flex-end;
        }

        .chat-receiver {
            background-color: var(--bs-primary);
            border: 2px solid white;
            color: white;
            align-self: flex-start;
        }

        .chat-timestamp {
            font-size: 0.75rem;
            color: gray;
            position: absolute;
            bottom: -20px;
        }

        .chat-sender .chat-timestamp {
            right: 0;
        }

        .chat-receiver .chat-timestamp {
            left: 0;
        }

        .chat-date {
            text-align: center;
            color: gray;
            font-size: 0.85rem;
            margin: 10px 0;
        }

        .refresh-button {
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--bs-primary);
        }
    </style>
@endsection
@section('content')
    <div class="container py-3 d-flex flex-column" style="overflow-y: scroll; height: 80vh;">

        <a href="{{ route('chats.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary col-md-1">{{ __('chats_detail.back_button') }}</a>
        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('profile/' . $friend->picture) }}" alt="profile" class="rounded-circle" width="60" height="60">
                    &nbsp;&nbsp;
                    <p class="ml-3 mb-0">{{ $friend->name }}</p>
                </div>
                <i class="bi bi-arrow-clockwise refresh-button" onclick="refreshPage()" title="{{ __('chats_detail.refresh_tooltip') }}"></i>
            </div>
            <div class="card-body d-flex flex-column" style="overflow-y: scroll; height: 40vh;">
                @php
                    $lastDate = null;
                    $lastTimestamp = null;
                @endphp
                @foreach ($chats as $index => $chat)
                    @php
                        $currentDate = $chat->created_at->format('Y-m-d');
                        $currentTimestamp = $chat->created_at->format('H:i');
                        $nextChat = $chats[$index + 1] ?? null;
                        $nextTimestamp = $nextChat ? $nextChat->created_at->format('H:i') : null;
                    @endphp

                    @if ($lastDate !== $currentDate)
                        <div class="chat-date">{{ __('chats_detail.chat_date', ['date' => $chat->created_at->format('F j, Y')]) }}</div>
                        @php
                            $lastDate = $currentDate;
                        @endphp
                    @endif

                    @if ($chat->sender_id === auth()->user()->id)
                        <div class="chat-bubble chat-sender align-self-end">
                            {{ $chat->message }}
                            @if ($nextTimestamp !== $currentTimestamp)
                                <span class="chat-timestamp">{{ $currentTimestamp }}</span>
                            @endif
                        </div>
                    @else
                        <div class="chat-bubble chat-receiver align-self-start">
                            {{ $chat->message }}
                            @if ($nextTimestamp !== $currentTimestamp)
                                <span class="chat-timestamp">{{ $currentTimestamp }}</span>
                            @endif
                        </div>
                    @endif

                    @php
                        $lastTimestamp = $currentTimestamp;
                    @endphp
                @endforeach
            </div>
            <div class="card-footer">
                <form action="{{ route('chats.send', ['id' => $friend->id, 'locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" name="message" placeholder="{{ __('chats_detail.message_placeholder') }}">
                        <button class="btn btn-primary" type="submit">{{ __('chats_detail.send_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function refreshPage() {
            location.reload();
        }
    </script>
@endsection

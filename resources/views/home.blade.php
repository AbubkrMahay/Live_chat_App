@extends('layouts.app')
@vite('resources/js/app.js')

@section('content')


<div class="container-main">
    <div class="column first-column">
        <div>
            <h4>Your Groups</h4>
            <hr>
        </div>
        <div class="single_entity">
            @foreach ($allGroups as $group)
            {{-- Loop through each group and check if the logged-in user is a participant --}}
            @php
            $isParticipant = false;
            @endphp

            @foreach ($group->users as $user)
            @if ($user->id === auth()->id())
            {{-- If user is a participant in the group, mark the flag --}}
            @php
            $isParticipant = true;
            @endphp
            @endif
            @endforeach

            {{-- Show only the groups where the logged-in user is a participant --}}
            @if ($isParticipant)
            {{ $group->name }}
            <a href="{{ route('group.chat', $group->id) }}">
                <button type="button">Chat</button>
            </a>
            <hr>
            @endif
            @endforeach
        </div>


        <div>
            <h4>Your Friends</h4>
            <hr>
        </div>
        <div class="single_entity">
            @foreach ($friendUsers as $friend)
            {{ $friend->name }}
            <br>
            <a href="{{ route('home.show', $friend->id) }}">
                <button type="button">Message</button>
            </a>
            @endforeach
        </div>
    </div>
    <div class="column middle-column">
        <!-- Content for the middle column (60% width) -->
        <div>
            @if($groupName)
            <h4>{{ $groupName }}</h4>
            <hr>
            @elseif($frndname)
            <h4>{{ $frndname }}</h4>
            <hr>
            @else
            <h4>ChitChat</h4>
            <hr>

            @endif
        </div>
        <div id="messages">
            @foreach ($messages as $message)
            <p><strong>{{ $message->sender->name }}:</strong> {{ $message->content }}</p>
            @endforeach
        </div>
        <div class="form_sec">
            <input type="text" id="message-content" placeholder="Type your message here" style="width: 90%;">
            @if($frndname)
            <button id="send-button" onclick="sendMessage({{ $receiver_id }}, document.getElementById('message-content').value, null )">Send</button>
            @elseif($groupName)
            <button id="send-button" onclick="sendMessage(null, document.getElementById('message-content').value, {{$groupId}} )">Send</button>
            @else
            <button onclick="sendMessage(0, document.getElementById('message-content').value)">Send</button>
            @endif
        </div>
    </div>
    <div class="column last-column">
        <div>
            <h4>Requests</h4>

            <hr>
        </div>
        <div class="single_entity">
            @if(!empty($pendingRequests))
            @foreach ($pendingRequests as $request)
            {{ $request['user']->name }}
            <br>
            <div class="button_group">
                <form action="{{ route('connections.accept', $request['connection_id']) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Accept</button>
                </form>
                <form action="{{ route('connections.reject', $request['connection_id']) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Reject</button>
                </form>
            </div>
            @endforeach
            @else
            <p>No Request</p>
            @endif
        </div>
        <div>
            <hr>
            <h4>Suggestions</h4>
            <hr>
        </div>

        <div class="single_entity">
            @foreach ($allusers as $currentuser)
            @if($currentuser->id !== $user->id)
            @if(!in_array($currentuser, $friendUsers ))

            @if(!empty($pendingRequests))
            @foreach ($pendingRequests as $request)
            @if($currentuser->id !== $request['user']->id)

            {{ $currentuser->name }}
            <br>
            <div class="button_group">
                <form action="{{ route('connections.send', $currentuser->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Send Request</button>
                </form>
            </div>

            @endif
            @endforeach

            @else
            {{ $currentuser->name }}
            <br>
            <div class="button_group">
                <form action="{{ route('connections.send', $currentuser->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Send Request</button>
                </form>
            </div>
            @endif

            @endif
            @endif
            @endforeach



        </div>
        <div>
            <hr>
            <h4>New Groups</h4>
            <hr>
        </div>
        <div class="single_entity">
            @foreach ($allGroups as $group)
            {{-- Check if the logged-in user is not a participant --}}
            @if (!$group->users->contains(auth()->id()))
            {{ $group->name }}
            <form action="{{ route('group.join', $group->id) }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <button type="submit">Join</button>
            </form>
            @endif
            @endforeach
        </div>

    </div>
</div>

@endsection
@section('scripts')

<script>
    window.csrfToken = '{{ csrf_token() }}';
    window.receiverId = '{{ $receiver_id ?? 0 }}';
    window.groupId = '{{ $groupId ?? 0 }}';
</script>
<script src="{{ asset('js/home.js') }}"></script>
<script>
    window.userId = document.querySelector('meta[name="user-id"]').getAttribute('content');
</script>

@endsection
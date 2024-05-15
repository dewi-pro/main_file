<div class="favorite-list-item">
    <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
        style="background-image: url('{{ ($user->avatar)?Storage::url($user->avatar):asset('assets/img/avatar/avatar-1.png') }}');">
    </div>
    <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
</div>

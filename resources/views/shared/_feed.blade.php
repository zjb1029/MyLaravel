@if (count($list))
    <ol class="statuses">
        @foreach ($list as $status)
            @include('statuses._status', ['user' => $status->user])
        @endforeach
        {!! $list->render() !!}
    </ol>
@endif
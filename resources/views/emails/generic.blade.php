<x-mail::message>
# {{$subject}}

{{$content}}
@if($link)
<x-mail::button :url="$link->getUrl()">
    {{$link->getLabel()}}
</x-mail::button>
@endif
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

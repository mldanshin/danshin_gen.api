@if ($past->count() > 0)
*{{ __("events.past") }}*
@foreach ($past as $item)
{{ "    " }} {{ $item->name }} {{ $item->date }} [{{ $item->person }}]({{ $pathPerson . "/" . $item->personId }}) {{ $item->calculate }}
@endforeach
@endif
@if ($today->count() > 0)
*{{ __("events.today") }}*
@foreach ($today as $item)
{{ "    " }} {{ $item->name }} {{ $item->date }} [{{ $item->person }}]({{ $pathPerson . "/" . $item->personId }}) {{ $item->calculate }}
@endforeach
@endif
@if ($nearest->count() > 0)
*{{ __("events.nearest") }}*
@foreach ($nearest as $item)
{{ "    " }} {{ $item->name }} {{ $item->date }} [{{ $item->person }}]({{ $pathPerson . "/" . $item->personId }}) {{ $item->calculate }}
@endforeach
@endif

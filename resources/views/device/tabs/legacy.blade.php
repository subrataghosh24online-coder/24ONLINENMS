@extends('layouts.twentyfouronlinev1')

@section('content')
    <x-device.page :device="$device">
    {!! $tab_content !!}
    </x-device.page>
@endsection





@extends('errors::minimal')

@section('title', __('Страница не найдена'))
@section('code', '404')
@section('image')
<div style="background-image: url({{ asset('/svg/404.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
@section('message', __('Страница не найдена'))

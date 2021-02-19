@extends('emails.mail')
@section('content')
<h1 class="bg-grey-100 text-primary padding-10">
	Reestablecer contraseña
</h1>
<h2 class="text-dark text-justify">
	{{$user->firstname}} {{$user->lastname}} favor de hacer click en el boton a continuación para reestablecer su contraseña.
</h2>
<a href="{{$base_url.$token}}" class="btn-link bg-primary text-white box-shadow">
	Reestablecer
</a>

@endsection
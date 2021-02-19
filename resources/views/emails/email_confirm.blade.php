@extends('emails.mail')
@section('content')
<h1 class="bg-grey-100 text-primary padding-10">
	Confirme su correo electrónico
</h1>
<h2 class="text-dark text-justify">
	{{$user->firstname}} {{$user->lastname}} favor de hacer click en el boton a continuación para confirmar su correo electronico y concluir su registro exitosamente.
</h2>
<a href="#" class="btn-link bg-primary text-white box-shadow">
	Confirmar
</a>

@endsection
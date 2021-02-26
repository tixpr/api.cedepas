<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
		.page-break {
			page-break-after: always;
		}
		.page-break-after: always;
		html,
		body {
			width: 100%;
			height: 100%;
			padding: 0;
			margin: 0;
			font-family: Arial, sans-serif;
		}
		body{
			position: relative;
			background-image: url(sin_valor.png);
		}
		html{
			margin: 20px 20px 40px 40px;
		}
		.container {
			position: relative;
			width: 700px;
			margin: 0 auto;
			z-index: 200;
		}
		h1{
			margin: 5px;
			font-size: 1.5em;
			font-weight: 900;
		}
		p{
			font-size: 1rem;
			text-align: justify;
		}
		.text-bold{
			font-weight: 900;
		}
		.text-center{
			text-align: center;
		}
		.text-secundary{
			color: #616161;
		}
		img{
			position: absolute;
			top: 0;
		}
		table{
			border-collapse: collapse;
		}
		td {
			border: 1px solid #616161;
			padding: 2px 5px;
			font-size: 1rem;
		}
		span{
			display: block;
			padding: 5px 0;
		}
		.curso{
			width: 460px;
			min-width: 460px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1 class="text-center">
			CERTIFICADOS DE NOTAS
		</h1>
		<table>
			<tbody>
				<tr>
					<td colspan="4">
						<p>
							Certificamos que el estudiante <strong>{{$user->firstname.' '.$user->lastname}}</strong>, ha cumplido con los cursos del  programa <strong>BACHILLERATO EN TEOLOGIA Y BIBLIA</strong> que ofrece esta institucion y ha obtenido {{$total}}  créditos académicos. Las notas finales y créditos respectivos que consta en nuestros archivos son como siguen:
						</p>
					</td>
				</tr>
				<tr>
					<td class="text-center text-bold">
						COD
					</td>
					<td class="text-center text-bold curso">
						CURSO
					</td>
					<td class="text-center text-bold">
						CRÉDITOS
					</td>
					<td class="text-center text-bold">
						NOTA
					</td>
				</tr>
				@foreach($courses as $course)
					<tr>
						<td class="text-center text-bold">
							{{$course->code}}
						</td>
						<td class="text-bold curso">
							{{$course->name}}
						</td>
						<td class="text-center text-bold">
							{{$course->credits}}
						</td>
						<td class="text-center text-bold">
							{{$notes[$course->id]}}
						</td>
					</tr>
				@endforeach
				<tr>
					<td></td>
					<td class="text-center text-bold">
						Total de créditos
					</td>
					<td class="text-center text-bold">
						{{$total}}
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<span class="text-center text-secundary">
			Huancayo, {{$hoy->day}} de {{$meses[$hoy->month-1]}} de {{$hoy->year}}
		</span>
	</div>
	<script type="text/php">
		if ( isset($pdf) ) {
			$pdf->page_script('
				$font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
				$pdf->text(500, 800, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
			');
		}
	</script>
</body>
</html>
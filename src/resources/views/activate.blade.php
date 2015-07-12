@extends('layout')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Gracias por activar tú cuenta</div>
				<div class="panel-body">
					Ahora podras iniciar sesión en devsninja. Si no eres redirigido
                    da click <a href="/login">aquí</a>.
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function redireccionar() {
        window.location = "/login";
    }
    setTimeout("redireccionar()", 5000);
</script>
@endsection

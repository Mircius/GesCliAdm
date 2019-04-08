@extends('home')

@section('breadcrumbs')
	{{ Breadcrumbs::render('venta',$venta->Id_Cliente,$venta) }}
@stop

@section('content')

<div class="sale">
	<div class="sale-in">
			<h1>Información:</h1>
		</div>
		<div class="sale-tabs">
			<h1>Archivos:</h1>
		</div>
	</div>

<style>
	.btn-file {
		line-height: 2.15;
		position: absolute;
		overflow: hidden;
		right: 0;
		top: 0;
		border-radius: 0px;
	}
	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		opacity: 0;
		cursor: inherit;
		display: block;
	}

	th{
		position: relative !important;
		border-bottom: 0;
		text-align: left !important;
	}
	table{
		margin: 10px;
	}

	th span{
		width: 150px;
	}
	
	h1{
		text-align: left;
	}

	.sale{
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	tr:first-child:hover{
		background-color: initial;
		color: inherit;
		cursor: context-menu;
	}

	thead th{
		text-align: center !important;
	}

	tr td{
		position: relative;
	}

	.modify{
		right: 6px !important;
    	top: -4px;
	}

</style>
	
	<script>
		$(document).on('change', '.btn-file.add :file', function() {
			var file = $(this).prop('files')[0];
			var id = {{ $venta->id }};
			if(checkFileType(file)){
				fileActionForm($(this),"/uploadFile/",id);	
			}
		});

		$(document).on('change', '.btn-file.modify :file', function() {
			
			var file = $(this).prop('files')[0];
			var idArchivo = $(this).parent().parent().parent().attr("id");
			if(checkFileType(file)){
				fileActionForm($(this),"/modify/",idArchivo);	
			}
		});

		var Datos = {!! json_encode($venta->toArray(), JSON_HEX_TAG) !!};
		var Ventas=[];
		Ventas.push(Datos);
		var archivos = {!! json_encode($archivos->toArray(), JSON_HEX_TAG) !!};
		CreateTable(".sale-in",Ventas,undefined);
		var tab=CreateElement(".sale-tabs","Table",undefined,undefined);	
		SimpleTable(tab, "Factura", {id:"Table_Fac"},archivos);
		SimpleTable(tab,"Albaran",{id:"Table_Alb"},archivos);
		SimpleTable(tab,"Presupuesto",{id:"Table_Pre"},archivos);
		SimpleTable(tab,"Pedido Pro.",{id:"Table_Pro"},archivos);
		SimpleTable(tab,"Pedido Cli.",{id:"Table_Cli"},archivos);

		$("[name='downDoc']").click(function(){
			var idArchivo = $(this).parent().parent().attr("id");
			downloadFile(idArchivo);
		})
		
		//Función que convierte los estados de las ventas en un icono más agradable para la vista
		estadoVentas();
	</script>
@stop
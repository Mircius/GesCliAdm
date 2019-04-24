@extends('home')

@section('breadcrumbs')
    <a href="/">{{ Breadcrumbs::render('clientes') }}</a>
@stop

@section('content')
    <div class="content">
        
        <div class="topContainer">
            <div class="top-title">
                Listado de Clientes:
            </div> 
            <div class="addUserIcon">
                <a href="#costumModal10" data-toggle="modal">
                    <button class="btn btn-primary">Añadir Cliente</button>
                </a>
            </div>
            
        </div>
    </div>
    
    <div id="ClientsTable"></div>
     <div id="links">
        {{$clientes->links()}}
    </div>
    <script>
    
        $(document).ready(function (){
            ajaxClientes();
        
            
            $("a.page-link").click(function(){ visualizarClientes(this, event);return false;})
              
            

            $("#btn-save").click(function(){ crearCliente(event);return false;})
            });
            
        

     
        function crearCliente(e){
            e.preventDefault();
            
            $.ajax({
                url: "/api/clientes",
                method: "POST",
                data: {
                    nombre: $("#nombre").val(),
                    direccion: $("#direccion").val(),
                    provincia: $("#provincia").val(),
                    localidad: $("#localidad").val(),
                    cifNif: $("#cifNif").val(),
                    email: $("#email").val(),
                    telefono: $("#telefono").val(),
                    cp: $("#cp").val()
                }
            })
            .done(function(clientes){ 
                $("table").remove();
                $('#costumModal10').modal('hide');

                CreateTable("#ClientsTable",clientes.cliente.data);

                        // createFilter('#ClientsTable table thead',"/","clientes","table");
        
                $('.clickable').each(function(){
                    $(this).attr("data-href","/clients/"+$(this).attr("id"));
                })

                $('.clickable').click(function(){
                    window.location=$(this).data('href');
                });

                $('input[name="filtro"]').val('{{$filtro}}');
                    return true;
                })
            .fail(function(jqXHR,textStatus){
                console.log("fail: "+textStatus);
            });
        }

        
        // var clientes = {!! json_encode($clientes->toArray(), JSON_HEX_TAG) !!} ;

        // console.log(clientes)

        // CreateTable("#ClientsTable",clientes.data,undefined);

        // createFilter('#ClientsTable table thead',"/","clientes","table");
        
       // $('.clickable').each(function(){
       //      $(this).attr("data-href","/clients/"+$(this).attr("id"));
       // })

       // $('.clickable').click(function(){
       //      window.location=$(this).data('href');
       // });

       //  $('input[name="filtro"]').val('{{$filtro}}');




       //NILL

       //   var clientes = {!! json_encode($clientes,JSON_HEX_TAG) !!};
       //  //console.log(clientes)
       //  CreateTable("#ClientsTable",clientes.data,undefined);
       //  //console.log(clientes);
       //  //CreateLinkPag(clientes);
       //  createFilter('#ClientsTable table thead',"/","clientes","table");
        
       // $('.clickable').each(function(){
       //      $(this).attr("data-href","/clients/"+$(this).attr("id"));
       // })
       // $('.clickable').click(function(){
       //      window.location=$(this).data('href');
       // });
       //  $('input[name="filtro"]').val('');
       //  ajaxClientes("1");
       //  $(document).ready(function(){
       //      $(".pagination a").on('click',function(e){
       //          e.preventDefault();
       //          ajaxClientes($(this).attr('href'));
       //      });
       //  });
    </script>
@stop

@section('modal')
    <div id="costumModal10" class="modal" data-easein="bounceIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title">
                            Añadir un nuevo cliente
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="modal-form">
                        <form id="form" action="{{ action('ClientsController@create') }}" method="POST">
                            @csrf
                            <label for="nombre">Nombre: <input type="text" id="nombre" name="nombre" class="input"></label>
                            <label for="direccion">Dirección: <input type="text" id="direccion" name="direccion" class="input"></label>
                            <label for="provincia">Provincia: <input type="text" id="provincia" name="provincia" class="input"></label>
                            <label for="localidad">Localidad: <input type="text" id="localidad" name="localidad" class="input"></label>
                            <label for="cif/nif">CIF/NIF: <input type="text" id="cifNif" name="cif/nif" class="input"></label>
                            <label for="email">E-Mail: <input type="text" id="email" name="email" class="input"></label>
                            <label for="telefono">Teléfono: <input type="text" id="telefono" name="telefono" class="input"></label>
                            <label for="cp">Código Postal: <input type="text" id="cp" name="cp" class="input"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                            Close
                        </button>
                        <button class="btn btn-primary" id="btn-save">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   

@stop



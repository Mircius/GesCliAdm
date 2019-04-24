/**
 * 
 * @param {*} parent Elemento padre donde se introducirá el form (usualmente debería ser una lista o un div)
 * @param {*} data Array que incluirá un objeto en formato JSON en su interior
 * @param {*} params Objeto con elementos clave valor, por ejemplo: {class:'container',name:'elemento1'}
 */
function CreateTable(parent,data,params){
    var TableReturn = filterData(data);
    var Keys = TableReturn[0];
    var Values = TableReturn[1];
    var Table = CreateElement(parent,"table",undefined,undefined);
    var Thead = CreateElement(Table,"thead",undefined,undefined);
    var Tbody = CreateElement(Table,"tbody",undefined,undefined);
    var TRhead;
    var control=false;

    Keys.forEach(function(element){
        if(control===false){
            TRhead=CreateElement(Thead,"tr",undefined,undefined);
            control=true;
        }else{
            CreateElement(TRhead,"th",element,{name:element}); 
        }
    });

    Values.forEach(function(items){
        var TRbody;
        var control=false;
        items.forEach(function(item){
            if(control===false){
                TRbody=CreateElement(Tbody,"tr",undefined,{"class":"clickable","id":item});
                control=true;
            }else{
            CreateElement(TRbody,"td",item,undefined); 
            }
        });
    });
}
/**
 * 
 * @param {*} parent "Elemento al que se añadirá la tabla"
 * @param {*} text "Título que recibirá el elemento"
 * @param {*} attr "Elemento de tipo objeto que contiene los posibles atributos que se quieran añadir"
 * @param {*} data "Elemento que debe tener un array con uno o más objetos de tipo JSON"
 */
function SimpleTable(parent,text,attr,data){
    var Split=SplitData(data,text);
    var Tr=CreateElement(parent,"tr");
    var Th = CreateElement(Tr,"th",text,{colspan:4});
    var Span = CreateElement(Th,"span","Añadir "+text, {class:"file-input btn btn-primary btn-file add"});
    CreateElement(Span,"input",undefined,{"type":"file",class:"fileInput","name":"archivo","tipo":text});

    Split.forEach(function(elements){
        var NewTr=CreateElement(parent,"tr");
        for(element in elements){
            var id;
            if(element === "id"){
                NewTr.attr({id:elements[element]});
            }else if(element === "Tipo"){
            }else if( element == "Archivo"){
                NewTr.attr({"archivo":elements[element]});
            }else{
                CreateElement(NewTr,"td",elements[element],{id:id});
            }
        }
        var IconsTD = CreateElement(NewTr,"td");
        
        var showDocument = CreateElement(IconsTD,"i",undefined,{class:"fas fa-search-plus fileIcon",'title':'Ver','name':"verDoc"});
        var url = '/storage/' + elements.Archivo;
        showDocument.click(function(){ 
            window.open(url,'blank');
        });

        var modifyIcon = CreateElement(IconsTD,"i",undefined,{class:"fas fa-edit btn-file modify fileIcon",'title':'Modificar','name':"editDoc"});
        CreateElement(modifyIcon,"input",undefined,{"type":"file",class:"modifyInput","name":"archivo","tipo":text});

        CreateElement(IconsTD,"i",undefined,{class:"fas fa-file-download fileIcon",'title':'Descargar','name':"downDoc"});
    });
}


function SplitData(data,type){
    var SplitArray=[];
    data.forEach(function(items){

        if(items.Tipo.toLowerCase()===type.toLowerCase()){
            SplitArray.push(items);
        }

    })
    return SplitArray;
}

/**
 * 
 * @param {*} parent Elemento al que añadiremos el componente que vamos a crear. Se debe pasar una string con un formato parecido a: '#id','.class',etc...
 * @param {*} element String que contiene el tipo de elemento que deseamos crear: 'div','p','button','form',etc...
 * @param {*} text String con un texto que se printará en el elemento creado.
 * @param {*} params Objeto en formato JSON que contendrá los diversos atributos que dseamos que tenga el componente (class:'clase',name:'nombre',etc...)
 */
function CreateElement(parent,element,text,params){
    if(params===undefined || params === null){
        params={};
    }
    var element=$('<'+element+'>')
            .attr(params)
            .text(text)
            .appendTo(parent);
    return element;
}

//Función que recibe un array y devuelve uno nuevo con los elementos únicos. Si se repiten elimina los repetidos para dejar uno solo.
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}

//Función que recibe un JSON y lo convierte en dos arrays, uno que contiene las keys y otro que contiene los valores
function filterData(result){
    //var result = result.data;
    var keys = [];
    var values = [];
        result.forEach(function(items){
            var list = [];
            for(item in items){
                keys.push(item);
                list.push(items[item]);
            };
            values.push(list);
            
        });

    keys = keys.filter(onlyUnique); 
    return [keys,values];
}

/**
 * 
 * @param {*} parent Elemento padre donde se introducirá el form (usualmente debería ser una lista o un div)
 * @param {*} data Array que incluirá un objeto en formato JSON en su interior
 * @param {*} params Objeto con elementos clave valor, por ejemplo: {class:'container',name:'elemento1'}
 */
function CreateForm(parent,data,params){
    console.log(data);
    var form=CreateElement(parent,"form",undefined,{id:"form"});
    var csrfVar = $('meta[name="csrf-token"]').attr('content');
    form.append("<input name='_token' value='" + csrfVar + "' type='hidden'>");
    form.append('<input type="hidden" name="_method" value="PUT">');
    data.forEach(function(elements){
        for(item in elements){
            if(item==="id"){
                form.attr({"method":"post","action":"{{ action('ClientsController@edit') }}"});

            }else if(item==="cif/nif"){
                var label=CreateElement(form,"label",item,undefined);
                CreateElement(form,"input",undefined,{'value':elements[item],name:item, id:'cifNif','required':true});
            }else{
                var label=CreateElement(form,"label",item,undefined);
                CreateElement(form,"input",undefined,{'value':elements[item],name:item, id:item,'required':true});
            }
        }
        CreateElement(form,"button","Modificar Cliente",{class:"btn btn-primary saveClient"});
        CreateElement(form, 'span').attr('id', 'info');
    })

}


//AJAX TEST

var AjUrl = "/api/clientes";
function links(){
    $('.clickable').each(function(){
        $(this).attr("data-href","/clients/"+$(this).attr("id"));
   })

   $('.clickable').click(function(){
        window.location=$(this).data('href');
   });
}
function CLiSpan(par,txt,attr){
    //asignar valores pasados por paramentro para crear los elementos
    var li = $('<li>').attr(attr.li).appendTo(par);
    $('<span>').attr(attr.span).text(txt).appendTo(li);
}
function CLiLink(par,txt,attr){
    //asignar valores pasados por paramentro para crear los elementos
    var li = $('<li>').attr(attr.li).appendTo(par);
    var a = $('<a>').attr(attr.a).text(txt).appendTo(li);
}

function CreateLinkPag(data) {
    $("#links").empty();
    var ul = $("<ul>").attr({'class':'pagination','role':'navigation'}).appendTo("#links");
    //pagia 1 
    if(data.current_page==1){
        //primera pagina elemento con span
        CLiSpan(ul,'‹',{'li':{'class':'page-item disabled','aria-disabled':'true','aria-label':'« Previous'},
        'span':{'class':'page-link','aria-label':'« Previous'}},data)
    //pagina diferentea a 1 elementos con link
    }else{
        let previousPage = data.current_page - 1;
        CLiLink(ul,'‹',{'li':{'class':'page-item'},
        'a':{'href':previousPage,'class':'page-link'}},data)

    }
    //Elementos/numeros
    for (var i = 1; i <= data.last_page; i++) {
        if(data.current_page == i){
            CLiSpan(ul,i,{li:{'class':'page-item active'},
            span:{'class':'page-link'}},data)
        }else{    
            CLiLink(ul,i,{li:{'class':'page-item'},
            a:{'href':i ,'class':'page-link'}},data)
        }
    }
    //pagina final
    if(data.current_page == data.last_page){
        CLiSpan(ul,'›',{li:{'class':'page-item disabled'},span:{'class':'page-link'}},data)
    }else{
        let nextPage = data.current_page + 1;
        CLiLink(ul,'›',{li:{'class':'page-item'},
        a:{'href':nextPage,'class':'page-link'}},data)
    }
}
function ajaxClientes(page){
var filtroVal = $('input[type=text][name=filtro]').val();

$.ajax({
        url:AjUrl,
        data: {
            page:page,
            filtro:filtroVal
        },
        
        
    })
    .done(function(res){
        $('#ClientsTable').empty();
        CreateTable("#ClientsTable",res.data); //crear tabla nuevo contenido
        createFilter('#ClientsTable table thead',"/api/","clientes","table");
        links();// links de los elementos de la tabla
        CreateLinkPag(res);// links paginacion
        console.log(res);
        $(document).ready(function(){
            $(".pagination a").on('click',function(e){
                e.preventDefault();
                ajaxClientes($(this).attr('href'));

            });
            $("input[type=submit]").on('click',function(ev){
                        ev.preventDefault();
                        ajaxClientes("1");

            });
        });
        $('input[type=text][name=filtro]').val(filtroVal);

    })
    .fail(function(jqXHR,textStatus){
        console.log("fail: "+textStatus);
    });

}
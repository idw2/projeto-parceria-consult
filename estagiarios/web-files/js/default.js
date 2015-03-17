$(document).ready(function() {

    if (document.getElementById("pesquisar_endereco") != null) {
        $('#pesquisar_endereco').click(function() {
            get_endereco();
        });

        $('#cep').keyup(function() {
            get_endereco();
        });
    }
    
    if (document.getElementById("cpf_cnpj_radio") != null) {
        $("input[id=cpf_cnpj_radio]").each(function(){
            $(this).click(function() {
                if( $(".showCNPJ").hasClass("hide") ){
                    $(".showCNPJ").removeClass("hide");
                    $(".showCPF").addClass("hide");
                } else {
                    $(".showCNPJ").addClass("hide");
                    $(".showCPF").removeClass("hide");
                }
           });
        });
    }
    
    if (document.getElementById("id") != null) {
//        $("#id").keyup(function(){
//            var valor = $("#id").val();
//            $("#id").val(valor.toUpperCase());
//        });
        
        document.getElementById("id").value = "";
        document.getElementById("senha").value = "";
        document.getElementById("cpf").value = "";
        document.getElementById("cnpj").value = "";
    }



});

function get_endereco() {
    var cep = $("#cep").val();

    $(".Loader").removeClass('hide');
    $.ajax({
        type: 'get',
        data: "cep=" + cep,
        url: '/pt/ajax/consultar-cep',
        success: function(data) {
            $(".Loader").addClass('hide');
            $("#logradouro").val(data["Logradouro"]);
            $("#bairro").val(data["Bairro"]);
            $("#cidade").val(data["Cidade"]);
            $("#estado").val(data["UF"]);
        }
    });
}

function datagrid_less() {

    var n = 0;
    $("#data .datagrid").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) - 1);

    if (qntdd > -1) {
        $("#data .datagrid:last").remove();
    }

}

function datagrid_plus() {

    var n = 0;
    $("#data .datagrid").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) + 1);

    var str = "<div class='row datagrid'><br/>"
            + "<div class='col col-sm-2'>"
            + "<input type='text' class='form-control' id='ddd_" + qntdd + "' name='ddd_" + qntdd + "' maxlength='4' value='' placeholder='DDD' onkeypress='return formataNumDV(event, this, 2);'/>"
            + "</div>"
            + "<div class='col col-sm-3'>"
            + "<input type='text' class='form-control' id='tel_" + qntdd + "' name='tel_" + qntdd + "' maxlength='10' value='' placeholder='Telefone ou celular' onkeypress='return formataNumDV(event, this, 9);'/>"
            + "</div>"
            + "<div class='col col-sm-7'>"
            + "<input type='text' class='form-control' id='ramal_" + qntdd + "' name='ramal_" + qntdd + "' maxlength='100' value='' placeholder='Informações adicionais'/>    "
            + "</div>"
            + "</div>";

    $("#data").append(str);
}

function datagrid_idioma_less() {

    var n = 0;
    $("#data_idioma .datagrid_idioma").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) - 1);

    if (qntdd > -1) {
        $("#data_idioma .datagrid_idioma:last").remove();
    }

}

function datagrid_idioma_plus() {

    var n = 0;
    $("#data_idioma .datagrid_idioma").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) + 1);

    var str = "<div class='row datagrid_idioma'><br/>"
            + "<div class='col col-sm-5'>"
            + "<input type='text' class='form-control' id='idioma_" + qntdd + "' name='idioma_" + qntdd + "' maxlength='70' value='' placeholder='Qual idioma?'/>"
            + "</div>"
            + " <div class='col col-sm-7'></div>"
            + "</div>";

    $("#data_idioma").append(str);
}

function datagrid_informatica_less() {

    var n = 0;
    $("#data_informatica .datagrid_informatica").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) - 1);

    if (qntdd > -1) {
        $("#data_informatica .datagrid_informatica:last").remove();
    }

}

function datagrid_informatica_plus() {

    var n = 0;
    $("#data_informatica .datagrid_informatica").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) + 1);

    var str = "<div class='row datagrid_informatica'>"
            + "<br/>"
            + "<div class='col col-sm-12'>"
            + "<input type='text' class='form-control' id='informatica_" + qntdd + "' name='informatica_" + qntdd + "' maxlength='255' value='' placeholder='Escreva aqui as noções de informática que deseja'/>"
            + "</div>"
            + "</div>";
    
    $("#data_informatica").append(str);
}


function datagrid_curso_less() {

    var n = 0;
    $("#data_curso .datagrid_curso").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) - 1);

    if (qntdd > -1) {
        $("#data_curso .datagrid_curso:last").remove();
    }

}

function datagrid_curso_plus() {

    var n = 0;
    $("#data_curso .datagrid_curso").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) + 1);

    var str = "<div class='row datagrid_curso'>"
            + "<br/><div class='col col-sm-7'>"
            + "<input type='text' class='form-control' id='curso_" + qntdd + "' name='curso_" + qntdd + "' maxlength='255' value='' placeholder='Nome do curso'/>"
            + "</div>"
            + "<div class='col col-sm-2'>"
            + "<input type='text' class='form-control' id='periodo_" + qntdd + "' name='periodo_" + qntdd + "' maxlength='2' value='' placeholder='Período' onkeypress='return formataNumDV(event, this, 2);'/>"
            + "</div>"
            + "<div class='col col-sm-3'>"
            //+ "<strong>Nível: </strong> "
            + "<input type='radio' class='form-control-static' name='nivel_" + qntdd + "' value='2º Grau' id='nivel_" + qntdd + "' checked='true'/> 2º Grau"
            + "&nbsp;<input type='radio' class='form-control-static' name='nivel_" + qntdd + "' value='Superior' id='nivel_" + qntdd + "' /> Superior"
            + "</div>"
            + "</div>";
    
    $("#data_curso").append(str);
}


function datagrid_beneficios_less() {

    var n = 0;
    $("#data_beneficios_dg .datagrid_beneficios_dg").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) - 1);

    if (qntdd > -1) {
        $("#data_beneficios_dg .datagrid_beneficios_dg:last").remove();
    }

}

function datagrid_beneficios_plus() {

    var n = 0;
    $("#data_beneficios_dg .datagrid_beneficios_dg").each(function(i) {
        n = i;
    });
    var qntdd = (parseInt(n) + 1);
    
    var str = "<div class='row datagrid_beneficios_dg'>"
            + "<br/>"
            + "<div class='col col-sm-12'>"
            + "<input type='text' class='form-control' id='beneficios_" + qntdd + "' name='beneficios_" + qntdd + "' maxlength='255' value='' placeholder='Adicionar benefícios'/>"
            + "</div>"
            + "</div>";

    $("#data_beneficios_dg").append(str);
}

function open_language(teste){
    if( teste == "1" ){
        $(".open-language").addClass("hide");
    } else {
        $(".open-language").removeClass("hide");
    }
}

function open_info(teste){
    if( teste == "1" ){
        $(".open-informatica").addClass("hide");
    } else {
        $(".open-informatica").removeClass("hide");
    }
}

function trash(url) {
    if (confirm('ATENÇÃO: Esta ação não poderá ser desfeita!\n Deseja continuar?')) {
        window.location = url;
        return true;
    } else {
        return false;
    }
}

function get_administradores(codempresa){
    var codigo = codempresa;
    $.ajax({
        type: 'get',
        data: "codempresa=" + codigo,
        url: '/pt/ajax/get-administradores',
        success: function(data) {
            $("#select_administradores").html(data);
        }
    });
    
}

function open_list_estagiarios(codempresa){    
    var codigo = codempresa;
    
    var classe = "arrow_lista_" + codigo;
    var hidden = "hide_" + codigo;
    var lista = "lista_" + codigo;
    
    $.ajax({
        type: 'get',
        data: "codempresa=" + codigo,
        url: '/pt/ajax/get-nom-estagiarios',
        success: function(data) {
            
            ($("."+classe).attr("src") == "/web-files/img/arrow-down-01-32.png") ? $("."+classe).attr({"src":"/web-files/img/arrow-right-01-32.png"}) : $("."+classe).attr({"src":"/web-files/img/arrow-down-01-32.png"});   
            ($("."+hidden).hasClass("hide")) ? $("."+hidden).removeClass("hide"): $("."+hidden).addClass("hide");
            $("."+lista).html(data);
        }
    });
}

//<tr>
//    <td colspan="3"><img style="cursor: pointer" onclick="javascript:open_list_estagiarios('<?php echo $empresa->CODCADASTRO; ?>');" class="arrow_lista_<?php echo $empresa->CODCADASTRO; ?>" src="/web-files/img/arrow-right-01-32.png" border="0" alt="Lista de Estagiários" title="Lista de Estagiários"></td>
//</tr>
//<tr class="hide hide_<?php echo $empresa->CODCADASTRO; ?>">
//    <td colspan="3" class="lista_<?php echo $empresa->CODCADASTRO; ?>"></td>
//</tr>
$(document).ready(function(){
	$('.submit-on-change').change(function(){
		
		var form = $(this).data('form-name');
		var field = $(this).data('field-name');
		var val = $(this).val();

		var form_obj = $("#"+form);
		var field_obj = $("#"+form+" input[name='"+field+"']");
		
		field_obj.val(val);
		form_obj.submit();

	});

	// BUSCA AVANÇADA

	// div condições
	var $div_condicoes = $("#divTermosDePesquisa");

	// botão de remover condição
	$(document).on('click', '#divTermosDePesquisa span a', function(e) { 
		e.preventDefault();

		// remove item
		$(this).closest("span").html('');
	});

	// click de termos
	$("#divTermo a").click(function(e){
		e.preventDefault();
		$("#spanEmpty").hide();

		var div = $(this).closest('div');
		var input = div.find('input');
		var select = div.find('select option:selected');

		// so vai se tiver sido preenchido
		if(input.val()) {

			var item = "<span class='badge badge-default'>";
			var item = item + "Termo: "+select.text()+" \""+input.val()+"\" <a href='#'>x</a>";
			var item = item + "<input type='hidden' name='"+select.val()+"[]' value='"+input.val()+"'>";
			var item = item + "</span>";

			// adicionar 
			$div_condicoes.append(item);

			// esvazia a caixa
			input.val('');
		}
	});

	// click do periodo
	$("#divPeriodo a").click(function(e){
		e.preventDefault();
		$("#spanEmpty").hide();

		var div = $(this).closest('div');
		var from_year = div.find('input[name="from_year"]');
		var from_month = div.find('select[name="from_month"] option:selected');
		var to_year = div.find('input[name="to_year"]');
		var to_month = div.find('select[name="to_month"] option:selected');

		// se tudo tiver sido preenchido
		if(from_year.val() && from_month.val() && to_year.val() && to_month.val()) {
			var from = parseInt(from_year.val() + from_month.val());
			var to = parseInt(to_year.val() + to_month.val());

			// se a data inicio for maior que a data fim
			if(from < to) {
				var item = "<span class='badge badge-default'>";
				var item = item + "Período: "+from_month.text()+"/"+from_year.val()+" até "+to_month.text()+"/"+to_year.val()+" <a href='#'>x</a>";
				var item = item + "<input type='hidden' name='periodo[]' value='"+from+"-"+to+"'>";
				var item = item + "</span>";

				// appenda
				$div_condicoes.append(item);
			}
		}
	});
	
	// capturar o enter do inputSearchTema
	$('#inputSearchTema').keypress(function (e) {
		if (e.which == 13) {
			e.preventDefault();
			$("#submitTemaSearch").trigger('click');
		}
	});

	// busca de temas
	$("#imgTemaLoading").hide();
	$("#submitTemaSearch").click(function(e){
		e.preventDefault();
		$("#imgTemaLoading").show();
		$("#divTemasBuscados").html($("#spanTemaEmpty"));
			
		var input = $("#inputSearchTema");

		if(input.val()) {

			$.post( "", { ajax: true, tema: input.val() }, function(data){


				if(data.length > 0) {
					
					$("#spanTemaEmpty").hide();
					
					for(tema in data) {
						tema = data[tema];
						console.log(tema);

						var item = "<span class='badge badge-default'>";
						var item = item + "Tema: "+tema.name+" <a href='#'>+</a>";
						var item = item + "<input type='hidden' name='tema[]' value='"+tema.term_id+"'>";
						var item = item + "</span>";

						$("#divTemasBuscados").append(item);
					}					
				} else {
					$("#spanTemaEmpty").show();
				}

				$("#imgTemaLoading").hide();
			}, "json");

		}
	});
	
	// click de Temas
	$(document).on('click', '#divTemasBuscados a', function(e) { 
		e.preventDefault();
		$("#spanEmpty").hide();

		// pegando o item
		var item = $(this).closest("span");
		var clone_item = $(this).closest("span").clone();
		
		// trocando o simbolo de click
		clone_item.find('a').html('x');
		
		// adicionar clone
		$div_condicoes.append(clone_item);

		// apaga o item que foi utilizado
		item.hide();
		
	});
});
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
	});
const selectElement2 = document.querySelector('#id');

const selectElement = document.querySelector('#id_colore');
selectElement.addEventListener('change', (event) => {
	data($("#id_colore").val());
})


function data(x) {
	$.ajax({
		type: "POST",
		url: "../../config/link/richiesta-articolo?request=richiesta",
		data: "&id=" + $("#id").val() + "&id_colore=" + $("#id_colore").val(),
		success: function(result){
			if(x==""){
				$("#articolo").html("");				
			}else{
				$("#articolo").html(result);		
			}
		}
	});
}
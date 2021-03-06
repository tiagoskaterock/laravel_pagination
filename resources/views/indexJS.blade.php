<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="crsf-token" content="{{ csrf_token() }}">
	<title>Pagination</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>



<body>

	<div class="container text-center mt-5">
		
		<div class="text-center card">



			<div class="card-header">

				<h5>
					Paginação com CSS, BootStrap, PHP, Laravel, JavaScript, jQuery, Ajax e MySQL
				</h5>

			</div>



			<div class="card-body">

				<div class="card-title" id="card-title">
					<h5>Exibindo 69 de um total de 6969 clientes</h5><br>	
					<h6>69 a 96</h6>				
				</div>

				<div class="table-responsive">
				  <table class="table table-bordered table-striped tabel-hover" id="tabela-clientes" width="100%" cellspacing="0">
				
				    <thead class="bg-light">
				      <tr>
				        <th>ID</th>				        				
				        <th>Nome</th>
				        <th>Sobrenome</th>
				        <th>Email</th>				        
				      </tr>
				    </thead>
				
				    <tbody>		

				      <tr>
				        <td>1</td>						
				        <td>Marcos</td>
				        <td>Santos</td>				
				        <td>marquinho@gmail.com</td>											          				   
				      </tr>				    	
				
				    </tbody>
				
				  </table>
				
				</div>
						
			</div>




			<div class="card-footer" style="display: flex; align-content: center; align-items: center;">
				
				<nav id="paginator">
				  <ul class="pagination" style="margin: 0 auto">

				  	{{--
				    <li class="page-item disabled">
				      <a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a>
				    </li>
				    <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
				    <li class="page-item active">
				      <a class="page-link" href="javascript:void(0)">2</a>
				    </li>
				    <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
				    <li class="page-item">
				      <a class="page-link" href="javascript:void(0)">Next</a>
				    </li>
				    --}}
				  </ul>
				</nav>



			</div>



		</div>

	</div>




	<script src="{{ asset('js/app.js') }}"></script>

	{{-- AJAX DA PAGINAÇÃO --}}
	<script>

		function getItemProximo(data) {
			i = data.current_page + 1;
			if (data.last_page == data.current_page) {
				s = '<li class="page-item disabled"><a class="page-link" pagina="' + i + '" href="javascript:void(0)">Anterior</a></li>';
			}
			else {
				s = '<li class="page-item"><a class="page-link" pagina="' + i + '" href="javascript:void(0)">Próximo</a></li>';
			}
			return s;
		}

		function getItemAnterior(data) {
			i = data.current_page - 1;
			if (1 == data.current_page) {
				s = '<li class="page-item disabled"><a class="page-link" pagina="' + i + '" href="javascript:void(0)">Anterior</a></li>';
			}
			else {
				s = '<li class="page-item"><a class="page-link" pagina="' + i + '" href="javascript:void(0)">Anterior</a></li>';
			}
			return s;
		}

		function getItem(data, i) {
			if (i == data.current_page) {
				s = '<li class="page-item active"><a class="page-link" pagina="' + i + '" href="javascript:void(0)">' + i + '</a></li>';
			}
			else {
				s = '<li class="page-item"><a class="page-link" pagina="' + i + '" href="javascript:void(0)">' + i + '</a></li>';
			}
			return s;
		}

		function montarPaginator(data) {
			$("#paginator>ul>li").remove();
			$("#paginator>ul").append(getItemAnterior(data));

			// número de páginas mostradas na paginação
			n = 10;

			if (data.current_page - n/2 <= 1) {
				inicio = 1;
				// onsole.log('primeiro');
			}
			
			else if (data.last_page - data.current_page < n) {
				inicio = data.last_page - n + 1;
				console.log('segundo');		
			}

			/*
			else if (data.last_page - data.current_page < n) {
				inicio = data.last_page - n + 1;
				// console.log('segundo');		
			}
			*/

			else {
				inicio = data.current_page - n / 2;
				// console.log('terceiro');			
			}

			/*
			console.log('current: ' + data.current_page);							
			console.log('last: ' + data.last_page);							
			console.log('n: ' + n);	
			console.log('calculo: ' + (data.current_page - n/5));	
			*/


			fim = inicio + n - 1;

			for (var i = inicio; i <= fim; i++) {
				s = getItem(data, i);
				$("#paginator>ul").append(s);
			}
			$("#paginator>ul").append(getItemProximo(data));
		}

		function montarLinha(cliente) {
			return "" +
			 "<tr>" +
			  "<td>" + cliente.id + "</td>" +								  											          				  
			  "<td>" + cliente.nome + "</td>" +								  											          				  
			  "<td>" + cliente.sobrenome + "</td>" +								  											          				  
			  "<td>" + cliente.email + "</td>" +								  											          				  
			"</tr>";
		}

		function montarTabela(data) {
			$('#tabela-clientes>tbody>tr').remove();
			for (var i = 0; i < data.data.length; i++) {
				s = montarLinha(data.data[i]);
				$('#tabela-clientes>tbody').append(s);
			}
		}

		function carregarClientes(pagina) {
			$.get('/json', {page: pagina}, function(resp) { 
				console.log(resp);
				montarTabela(resp);
				montarPaginator(resp);

				$("#paginator>ul>li>a").click(function(){carregarClientes($(this).attr('pagina'))});

				$("#card-title").html("Exibindo " + resp.per_page + " clientes de " + resp.total + " ( " + resp.from + " a " + resp.to + " ) ")

			});			
		}

		$(function() {
			// página inicial de carregamento da paginação
			carregarClientes(3);
		});

	</script>

</body>
</html>

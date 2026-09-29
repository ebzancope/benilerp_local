// JavaScript Document
function select_cidade(valor) {
      //verifica se o browser tem suporte a ajax
	  try {
         ajax = new ActiveXObject("Microsoft.XMLHTTP");
      } 
      catch(e) {
         try {
            ajax = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax = null;
            }
         }
      }
	  //se tiver suporte ajax
	  if(ajax) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.cad_imo.listCidades.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes");
		 
	     ajax.open("POST", "includes/select_cidade.php", true);
		 ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax.readyState == 4 ) {
			   if(ajax.responseXML) {
			      processXML(ajax.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Selecione o estado";
			   }
            }
         }
		 //passa o código do estado escolhido
	     var params = "estado="+valor;
         ajax.send(params);
      }
   }
   
   function processXML(obj){
      //pega a tag cidade
      var dataArray   = obj.getElementsByTagName("cidade");
      
	  //total de elementos contidos na tag cidade
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			
	        idOpcao.innerHTML = "Selecione a cidade";
			
			//cria um novo option dinamicamente  
			var novo = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo.setAttribute("id", "opcoes");
				//atribui um valor
			    novo.value = codigo;
				//atribui um texto
			    novo.text  = descricao;
				//finalmente adiciona o novo elemento
				document.cad_imo.listCidades.options.add(novo);
		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
		idOpcao.innerHTML = "Selecione o estado";
	  }	  
   }
////////////////////////////////////////////////////////////////////////////////
function select_bairro(valor)
{
	//verifica se o browser tem suporte a ajax
	  try {
         ajax_b = new ActiveXObject("Microsoft.XMLHTTP");
      } 
      catch(e) {
         try {
            ajax_b = new ActiveXObject("Msxml2.XMLHTTP");
         }
	     catch(ex) {
            try {
               ajax_b = new XMLHttpRequest();
            }
	        catch(exc) {
               alert("Esse browser não tem recursos para uso do Ajax");
               ajax_b = null;
            }
         }
      }
	  if(ajax_b) {
	     //deixa apenas o elemento 1 no option, os outros são excluídos
		 document.cad_imo.listBairros.options.length = 1;
	     
		 idOpcao  = document.getElementById("opcoes2");
		 
	     ajax_b.open("POST", "includes/select_bairro.php", true);
		 ajax_b.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		 
		 ajax_b.onreadystatechange = function() {
            //enquanto estiver processando...emite a msg de carregando
			if(ajax_b.readyState == 1) {
			   idOpcao.innerHTML = "Carregando...";   
	        }
			//após ser processado - chama função processXML que vai varrer os dados
            if(ajax_b.readyState == 4 ) {
			   if(ajax_b.responseXML) {
			      processXML(ajax_b.responseXML);
			   }
			   else {
			       //caso não seja um arquivo XML emite a mensagem abaixo
				   idOpcao.innerHTML = "Selecione o estado";
			   }
            }
         }
		 //passa o código do estado escolhido
	     var params2 = "cidade="+valor;
         ajax_b.send(params2);
      }
	  //
	  function processXML(obj){
      //pega a tag cidade
      var dataArray   = obj.getElementsByTagName("bairro");
      
	  //total de elementos contidos na tag cidade
	  if(dataArray.length > 0) {
	     //percorre o arquivo XML paara extrair os dados
         for(var i = 0 ; i < dataArray.length ; i++) {
            var item = dataArray[i];
			//contéudo dos campos no arquivo XML
			var codigo    =  item.getElementsByTagName("codigo")[0].firstChild.nodeValue;
			var descricao =  item.getElementsByTagName("descricao")[0].firstChild.nodeValue;
			
	        idOpcao.innerHTML = "Selecione o bairro";
			
			//cria um novo option dinamicamente  
			var novo2 = document.createElement("option");
			    //atribui um ID a esse elemento
			    novo2.setAttribute("id", "opcoes");
				//atribui um valor
			    novo2.value = codigo;
				//atribui um texto
			    novo2.text  = descricao;
				//finalmente adiciona o novo elemento
				document.cad_imo.listBairros.options.add(novo2);
		 }
	  }
	  else {
	    //caso o XML volte vazio, printa a mensagem abaixo
		idOpcao.innerHTML = "Selecione a cidade";
	  }	  
   }
}
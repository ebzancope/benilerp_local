// JavaScript Document

function formata (maskara, campo) {
	var i = campo.value.length;
	var saida = maskara.substring(0, 1);
	var texto = maskara.substring(i);
	if (texto.substring(0, 1) != saida) {
		campo.value += texto.substring(0, 1);
	}
}
//////////////////////////////////////////////
function v_login () {
	if (document.log_adm.adm_login.value == "") {
		alert('Campo usu�rio Vazio !');
		document.log_adm.adm_login.focus();
		return false;
	}
	if (document.log_adm.adm_senha.value == "") {
		alert('Campo senha Vazio !');
		document.log_adm.adm_senha.focus();
		return false;
	}
}
////////////////////  CONFIGURA��ES DO SITE  /////////////////////////////////////
function conf_up_configs () {
	if (document.up_configs.titulo_site.value == '') {
		alert('Digite um Titulo para o Site !');
		document.up_configs.titulo_site.focus();
		return false;
	}
	if (document.up_configs.url_site.value == '') {
		alert('Digite o endere�o do site !');
		document.up_configs.url_site.focus();
		return false;
	}
	if (document.up_configs.email_site.value == "") {
		alert("Digite o e-mail, necess�rio para receber contatos do site !");
		document.up_configs.email_site.focus();
		return false;
	}
	var re = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if (document.up_configs.email_site.value.search(re) == -1) {
		alert('digite um endere�o de email v�lido');
		document.up_configs.email_site.focus();
		return false;
	}
}
/////////////////////                            MENU INSER��O DE IM�VEL                         //////////////////////////
function subMenuIns (id) {
	//alert("usar funcao menu(id)");
}

function menu (id) {
	if (id == "sub_div1") {
		document.getElementById('sub_div1').style.display = 'block';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'none';
	}
	if (id == "sub_div2") {
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'block';
		document.getElementById('sub_div3').style.display = 'none';
	}
	if (id == "sub_div3") {
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'block';
	}
}
////////////////////////////////////////////////
function form_cad_imo () {
	if (document.cad_imo.titulo.value == "") {
		alert("Digite o titulo do Empreendimento !");
		document.getElementById('sub_div1').style.display = 'block';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'none';

		document.cad_imo.titulo.focus();
		return false;

	}
	//	if (document.cad_imo.ref.value=="")
	//	{
	//		alert("Digite n�mero para refer�ncia !");
	//		document.getElementById('sub_div1').style.display = 'block';
	//		document.getElementById('sub_div2').style.display = 'none';
	//		document.getElementById('sub_div3').style.display = 'none';
	//		document.cad_imo.ref.focus();
	//		return false;
	//	}
	if (document.cad_imo.lazer.value.length >= 501) {
		alert("M�ximo de 500 caracteres em lazer !");
		document.getElementById('sub_div1').style.display = 'block';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'none';
		document.cad_imo.lazer.focus();
		return false;
	}
	if (document.cad_imo.descricao.value.length >= 801) {
		alert("M�ximo de 800 caracteres em descri��o !");
		document.getElementById('sub_div1').style.display = 'block';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'none';
		document.cad_imo.descricao.focus();
		return false;
	}

	if (document.cad_imo.end.value == "") {
		alert("Digite o endere�o !");
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'block';
		document.cad_imo.end.focus();
		return false;
	}
	if (document.cad_imo.num.value == "") {
		alert("Digite o n�mero !");
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'block';
		document.cad_imo.num.focus();
		return false;
	}
	if (document.cad_imo.listEstados.value == 0) {
		alert("Selecione um estado !");
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'block';
		document.cad_imo.listEstados.focus();
		return false;
	}
	if (document.cad_imo.listCidades.value == 0) {
		alert("Selecione a Cidade !");
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'block';
		document.cad_imo.listCidades.focus();
		return false;
	}
	if (document.cad_imo.cep.value == '') {
		alert("Digite o CEP !");
		document.getElementById('sub_div1').style.display = 'none';
		document.getElementById('sub_div2').style.display = 'none';
		document.getElementById('sub_div3').style.display = 'block';
		document.cad_imo.cep.focus();
		return false;
	}
}
////////////////////////////////////////////////
function form_cad_bairro () {
	if (document.cad_imo.listEstados.value == 0) {
		alert("Selecione um estado !");
		document.cad_imo.listEstados.focus();
		return false;
	}
	if (document.cad_imo.listCidades.value == 0) {
		alert("Selecione a Cidade !");
		document.cad_imo.listCidades.focus();
		return false;
	}
	if (document.cad_imo.bairro.value == "") {
		alert("Digite o nome do Bairro !");
		document.cad_imo.bairro.focus();
		return false;
	}
}
////////////////////////////////////////////////
function form_up_bairro () {
	if (document.cad_bar.bairro.value == "") {
		alert("Digite o nome do Bairro !");
		document.cad_bar.bairro.focus();
		return false;
	}
}
////////////////////////////////////////////////
function form_cad_tipo () {
	if (document.cad_tipo.tipo.value == "") {
		alert("Digite o nome do Tipo !");
		document.cad_tipo.tipo.focus();
		return false;
	}
}
////////////////////////////////////////////////
function form_up_tipo () {
	if (document.cad_tipo.tipo.value == "") {
		alert("Digite o nome do Tipo !");
		document.cad_tipo.tipo.focus();
		return false;
	}
}
////////////////////////////////////////////////
function ins_imgs () {
	if (document.fotos.foto1.value == '' && document.fotos.foto2.value == '' && document.fotos.foto3.value == '' && document.fotos.foto4.value == '' && document.fotos.foto5.value == '') {
		alert("Selecione uma imagem !");
		document.fotos.foto1.focus();
		return false;
	}
}
////////////////////////////////////////////////
function confirm_exc_imo () {
	var conf = confirm('Confirmar Exclus�o?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
///////////////////////////////////////////////////////////
function confirm_exc_tipo () {
	var conf = confirm('Confirmar Exclus�o do Tipo ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
///////////////////////////////////////////////////////////
function confirm_exc_bar () {
	var conf = confirm('Confirmar Exclus�o do Bairro ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
///////////////////////////////////////////////////////////
function confirm_exc_foto () {
	var conf = confirm('Confirmar Exclus�o da Imagem ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
///////////////////////////////////////////////////////////
function form_cad_cidade () {
	if (document.cad_imo.listEstados.value == 0) {
		alert("Selecione um estado !");
		document.cad_imo.listEstados.focus();
		return false;
	}
	if (document.cad_imo.cidade.value == "") {
		alert("Digite o nome da Cidade !");
		document.cad_imo.cidade.focus();
		return false;
	}
}
////////////////////////////////////////////////////////////////
function confirm_exc_cid () {
	var conf = confirm('Confirmar Exclus�o da Cidade ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
///////////////////////////////////////////////////////////////
function form_up_cidade () {
	if (document.cad_bar.cidade.value == "") {
		alert("Preencha o campo !");
		document.cad_bar.cidade.focus();
		return false;
	}
}
//////////////////////////////////////       BUSCA ADMIN IM�VEIS      ///////////////////////////////////////////
function form_busca_imo () {
	if (document.busca_imo.buscar.value == "") {
		alert("Preencha o campo !");
		document.busca_imo.buscar.focus();
		return false;
	}
}
//////////////////////////////////////       ATUALIZAR IMAGEM DO BANNER      ///////////////////////////////////////////

function up_img_banner () {
	if (document.up_banner1.foto.value == "") {
		alert("Selecione uma imagem !");
		document.up_banner1.foto.focus();
		return false;
	}
}
function up_img_banner2 () {
	if (document.up_banner2.foto.value == "") {
		alert("Selecione uma imagem !");
		document.up_banner2.foto.focus();
		return false;
	}
}
function up_img_banner3 () {
	if (document.up_banner3.foto.value == "") {
		alert("Selecione uma imagem !");
		document.up_banner3.foto.focus();
		return false;
	}
}
function up_img_banner4 () {
	if (document.up_banner4.foto.value == "") {
		alert("Selecione uma imagem !");
		document.up_banner4.foto.focus();
		return false;
	}
}
//////////////////////////////////////       EXCLUIR IMOVEL      ///////////////////////////////////////////
function confirm_exc_imo () {
	var conf = confirm('Confirmar ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
//////////////////////////////////////       SELE��O DE OBRA      ///////////////////////////////////////////
function valida_sel_obra () {
	var form = document.ins_foto_obra;
	if (form.pdf.value == '') {
		alert('Selecione ao menos um Empreendimento !');
		form.pdf.focus();
		return false;
	}
}

//////////////////////////////////////       MENU IMAGENS OBRAS     ///////////////////////////////////////////

function sanfonaDIV (id) {
	if (document.getElementById(id).style.display == "block") {
		document.getElementById(id).style.display = "none";
	}
	else {
		document.getElementById(id).style.display = "block";
	}
}

//////////////////////////////////////      INSERIR IMOBILIARIA    ///////////////////////////////////////////

function form_cad_imob () {
	var form = document.cad_imob;
	if (form.nome.value == "") {
		alert("Digite o Nome");
		form.nome.focus();
		return false;
	}
	if (form.email.value == "") {
		alert("Digite o e-mail");
		form.email.focus();
		return false;
	}
	var re = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if (form.email.value.search(re) == -1) {
		alert('digite um endere�o de email v�lido');
		form.email.focus();
		return false;
	}
	if (form.telefone.value == "") {
		alert("Digite Telefone");
		form.telefone.focus();
		return false;
	}
	if (form.senha.value == "") {
		alert("Digite a Senha");
		form.senha.focus();
		return false;
	}
	if (form.senha.value.length < 4) {
		alert("Digite pelomenos 4 caracteres");
		form.senha.focus();
		return false;
	}
	if (form.rep_senha.value == "") {
		alert("Digite a senha novamente");
		form.rep_senha.focus();
		return false;
	}
	if (form.senha.value !== form.rep_senha.value) {
		alert("Digite a mesma senha");
		form.senha.focus();
		return false;
	}
	var conf = confirm('Cadastrar Nova Imobili�ria ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
//////////////////////////////////////      ATUALIZAR IMOBILIARIA    ///////////////////////////////////////////
function form_up_imob () {
	var form = document.cad_imob;
	if (form.nome.value == "") {
		alert("Digite o Nome");
		form.nome.focus();
		return false;
	}
	if (form.email.value == "") {
		alert("Digite o e-mail");
		form.email.focus();
		return false;
	}
	var re = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if (form.email.value.search(re) == -1) {
		alert('digite um endere�o de email v�lido');
		form.email.focus();
		return false;
	}
	if (form.telefone.value == "") {
		alert("Digite Telefone");
		form.telefone.focus();
		return false;
	}
	var conf = confirm('Atualizar Cadastro ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
//////////////////////////////////////      EXCLUIR IMOBILIARIA    ///////////////////////////////////////////
function confirm_exc_imob () {
	var conf = confirm('Excluir Cadastro ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
//////////////////////////////////////            CADASTRO DE REVENDA             ///////////////////////////////////////////
function form_cad_rev () {
	var form = document.cad_rev;
	if (form.titulo.value == '') {
		alert('Digite um Titulo !');
		subMenuIns(sub_div1);
		form.titulo.focus();
		return false;
	}
	if (form.valor.value == '') {
		alert('Digite o valor !');
		subMenuIns(sub_div2);
		form.valor.focus();
		return false;
	}
	if (form.end.value == '') {
		alert('Digite o Endere�o !');
		subMenuIns(sub_div3);
		form.end.focus();
		return false;
	}
	if (form.num.value == '') {
		alert('Digite o numero !');
		subMenuIns(sub_div3);
		form.num.focus();
		return false;
	}
	if (form.cidade.value == '') {
		alert('Digite a Cidade !');
		subMenuIns(sub_div3);
		form.cidade.focus();
		return false;
	}
	if (form.estado.value == '') {
		alert('Selecione o Estado !');
		subMenuIns(sub_div3);
		form.estado.focus();
		return false;
	}
	var conf = confirm('Cadastrar revenda ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
//////////////////////////////////////            EXCLUIR REVENDA             ///////////////////////////////////////////

function confirm_exc_revenda () {
	var conf = confirm('Excluir revenda ?');
	if (!conf) {
		return false;
	}
	else {
		return true;
	}
}
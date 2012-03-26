<?

header('Content-Type: text/html; charset=utf-8');

include( "auto-form.php" );

/**/

$formConfigXML = xml2array( file_get_contents( "config-frm1.xml" ) );

$formConfigARR = 
	
	array(
	
		"id"					=> "frm1",			
		"acao"					=> "./",
		"acao-rotulo"			=> "enviar",
		"tipo"					=> "post",
		"valida-erro"			=> "Preencha corretamente os campos: ",
		"valida-sucesso"		=> "Dados enviados com sucesso.",
		"campos" 				=> 
		
			array(
		
				array(
			
					"tipo" 		=> "texto",
					"rotulo" 	=> "Nome",
					"id" 		=> "nome",
					"estilo" 	=> "",
					"padrao"	=> "",
					"tamanho"	=> "100",
					"valida"	=> "obrigatorio"
				
				),
				
				array(
				
					"tipo" 		=> "texto",
					"rotulo" 	=> "E-mail",
					"id" 		=> "email",
					"estilo" 	=> "",
					"padrao"	=> "",
					"tamanho"	=> "80",
					"valida"	=> "obrigatorio"
				
				),
	
				array(
				
					"tipo" 		=> "texto",
					"rotulo" 	=> "Telefone",
					"id" 		=> "telefone",
					"estilo" 	=> "mask-telefone-internacional",
					"padrao"	=> "",
					"tamanho"	=> "12",
					"valida"	=> ""
				
				),
				
				array(
				
					"tipo" 		=> "texto-grande",
					"rotulo" 	=> "Mensagem",
					"id" 		=> "mensagem",
					"estilo" 	=> "",
					"padrao"	=> "",
					"valida"	=> "obrigatorio"
				
				),
	
				array(
				
					"tipo" 		=> "combo",
					"rotulo" 	=> "Estado",
					"id" 		=> "estado",
					"estilo" 	=> "",
					"padrao"	=> array( "", "Selecione" ),
					"tamanho"	=> "",
					"dados"		=> array( "SP" => "São Paulo", "RJ" => "Rio de Janeiro", "MG" => "Minas Gerais" ),
					"valida"	=> "obrigatorio"					
				),
				
				array(
				
					"tipo"		=> "multiplo",
					"rotulo"	=> "Peças",
					"rotulos"	=> "No. Serial,Descrição,Quantidade",
					"id"		=> "peca",
					"ids"		=> "serial,descricao,quantidade",
					"padrao"	=> "",
					"estilo"	=> "peca-serial,peca-desc,peca-qtd",
					"tamanho"	=> "12,100,5",
					"valida"	=> "obrigatorio,obrigatorio,obrigatorio"
				
				)
	
			)
	
	);


echo "<h1>formConfigXML</h1>";

print_r( $formConfigXML["auto-form"]["config"] );

echo "<hr />";

echo "<h1>formConfigARR</h1>";

print_r( $formConfigARR );

echo "<hr />";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
        <title></title>
        
        <script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-maskedinput.js"></script>
        <script type="text/javascript" src="js/frm-controle.js"></script>
        
        <link rel="stylesheet" type="text/css" href="css/frm-estilo.css" media="screen" />
    
    </head>
    
    <body>
    
	    <? montaForm( $formConfigXML, $_POST ); ?>
    
    </body>

</html>
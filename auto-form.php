<?

/***/

include( "auto-form-aux-funcoes.php" );

/***/

function montaForm( $xml, $post ){
	
	$form = $xml["auto-form"]["config"];

	if( $post[$form["id"] . "act_id"] == "enviar" ){
		
		$erros = array();
	
		/* TO DO: aplicar várias funcões */
	
		// validações - uma função //
	
		foreach( $form["campos"]["campo"] as $campo ){
			
			if( $campo["tipo"] == "multiplo" ){
				
				// campo multiplo //
				
				$quantidade = $post[$form["id"] . $campo["id"] . "qtd"];
				
				if( $quantidade > 0 ){
					
					$tmpIds = explode( ",", $campo["ids"] );
					$tmpRotulos = explode( ",", $campo["rotulos"] );
					$tmpTamanhos = explode( ",", $campo["tamanho"] );				
					$tmpValidacoes = explode( ",", $campo["valida"] );
				
					for( $x = 0; $x < $quantidade; $x++ ){
						
						foreach( $tmpIds as $k => $subid ){
							
							$id = $form["id"] . $campo["id"] . $subid . $x;
							
							if( function_exists( $tmpValidacoes[$k] ) ){
	
								call_user_func( $tmpValidacoes[$k], $post[$id] ) ? NULL : array_push( $erros, $campo["rotulo"] . " - " . $tmpRotulos[$k] . " (" . ( $x + 1 ) . ")" );
					
							}							
							
						}
						
					}
					
				}	
				
			} else{
	
				// campos text, select e textarea
				
				$id = $form["id"] . $campo["id"];
				
				if( function_exists( $campo["valida"] ) ){
	
					call_user_func( $campo["valida"], $post[$id] ) ? NULL : array_push( $erros, $campo["rotulo"] );
					
				}
				
			}
		
		}
		
		// erros //
		
		if( empty( $erros ) ){
	
			echo "<p class='form-ret form-ret-sucesso'>";
			
			echo "<strong>" . $form["valida-sucesso"] . "</strong><br />";
			
			echo "</p>";
			
			// processa //
			
			unset( $_POST, $post );
			
			
		} else{
		
			echo "<p class='form-ret form-ret-erro'>";
			
			echo "<strong>" . $form["valida-erro"] . "</strong><br />";
			
			echo implode( "; ", $erros );
			
			echo "</p>";
			
		}
		
	}
	
	// *** monta o form *** //
	
	echo "<form name='" . $form["id"] . "' id='" . $form["id"] . "' action='" . $form["acao"] . "' method='" . $form["tipo"] . "'>";
	
	foreach( $form["campos"]["campo"] as $campo ){
	
		echo "<label>";
		
		echo "<span class='rotulo'>" . $campo["rotulo"] . "</span>";
		
		$valor = $post[$form["id"] . $campo["id"]];
	
		switch( $campo["tipo"] ){
			
			/*************/
		
			case "combo":
			
				$campo["padrao"] = ( empty( $campo["padrao"] ) ? "" :  $campo["padrao"] );
			
				echo "<select name='" . $form["id"] . $campo["id"] . "' id='" . $form["id"] . $campo["id"] . "' class='texto " . $campo["estilo"] . "' maxlength='" . $campo["tamanho"] . "'>";
				
				if( is_array( $campo["padrao"] ) ){
					
					echo "<option value='" . $campo["padrao"][0] . "' selected='selected'>" . $campo["padrao"][1] . "</option>";
					
				}
				
				foreach( $campo["dados"] as $dadosCod => $dadosDesc ){
					
					echo "<option value='" . $dadosCod . "' " . ( $valor == $dadosCod ? "selected='selected'" : '' ) . ">" . $dadosDesc . "</option>";
					
				}
				
				echo "</select>";
						
				break;
				
			/*************/
		
			case "texto":
			
				$campo["padrao"] = ( empty( $campo["padrao"] ) ? "" :  $campo["padrao"] );			
			
				echo "<input type='text' value='" . ( $valor == "" ? $campo["padrao"] : $valor ) . "' name='" . $form["id"] . $campo["id"] . "' id='" . $form["id"] . $campo["id"] . "' class='texto " . $campo["estilo"] . "' maxlength='" . $campo["tamanho"] . "' />";
						
				break;
	
			/*************/
		
			case "texto-grande":
			
				$campo["padrao"] = ( empty( $campo["padrao"] ) ? "" :  $campo["padrao"] );			
			
				echo "<textarea name='" . $form["id"] . $campo["id"] . "' id='" . $form["id"] . $campo["id"] . "' class='texto-grande " . $campo["estilo"] . "'>" . ( $valor == "" ? $campo["padrao"] : $valor ) . "</textarea>";
						
				break;
	
			/****************/
				
			case "multiplo":
			
				$quantidade = $post[$form["id"] . $campo["id"] . "qtd"];
			
				$tmpIds = explode( ",", $campo["ids"] );
				$tmpRotulos = explode( ",", $campo["rotulos"] );
				$tmpEstilos = explode( ",", $campo["estilo"] );
				$tmpPadroes = explode( ",", $campo["padrao"] );	
				$tmpTamanhos = explode( ",", $campo["tamanho"] );
				
				// base //		
						
				$base = "<div>";
				
				$base.= "<span class='sub-rotulo sub-rotulo-n'>@. </span>";
				
				foreach( $tmpIds as $k => $subid ){
					
					$id = $form["id"] . $campo["id"] . $subid . "#";
					
					$base.= "<input type='text' name='" . $id . "' id='" . $id . "' class='" . $tmpEstilos[$k] . "' maxlength='" . $tmpTamanhos[$k] . "' />";
					
				}
				
				$base.= "</div>";				
				
				echo "<div class='multiplo-base " . $form["id"] . $campo["id"] . "base'>" . $base . "</div>";
				
				// painel //
								
				echo "<div class='painel " . $form["id"] . $campo["id"] . "painel'>";
				
				echo "<input type='button' class='controle controle-add' rel='" . $form["id"] . $campo["id"] . "' value='+' />";
				echo "<input type='button' class='controle controle-rem' rel='" . $form["id"] . $campo["id"] . "' value='-' />";
				
				echo "<input type='hidden' name='" . $form["id"] . $campo["id"] . "qtd' id='" . $form["id"] . $campo["id"] . "qtd' class='" . $form["id"] . $campo["id"] . "controle-qtd' value='" . ( $quantidade > 0 ? $quantidade : 0 )  . "' />";
				
				echo "</div>";
				
				// lista //
				
				echo "<span class='sub-rotulo sub-rotulo-n'>#. </span>";
				
				foreach( $tmpRotulos as $k => $subrotulo ){
					
					echo "<span class='sub-rotulo " . $tmpEstilos[$k] . "'>" . $subrotulo . "</span>";
					
				}
								
				echo "<div class='container " . $form["id"] . $campo["id"] . "container'>";
				
				if( $quantidade > 0 ){
				
					for( $x = 0; $x < $quantidade; $x++ ){
					
						echo "<div>";
						
						echo "<span class='sub-rotulo sub-rotulo-n'>" . ( $x + 1 ) . ". </span>";
						
						foreach( $tmpIds as $k => $subid ){
						
							$id = $form["id"] . $campo["id"] . $subid . $x;
						
							echo "<input type='text' name='" . $id . "' id='" . $id . "' class='" . $tmpEstilos[$k] . "' maxlength='" . $tmpTamanhos[$k] . "' value='" . ( $post[$id] ) . "' />";
						
						}
						
						echo "</div>";
						
					}
					
				}
				
				echo "</div>";				
				
				unset( $tmpCampos, $tmpEstilos, $tmpPadroes, $tmpTamanhos );
			
				break;			
			
		}
		
		echo "</label>";
		
	}	
	
	echo "<input type='hidden' name='" . $form["id"] . "act_id' value='enviar' />";
	
	echo "<input type='submit' name='btn_submit' value='" . $form["acao-rotulo"] . "' />";
	
	echo "</form>";

}

?>
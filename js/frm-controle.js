$( document ).ready( function(){
	
	$( ".controle-add" ).bind( "click", function(){
		
		var rel = $( this ).attr( "rel" );					
		var base = $( "." + rel + "base" ).html();					
		var k = parseInt( $( "." + rel + "controle-qtd" ).val() );
		
		$( "." + rel + "container" ).append( base.replace( /#/g, k ).replace( /@/, ( k + 1 ) ) );
		$( "." + rel + "controle-qtd" ).val( k + 1 );

	} );
	
	$( ".controle-rem" ).bind( "click", function(){
		
		var rel = $( this ).attr( "rel" );
		var k = parseInt( $( "." + rel + "controle-qtd" ).val() );
		
		if( k > 0 ){
		
			$( "." + rel + "container div:nth-child(" + k + ")" ).remove();				
			$( "." + rel + "controle-qtd" ).val( k - 1 );
			
		}
		
	} );
	
	$( ".mask-data" ).mask( "99/99/9999" );
	$( ".mask-cep" ).mask( "99.999-999" );
	$( ".mask-telefone" ).mask( "(99) 9999-9999" );
	$( ".mask-telefone-internacional" ).mask( "+99 (99) 9999-9999" );
	$( ".mask-cpf" ).mask( "999.999.999-99" );
	
} );
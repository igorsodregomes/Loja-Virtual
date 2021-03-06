<?php 

class Carrinho{
	private $total_valor, $total_peso, $total_altura, $total_largura,$total_comprimento, $itens = array();

	function GetCarrinho($sessao=NULL){

		$i = 1; $sub = 1.00; $peso = 0 ; $altura = 0 ; $altura = 0; $comprimento = 0;

		

		

		foreach ($_SESSION['PRO'] as $lista) {
			$sub = ($lista['VALOR_US'] * $lista['QTD']);
			//soma os itens do carrinho
			$this->total_valor += $sub;

			$peso = $lista['PESO'] *  $lista['QTD'];
			$this->total_peso += $peso;
			
			$altura = $lista['ALTURA'] * $lista['QTD'];
			$this->total_altura +=$altura;


			$largura = $lista['LARGURA'] * $lista['QTD'];
			$this->total_largura +=$largura;


			$comprimento = $lista['COMPRIMENTO'] * $lista['QTD'];
			$this->total_comprimento +=$comprimento;


		
			$this->itens[$i] = array(

				'pro_id' => $lista['ID'],
				'pro_nome'  => $lista['NOME'],
	            'pro_valor' => $lista['VALOR'], // 1.000,99
	            'pro_valor_us' => $lista['VALOR_US'],  //1000.99
	            'pro_peso'  => $lista['PESO'],						
				'pro_altura'  => $lista['ALTURA'],// em cm 20
				'pro_largura'  => $lista['LARGURA'],// em cm 20
				'pro_comprimento'  => $lista['COMPRIMENTO'],// em cm 20	
	            'pro_qtd'   => $lista['QTD'],
	            'pro_img'   => $lista['IMG'],
	            'pro_link'  => $lista['LINK'],
	            'pro_subTotal'=> Sistema::MoedaBR($sub),         
	            'pro_subTotal_us'=> $sub,
				

				);
			$i++;

			
		}

		if(count($this->itens) > 0){
			return $this->itens;
		}else{
			echo '<h4 class="alert alert-danger"> Não há produtos no carrinho </h4>';

		}

	}


	function GetTotal(){
		return $this->total_valor;
	}

	function GetPeso(){
		return $this->total_peso;
	}

	function GetAltura(){
		return $this->total_altura;
	}
	function GetLargura(){
		return $this->total_largura;
	}
	function GetComprimento(){
		return $this->total_comprimento;
	}

	function CarrinhoADD($id){
		$produtos = new Produtos();
		$produtos->GetProdutosID($id);
		foreach ($produtos->GetItens() as $pro) {
			$ID = $pro['pro_id'];
			$NOME  = $pro['pro_nome'];
            $VALOR_US = $pro['pro_valor_us'];
            $VALOR  = $pro['pro_valor'];
            $PESO  = $pro['pro_peso'];
			$ALTURA = $pro['pro_altura'];
			$LARGURA = $pro['pro_largura'];
			$COMPRIMENTO = $pro['pro_comprimento'];
            $QTD   = 1;
            $IMG   = $pro['pro_img_p'];
            $LINK  = Rotas::pag_ProdutosInfo().'/'.$ID.'/'.$pro['pro_slug'];
            $ACAO  = $_POST['acao'];
		}

		switch ($ACAO) {
			case 'add':
					if(!isset($_SESSION['PRO'][$ID]['ID'])){
						$_SESSION['PRO'][$ID]['ID'] = $ID;
						$_SESSION['PRO'][$ID]['NOME']  = $NOME;
					    $_SESSION['PRO'][$ID]['VALOR'] = $VALOR;
					    $_SESSION['PRO'][$ID]['VALOR_US'] = $VALOR_US;
					    $_SESSION['PRO'][$ID]['PESO']  = $PESO;
						$_SESSION['PRO'][$ID]['ALTURA']  = $ALTURA;
						$_SESSION['PRO'][$ID]['LARGURA']  = $LARGURA;
						$_SESSION['PRO'][$ID]['COMPRIMENTO']  = $COMPRIMENTO;
					    $_SESSION['PRO'][$ID]['QTD']   = $QTD;
					    $_SESSION['PRO'][$ID]['IMG']   = $IMG;
					    $_SESSION['PRO'][$ID]['LINK']  = $LINK;  
					}else{
						//se ja existe o produto ele soma com o produto do mesmo aumentando a quantidade
						 $_SESSION['PRO'][$ID]['QTD']   += $QTD;
					}

					echo '<h4 class="alert alert-success"> Produto Inserido! </h4>';

				break;

			case 'del':
				$this->CarrinhoDEL($id);
				echo '<h4 class="alert alert-success"> Produto Removido! </h4>';
				break;

			case 'limpar':
				$this->CarrinhoLimpar();
				echo '<h4 class="alert alert-success"> Produtos Removidos! </h4>';
				break;
			
			
		}
	}

	//quando vc coloca o id deleta apenas ele sem o id e a msm coisa do delete sem where no banco apaga a pora toda
	
	private function CarrinhoDEL($id){
		unset($_SESSION['PRO'][$id]);
	}

	private function CarrinhoLimpar(){
		unset($_SESSION['PRO']);
	}




}

 ?>
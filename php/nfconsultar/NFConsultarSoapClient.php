<?php
class CBSoapClient extends SoapClient {
    public function __doRequest($request, $location, $action, $version, $one_way = 0) {
        $xmlRequest = new DOMDocument("1.0");
        $xmlRequest->loadXML($request);
        $header = $xmlRequest->createElement("SOAP-ENV:Header");
        if (defined("OMIE_APP_KEY")) { $header->appendChild( $xmlRequest->createElement("app_key", OMIE_APP_KEY) ); }
        if (defined("OMIE_APP_SECRET")) { $header->appendChild( $xmlRequest->createElement("app_secret", OMIE_APP_SECRET) ); }
        if (defined("OMIE_USER_LOGIN")) { $header->appendChild( $xmlRequest->createElement("user_login", OMIE_USER_LOGIN) ); }
        if (defined("OMIE_USER_PASSWORD")) { $header->appendChild( $xmlRequest->createElement("user_password", OMIE_USER_PASSWORD) ); }
        $envelope = $xmlRequest->firstChild;
        $envelope->insertBefore($header, $envelope->firstChild);
        $request = $xmlRequest->saveXML();
        return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
}
/**
 * @service NFConsultarSoapClient
 */
class NFConsultarSoapClient{
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='http://app.omie.com.br/api/v1/produtos/nfconsultar/?WSDL';
	/**
	 * The PHP SoapClient object
	 *
	 * @var object
	 */
	public static $_Server=null;

	/**
	 * Send a SOAP request to the server
	 *
	 * @param string $method The method name
	 * @param array $param The parameters
	 * @return mixed The server response
	 */
	public static function _Call($method,$param){
		if(is_null(self::$_Server))
			self::$_Server=new CBSoapClient(self::$_WsdlUri);
		return self::$_Server->__soapCall($method,$param);
	}

	/**
	 * Consulta um Nota Fiscal
	 *
	 * @param nfChave $nfChave Chave de pesquisa da Nota Fiscal&nbsp;
	 * @return nfCadastro Dados da Nota Fiscal&nbsp;
	 */
	public function ConsultarNF($nfChave){
		return self::_Call('ConsultarNF',Array(
			$nfChave
		));
	}

	/**
	 * Listar as Notas Fiscais cadastradas.
	 *
	 * @param nfListarRequest $nfListarRequest Solicita????o de Listagem de Notas Fiscais
	 * @return nfListarResponse Resposta da listagem de Notas Fiscais
	 */
	public function ListarNF($nfListarRequest){
		return self::_Call('ListarNF',Array(
			$nfListarRequest
		));
	}
}

/**
 * Chave de pesquisa da Nota Fiscal
 *
 * @pw_element string $cCodNFInt Codigo de Integra????o da NF
 * @pw_element integer $nCodNF C??digo de Identifica????o da NF
 * @pw_element string $nNF N??mero do Documento Fiscal
 * @pw_complex nfChave
 */
class nfChave{
	/**
	 * Codigo de Integra????o da NF
	 *
	 * @var string
	 */
	public $cCodNFInt;
	/**
	 * C??digo de Identifica????o da NF
	 *
	 * @var integer
	 */
	public $nCodNF;
	/**
	 * N??mero do Documento Fiscal
	 *
	 * @var string
	 */
	public $nNF;
}

/**
 * Solicita????o de Listagem de Notas Fiscais
 *
 * @pw_element integer $pagina N??mero da p??gina que ser?? listada.
 * @pw_element integer $registros_por_pagina N??mero de registros por p??gina.
 * @pw_element string $apenas_importado_api Exibir apenas os registros gerados pela API.
 * @pw_element string $ordenar_por Ordem de exibi????o dos dados. Padr??o: C??digo
 * @pw_element string $ordem_decrescente Ordem decrescente.
 * @pw_element string $filtrar_por_data_de Filtra os registros at?? a data especificada.
 * @pw_element string $filtrar_por_data_ate Filtra os registros at?? a data especificada.
 * @pw_element string $filtrar_apenas_inclusao Filtra os registros exibindos apenas os inclu??dos.
 * @pw_element string $filtrar_apenas_alteracao Filtra os registros exibindos apenas os alterados.
 * @pw_element string $dEmiInicial Data de emiss??o.
 * @pw_element string $dEmiFinal Data de emiss??o.
 * @pw_element string $dSaiEntInicial Data de saida.
 * @pw_element string $dSaiEntFinal Data de saida.
 * @pw_element string $dRegInicial Data de Registro.
 * @pw_element string $dRegFinal Data de Registro.
 * @pw_element string $dCanInicial Data de cancelamento.
 * @pw_element string $dCanFinal Data de cancelamento.
 * @pw_element string $dInutInicial Data de Inutiliza????o.
 * @pw_element string $dInutFinal Data de Inutiliza????o.
 * @pw_element string $tpNF Tipo de Opera????o: 0-entrada / 1-sa??da
 * @pw_element string $tpAmb Tipo de Ambiente = 1-Produ????o / 2-Homologa????o
 * @pw_element string $ordem_descrescente DEPRECATED
 * @pw_complex nfListarRequest
 */
class nfListarRequest{
	/**
	 * N??mero da p??gina que ser?? listada.
	 *
	 * @var integer
	 */
	public $pagina;
	/**
	 * N??mero de registros por p??gina.
	 *
	 * @var integer
	 */
	public $registros_por_pagina;
	/**
	 * Exibir apenas os registros gerados pela API.
	 *
	 * @var string
	 */
	public $apenas_importado_api;
	/**
	 * Ordem de exibi????o dos dados. Padr??o: C??digo
	 *
	 * @var string
	 */
	public $ordenar_por;
	/**
	 * Ordem decrescente.
	 *
	 * @var string
	 */
	public $ordem_decrescente;
	/**
	 * Filtra os registros at?? a data especificada.
	 *
	 * @var string
	 */
	public $filtrar_por_data_de;
	/**
	 * Filtra os registros at?? a data especificada.
	 *
	 * @var string
	 */
	public $filtrar_por_data_ate;
	/**
	 * Filtra os registros exibindos apenas os inclu??dos.
	 *
	 * @var string
	 */
	public $filtrar_apenas_inclusao;
	/**
	 * Filtra os registros exibindos apenas os alterados.
	 *
	 * @var string
	 */
	public $filtrar_apenas_alteracao;
	/**
	 * Data de emiss??o.
	 *
	 * @var string
	 */
	public $dEmiInicial;
	/**
	 * Data de emiss??o.
	 *
	 * @var string
	 */
	public $dEmiFinal;
	/**
	 * Data de saida.
	 *
	 * @var string
	 */
	public $dSaiEntInicial;
	/**
	 * Data de saida.
	 *
	 * @var string
	 */
	public $dSaiEntFinal;
	/**
	 * Data de Registro.
	 *
	 * @var string
	 */
	public $dRegInicial;
	/**
	 * Data de Registro.
	 *
	 * @var string
	 */
	public $dRegFinal;
	/**
	 * Data de cancelamento.
	 *
	 * @var string
	 */
	public $dCanInicial;
	/**
	 * Data de cancelamento.
	 *
	 * @var string
	 */
	public $dCanFinal;
	/**
	 * Data de Inutiliza????o.
	 *
	 * @var string
	 */
	public $dInutInicial;
	/**
	 * Data de Inutiliza????o.
	 *
	 * @var string
	 */
	public $dInutFinal;
	/**
	 * Tipo de Opera????o: 0-entrada / 1-sa??da
	 *
	 * @var string
	 */
	public $tpNF;
	/**
	 * Tipo de Ambiente = 1-Produ????o / 2-Homologa????o
	 *
	 * @var string
	 */
	public $tpAmb;
	/**
	 * DEPRECATED
	 *
	 * @var string
	 */
	public $ordem_descrescente;
}

/**
 * Resposta da listagem de Notas Fiscais
 *
 * @pw_element integer $pagina N??mero da p??gina que ser?? listada.
 * @pw_element integer $total_de_paginas Total de p??ginas encontradas.
 * @pw_element integer $registros N??mero de registros por p??gina.
 * @pw_element integer $total_de_registros Total de registros encontrados.
 * @pw_element nfCadastroArray $nfCadastro Dados da Nota Fiscal&nbsp;
 * @pw_complex nfListarResponse
 */
class nfListarResponse{
	/**
	 * N??mero da p??gina que ser?? listada.
	 *
	 * @var integer
	 */
	public $pagina;
	/**
	 * Total de p??ginas encontradas.
	 *
	 * @var integer
	 */
	public $total_de_paginas;
	/**
	 * N??mero de registros por p??gina.
	 *
	 * @var integer
	 */
	public $registros;
	/**
	 * Total de registros encontrados.
	 *
	 * @var integer
	 */
	public $total_de_registros;
	/**
	 * Dados da Nota Fiscal&nbsp;
	 *
	 * @var nfCadastroArray
	 */
	public $nfCadastro;
}

/**
 * Dados da Nota Fiscal
 *
 * @pw_element ide $ide Identifica????o da NF-e
 * @pw_element nfEmitInt $nfEmitInt Dados da Integra????o do Emitente
 * @pw_element nfDestInt $nfDestInt Dados de Integra????o do Destinat??rio da Nota Fiscal
 * @pw_element detArray $det Detalhes dos itens da Nota Fiscal.&nbsp;
 * @pw_element total $total Total da Nota Fiscal
 * @pw_element info $info Informa????es complementares.
 * @pw_element titulosArray $titulos Titulos gerados para a nota fiscal.
 * @pw_complex nfCadastro
 */
class nfCadastro{
	/**
	 * Identifica????o da NF-e
	 *
	 * @var ide
	 */
	public $ide;
	/**
	 * Dados da Integra????o do Emitente
	 *
	 * @var nfEmitInt
	 */
	public $nfEmitInt;
	/**
	 * Dados de Integra????o do Destinat??rio da Nota Fiscal
	 *
	 * @var nfDestInt
	 */
	public $nfDestInt;
	/**
	 * Detalhes dos itens da Nota Fiscal.&nbsp;
	 *
	 * @var detArray
	 */
	public $det;
	/**
	 * Total da Nota Fiscal
	 *
	 * @var total
	 */
	public $total;
	/**
	 * Informa????es complementares.
	 *
	 * @var info
	 */
	public $info;
	/**
	 * Titulos gerados para a nota fiscal.
	 *
	 * @var titulosArray
	 */
	public $titulos;
}


/**
 * Identifica????o da NF-e
 *
 * @pw_element string $indPag Indicador da forma de pagamento:<BR>0 ? pagamento ?? vista;<BR>1 ? pagamento ?? prazo;<BR>2 - outros.
 * @pw_element string $mod C??digo do Modelo do Documento Fiscal:<BR>Utilizar o c??digo 55 para identifica????o da NF-e, emitida em substitui????o ao modelo 1 ou 1A.
 * @pw_element string $serie S??rie do Documento Fiscal
 * @pw_element string $nNF N??mero do Documento Fiscal
 * @pw_element string $dEmi Data de emiss??o.
 * @pw_element string $dSaiEnt Data de saida.
 * @pw_element string $hSaiEnt Hora de Sa??da ou da Entrada da Mercadoria/Produto
 * @pw_element string $tpNF Tipo de Opera????o: 0-entrada / 1-sa??da
 * @pw_element string $tpAmb Tipo de Ambiente = 1-Produ????o / 2-Homologa????o
 * @pw_element string $finNFe Finalidade de emiss??o da NFe: <BR>1 ? NF-e normal<BR>2 ? NF-e complementar<BR>3 ? NF-e de ajuste
 * @pw_element string $dReg Data de Registro.
 * @pw_element string $dCan Data de cancelamento.
 * @pw_element string $dInut Data de Inutiliza????o.
 * @pw_complex ide
 */
class ide{
	/**
	 * Indicador da forma de pagamento:<BR>0 ? pagamento ?? vista;<BR>1 ? pagamento ?? prazo;<BR>2 - outros.
	 *
	 * @var string
	 */
	public $indPag;
	/**
	 * C??digo do Modelo do Documento Fiscal:<BR>Utilizar o c??digo 55 para identifica????o da NF-e, emitida em substitui????o ao modelo 1 ou 1A.
	 *
	 * @var string
	 */
	public $mod;
	/**
	 * S??rie do Documento Fiscal
	 *
	 * @var string
	 */
	public $serie;
	/**
	 * N??mero do Documento Fiscal
	 *
	 * @var string
	 */
	public $nNF;
	/**
	 * Data de emiss??o.
	 *
	 * @var string
	 */
	public $dEmi;
	/**
	 * Data de saida.
	 *
	 * @var string
	 */
	public $dSaiEnt;
	/**
	 * Hora de Sa??da ou da Entrada da Mercadoria/Produto
	 *
	 * @var string
	 */
	public $hSaiEnt;
	/**
	 * Tipo de Opera????o: 0-entrada / 1-sa??da
	 *
	 * @var string
	 */
	public $tpNF;
	/**
	 * Tipo de Ambiente = 1-Produ????o / 2-Homologa????o
	 *
	 * @var string
	 */
	public $tpAmb;
	/**
	 * Finalidade de emiss??o da NFe: <BR>1 ? NF-e normal<BR>2 ? NF-e complementar<BR>3 ? NF-e de ajuste
	 *
	 * @var string
	 */
	public $finNFe;
	/**
	 * Data de Registro.
	 *
	 * @var string
	 */
	public $dReg;
	/**
	 * Data de cancelamento.
	 *
	 * @var string
	 */
	public $dCan;
	/**
	 * Data de Inutiliza????o.
	 *
	 * @var string
	 */
	public $dInut;
}

/**
 * Dados da Integra????o do Emitente
 *
 * @pw_element integer $nCodEmp C??digo da Empresa
 * @pw_element string $cCodEmpInt C??digo de integra????o da empresa.
 * @pw_complex nfEmitInt
 */
class nfEmitInt{
	/**
	 * C??digo da Empresa
	 *
	 * @var integer
	 */
	public $nCodEmp;
	/**
	 * C??digo de integra????o da empresa.
	 *
	 * @var string
	 */
	public $cCodEmpInt;
}

/**
 * Dados de Integra????o do Destinat??rio da Nota Fiscal
 *
 * @pw_element integer $nCodCli C??digo do cliente
 * @pw_element string $cCodCliInt C??digo de integra????o do cliente Fornecedor.&nbsp;
 * @pw_complex nfDestInt
 */
class nfDestInt{
	/**
	 * C??digo do cliente
	 *
	 * @var integer
	 */
	public $nCodCli;
	/**
	 * C??digo de integra????o do cliente Fornecedor.&nbsp;
	 *
	 * @var string
	 */
	public $cCodCliInt;
}

/**
 * Detalhes dos itens da Nota Fiscal.
 *
 * @pw_element prod $prod TAG de grupo do detalhamento de Produtos e Servi??os da NF-e
 * @pw_element nfProdInt $nfProdInt Informa????es de Integra????o dos itens da NF
 * @pw_complex det
 */
class det{
	/**
	 * TAG de grupo do detalhamento de Produtos e Servi??os da NF-e
	 *
	 * @var prod
	 */
	public $prod;
	/**
	 * Informa????es de Integra????o dos itens da NF
	 *
	 * @var nfProdInt
	 */
	public $nfProdInt;
}


/**
 * Total da Nota Fiscal
 *
 * @pw_element ICMSTot $ICMSTot Grupo de Valores Totais referentes ao ICMS
 * @pw_element ISSQNtot $ISSQNtot Grupo de Valores Totais referentes ao ISSQN
 * @pw_element retTrib $retTrib Grupo de Reten????es de Tributos
 * @pw_complex total
 */
class total{
	/**
	 * Grupo de Valores Totais referentes ao ICMS
	 *
	 * @var ICMSTot
	 */
	public $ICMSTot;
	/**
	 * Grupo de Valores Totais referentes ao ISSQN
	 *
	 * @var ISSQNtot
	 */
	public $ISSQNtot;
	/**
	 * Grupo de Reten????es de Tributos
	 *
	 * @var retTrib
	 */
	public $retTrib;
}

/**
 * Informa????es complementares.
 *
 * @pw_element string $dInc Data da Inclus??o.
 * @pw_element string $hInc Hora da Inclus??o.
 * @pw_element string $uInc Usu??rio da Inclus??o.
 * @pw_element string $dAlt Data da Altera????o.
 * @pw_element string $hAlt Hora da Altera????o.
 * @pw_element string $uAlt Usu??rio da Altera????o.
 * @pw_element string $cImpAPI Importado pela API (S/N).
 * @pw_complex info
 */
class info{
	/**
	 * Data da Inclus??o.
	 *
	 * @var string
	 */
	public $dInc;
	/**
	 * Hora da Inclus??o.
	 *
	 * @var string
	 */
	public $hInc;
	/**
	 * Usu??rio da Inclus??o.
	 *
	 * @var string
	 */
	public $uInc;
	/**
	 * Data da Altera????o.
	 *
	 * @var string
	 */
	public $dAlt;
	/**
	 * Hora da Altera????o.
	 *
	 * @var string
	 */
	public $hAlt;
	/**
	 * Usu??rio da Altera????o.
	 *
	 * @var string
	 */
	public $uAlt;
	/**
	 * Importado pela API (S/N).
	 *
	 * @var string
	 */
	public $cImpAPI;
}

/**
 * Titulos gerados para a nota fiscal.
 *
 * @pw_element integer $nCodTitulo C??digo do titulo.<BR>(Gerado internamente, n??o ?? visualizado na tela)
 * @pw_element string $cCodIntTitulo C??digo de integra????o do t??tulo.<BR>(Utilizado em t??tulos criados via API, n??o ?? visualizado na tela)
 * @pw_element string $cNumTitulo N??mero do t??tulo.<BR>(Informado pelo usu??rio / visualizado na tela)
 * @pw_element string $dDtEmissao Data de emiss??o do t??tulo.
 * @pw_element string $dDtVenc Data de vencimento do t??tulo.<BR>
 * @pw_element string $dDtPrevisao Data de previs??o de Pagamento/Recebimento.
 * @pw_element decimal $nValorTitulo Valor do t??tulo.
 * @pw_complex titulos
 */
class titulos{
	/**
	 * C??digo do titulo.<BR>(Gerado internamente, n??o ?? visualizado na tela)
	 *
	 * @var integer
	 */
	public $nCodTitulo;
	/**
	 * C??digo de integra????o do t??tulo.<BR>(Utilizado em t??tulos criados via API, n??o ?? visualizado na tela)
	 *
	 * @var string
	 */
	public $cCodIntTitulo;
	/**
	 * N??mero do t??tulo.<BR>(Informado pelo usu??rio / visualizado na tela)
	 *
	 * @var string
	 */
	public $cNumTitulo;
	/**
	 * Data de emiss??o do t??tulo.
	 *
	 * @var string
	 */
	public $dDtEmissao;
	/**
	 * Data de vencimento do t??tulo.<BR>
	 *
	 * @var string
	 */
	public $dDtVenc;
	/**
	 * Data de previs??o de Pagamento/Recebimento.
	 *
	 * @var string
	 */
	public $dDtPrevisao;
	/**
	 * Valor do t??tulo.
	 *
	 * @var decimal
	 */
	public $nValorTitulo;
}


/**
 * Informa????es de Integra????o dos itens da NF
 *
 * @pw_element integer $nCodProd C??digo do Produto
 * @pw_element string $cCodProdInt C??digo de Integra????o do produto.
 * @pw_element integer $nCodItem C??digo do item
 * @pw_element string $cCodItemInt C??digo de Integra????o do Item.
 * @pw_complex nfProdInt
 */
class nfProdInt{
	/**
	 * C??digo do Produto
	 *
	 * @var integer
	 */
	public $nCodProd;
	/**
	 * C??digo de Integra????o do produto.
	 *
	 * @var string
	 */
	public $cCodProdInt;
	/**
	 * C??digo do item
	 *
	 * @var integer
	 */
	public $nCodItem;
	/**
	 * C??digo de Integra????o do Item.
	 *
	 * @var string
	 */
	public $cCodItemInt;
}

/**
 * TAG de grupo do detalhamento de Produtos e Servi??os da NF-e
 *
 * @pw_element string $cProd C??digo do produto ou servi??o
 * @pw_element string $cEAN GTIN (Global Trade Item Number) da unidade tribut??vel, antigo c??digo EAN ou c??digo de barras
 * @pw_element string $xProd Descri????o do produto ou servi??o
 * @pw_element string $NCM C??digo do NCM
 * @pw_element string $EXTIPI C??digo da situa????o tribut??ria ICMS
 * @pw_element string $CFOP C??digo Fiscal de Opera????es e Presta????es
 * @pw_element string $uCom Unidade Tribut??vel
 * @pw_element decimal $qCom Quantidade Comercial
 * @pw_element decimal $vUnCom Valor Unit??rio de tributa????o
 * @pw_element decimal $vProd Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
 * @pw_element string $cEANTrib GTIN (Global Trade Item Number) da unidade tribut??vel, antigo c??digo EAN ou c??digo de barras
 * @pw_element string $uTrib Unidade Tribut??vel
 * @pw_element decimal $qTrib Quantidade Tribut??vel
 * @pw_element decimal $vUnTrib Valor Unit??rio de tributa????o
 * @pw_element decimal $vFrete Valor Total do Frete
 * @pw_element decimal $vSeg Valor Total do Seguro
 * @pw_element decimal $vDesc Valor do Desconto
 * @pw_element decimal $vOutro Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $indTot Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
 * @pw_complex prod
 */
class prod{
	/**
	 * C??digo do produto ou servi??o
	 *
	 * @var string
	 */
	public $cProd;
	/**
	 * GTIN (Global Trade Item Number) da unidade tribut??vel, antigo c??digo EAN ou c??digo de barras
	 *
	 * @var string
	 */
	public $cEAN;
	/**
	 * Descri????o do produto ou servi??o
	 *
	 * @var string
	 */
	public $xProd;
	/**
	 * C??digo do NCM
	 *
	 * @var string
	 */
	public $NCM;
	/**
	 * C??digo da situa????o tribut??ria ICMS
	 *
	 * @var string
	 */
	public $EXTIPI;
	/**
	 * C??digo Fiscal de Opera????es e Presta????es
	 *
	 * @var string
	 */
	public $CFOP;
	/**
	 * Unidade Tribut??vel
	 *
	 * @var string
	 */
	public $uCom;
	/**
	 * Quantidade Comercial
	 *
	 * @var decimal
	 */
	public $qCom;
	/**
	 * Valor Unit??rio de tributa????o
	 *
	 * @var decimal
	 */
	public $vUnCom;
	/**
	 * Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
	 *
	 * @var decimal
	 */
	public $vProd;
	/**
	 * GTIN (Global Trade Item Number) da unidade tribut??vel, antigo c??digo EAN ou c??digo de barras
	 *
	 * @var string
	 */
	public $cEANTrib;
	/**
	 * Unidade Tribut??vel
	 *
	 * @var string
	 */
	public $uTrib;
	/**
	 * Quantidade Tribut??vel
	 *
	 * @var decimal
	 */
	public $qTrib;
	/**
	 * Valor Unit??rio de tributa????o
	 *
	 * @var decimal
	 */
	public $vUnTrib;
	/**
	 * Valor Total do Frete
	 *
	 * @var decimal
	 */
	public $vFrete;
	/**
	 * Valor Total do Seguro
	 *
	 * @var decimal
	 */
	public $vSeg;
	/**
	 * Valor do Desconto
	 *
	 * @var decimal
	 */
	public $vDesc;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vOutro;
	/**
	 * Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)
	 *
	 * @var decimal
	 */
	public $indTot;
}

/**
 * Grupo de Valores Totais referentes ao ICMS
 *
 * @pw_element decimal $vBC Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vICMS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vBCST Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vST Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vProd Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vFrete Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vSeg Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vDesc Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vII Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vIPI Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vPIS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vCOFINS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vOutro Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vNF Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vTotTrib Valor aproximado total de tributos federais, estaduais e municipais
 * @pw_complex ICMSTot
 */
class ICMSTot{
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vBC;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vICMS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vBCST;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vST;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vProd;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vFrete;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vSeg;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vDesc;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vII;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vIPI;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vPIS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vCOFINS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vOutro;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vNF;
	/**
	 * Valor aproximado total de tributos federais, estaduais e municipais
	 *
	 * @var decimal
	 */
	public $vTotTrib;
}

/**
 * Grupo de Valores Totais referentes ao ISSQN
 *
 * @pw_element decimal $vServ Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vBC Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vISS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vPIS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vCOFINS Valor da Reten????o da Previd??ncia Social
 * @pw_complex ISSQNtot
 */
class ISSQNtot{
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vServ;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vBC;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vISS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vPIS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vCOFINS;
}

/**
 * Grupo de Reten????es de Tributos
 *
 * @pw_element decimal $vRetPIS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vRetCOFINS Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vRetCSLL Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vBCIRRF Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vIRRF Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vBCRetPrev Valor da Reten????o da Previd??ncia Social
 * @pw_element decimal $vRetPrev Valor da Reten????o da Previd??ncia Social
 * @pw_complex retTrib
 */
class retTrib{
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vRetPIS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vRetCOFINS;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vRetCSLL;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vBCIRRF;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vIRRF;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vBCRetPrev;
	/**
	 * Valor da Reten????o da Previd??ncia Social
	 *
	 * @var decimal
	 */
	public $vRetPrev;
}

/**
 * Erro gerado pela aplica????o.
 *
 * @pw_element integer $code Codigo do erro
 * @pw_element string $description Descricao do erro
 * @pw_element string $referer Origem do erro
 * @pw_element boolean $fatal Indica se eh um erro fatal
 * @pw_complex omie_fail
 */
class omie_fail{
	/**
	 * Codigo do erro
	 *
	 * @var integer
	 */
	public $code;
	/**
	 * Descricao do erro
	 *
	 * @var string
	 */
	public $description;
	/**
	 * Origem do erro
	 *
	 * @var string
	 */
	public $referer;
	/**
	 * Indica se eh um erro fatal
	 *
	 * @var boolean
	 */
	public $fatal;
}
CREATE TABLE IF NOT EXISTS `cadastro` (
  `CODCADASTRO` char(32) NOT NULL DEFAULT '',
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPO_CONTA` char(2) DEFAULT NULL,
  `NOME_RAZAO_SOCIAL` varchar(100) DEFAULT NULL,
  `CPF_CNPJ` char(14) DEFAULT NULL,
  `EMAIL` varchar(32) DEFAULT NULL,
  `SENHA` char(32) DEFAULT NULL,
  `SEXO` char(1) DEFAULT NULL,
  `PAPEL` varchar(255) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  PRIMARY KEY (`CODCADASTRO`)
);

INSERT INTO `cadastro` (`CODCADASTRO`,`TIPO_CONTA`,`NOME_RAZAO_SOCIAL`,`CPF_CNPJ`,`EMAIL`,`SENHA`,`SEXO`,`PAPEL`,`STATUS`) VALUES
('71F8F8E9B09606EE49C65E9CC20F5927','pf','Rogerio de Almeida Pontes','82929750120','rogerio@designlab.com.br','9241E1A4CAD0A7D0BDD5E24DED3B3B8E','M','MASTER;',1);

CREATE TABLE IF NOT EXISTS `enderecos` (
  `CODENDERECO` char(32) NOT NULL,
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CEP` char(9) DEFAULT NULL,
  `LOGRADOURO` varchar(255) DEFAULT NULL,
  `NUMERO` varchar(255) DEFAULT NULL,
  `COMPLEMENTO` varchar(255) DEFAULT NULL,
  `UF` char(2) DEFAULT NULL,
  `CIDADE` varchar(255) DEFAULT NULL,
  `BAIRRO` varchar(255) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  PRIMARY KEY (`CODENDERECO`)
);

CREATE TABLE IF NOT EXISTS `cadastro_rel_enderecos` (
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CODCADASTRO` char(32)  NOT NULL,
  `CODENDERECO` char(32)  NOT NULL,
  PRIMARY KEY (`CODCADASTRO`,`CODENDERECO`)
);

CREATE TABLE IF NOT EXISTS `contas` (
  `CODCONTA` char(32) NOT NULL,
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AGECIA` varchar(20) DEFAULT NULL,
  `AGECIA_DIGITO` varchar(10) DEFAULT NULL,
  `NUMERO` varchar(255) DEFAULT NULL,
  `CIDADE` varchar(255) DEFAULT NULL,
  `BAIRRO` varchar(255) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  PRIMARY KEY (`CODCONTA`)
);

CREATE TABLE IF NOT EXISTS `cadastro_rel_contas` (
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CODCADASTRO` char(32)  NOT NULL,
  `CODCONTA` char(32)  NOT NULL,
  PRIMARY KEY (`CODCADASTRO`,`CODCONTA`)
);

CREATE TABLE IF NOT EXISTS `bancos` (
  `CODBANCO` int NOT NULL PRIMARY KEY,
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CODIGO` varchar(10) DEFAULT NULL,
  `NOME` varchar(255) DEFAULT NULL,
  `NUMERO` varchar(255) DEFAULT NULL,
  `SITE` varchar(255) DEFAULT NULL,
  `STATUS` char(1) DEFAULT '1'
);

INSERT INTO `bancos`(`CODIGO`,`NOME`,`SITE`)VALUES('654','Banco A.J.Renner S.A.',''),
('246','Banco ABC Brasil S.A.','www.abcbrasil.com.br'),
('025','Banco Alfa S.A.','www.bancoalfa.com.br'),
('641','Banco Alvorada S.A.',''),
('213','Banco Arbi S.A.','www.arbi.com.br'),
('019','Banco Azteca do Brasil S.A.',''),
('029','Banco Banerj S.A.','www.banerj.com.br'),
('000','Banco Bankpar S.A.','www.aexp.com'),
('740','Banco Barclays S.A.','www.barclays.com'),
('107','Banco BBM S.A.','www.bbmbank.com.br'),
('031','Banco Beg S.A.','www.itau.com.br'),
('739','Banco BGN S.A.','www.bgn.com.br'),
('096','Banco BM&F de Serviços de Liquidação e Custódia S.A','www.bmf.com.br'),
('318','Banco BMG S.A.','www.bancobmg.com.br'),
('752','Banco BNP Paribas Brasil S.A.','www.bnpparibas.com.br'),
('248','Banco Boavista Interatlântico S.A.',''),
('218','Banco Bonsucesso S.A.','www.bancobonsucesso.com.br'),
('065','Banco Bracce S.A.','www.lemon.com'),
('036','Banco Bradesco BBI S.A.',''),
('204','Banco Bradesco Cartões S.A.','www.iamex.com.br'),
('394','Banco Bradesco Financiamentos S.A.','www.bmc.com.br'),
('237','Banco Bradesco S.A.','www.bradesco.com.br'),
('225','Banco Brascan S.A.','www.bancobrascan.com.br'),
('M15','Banco BRJ S.A.','www.brjbank.com.br'),
('208','Banco BTG Pactual S.A.','www.pactual.com.br'),
('044','Banco BVA S.A.','www.bancobva.com.br'),
('263','Banco Cacique S.A.','www.bancocacique.com.br'),
('473','Banco Caixa Geral - Brasil S.A.',''),
('412','Banco Capital S.A.','www.bancocapital.com.br'),
('040','Banco Cargill S.A.','www.bancocargill.com.br'),
('745','Banco Citibank S.A.','www.citibank.com.br'),
('M08','Banco Citicard S.A.','www.credicardbanco.com.br'),
('241','Banco Clássico S.A.',''),
('M19','Banco CNH Capital S.A.','www.bancocnh.com.br'),
('215','Banco Comercial e de Investimento Sudameris S.A.','www.sudameris.com.br'),
('756','Banco Cooperativo do Brasil S.A. - BANCOOB','www.bancoob.com.br'),
('748','Banco Cooperativo Sicredi S.A.','www.sicredi.com.br'),
('075','Banco CR2 S.A.','www.bancocr2.com.br'),
('721','Banco Credibel S.A.','www.credibel.com.br'),
('222','Banco Credit Agricole Brasil S.A.','www.calyon.com.br'),
('505','Banco Credit Suisse (Brasil) S.A.','www.csfb.com'),
('229','Banco Cruzeiro do Sul S.A.','www.bcsul.com.br'),
('266','Banco Cédula S.A.','www.bancocedula.com.br'),
('003','Banco da Amazônia S.A.','www.bancoamazonia.com.br'),
('083-3','Banco da China Brasil S.A.',''),
('M21','Banco Daimlerchrysler S.A.','www.bancodaimlerchrysler.com.br'),
('707','Banco Daycoval S.A.','www.daycoval.com.br'),
('300','Banco de La Nacion Argentina','www.bna.com.ar'),
('495','Banco de La Provincia de Buenos Aires','www.bapro.com.ar'),
('494','Banco de La Republica Oriental del Uruguay',''),
('M06','Banco de Lage Landen Brasil S.A.','www.delagelanden.com'),
('024','Banco de Pernambuco S.A. - BANDEPE','www.bandepe.com.br'),
('456','Banco de Tokyo-Mitsubishi UFJ Brasil S.A.','www.btm.com.br'),
('214','Banco Dibens S.A.','www.bancodibens.com.br'),
('001','Banco do Brasil S.A.','www.bb.com.br'),
('047','Banco do Estado de Sergipe S.A.','www.banese.com.br'),
('037','Banco do Estado do Pará S.A.','www.banparanet.com.br'),
('039','Banco do Estado do Piauí S.A. - BEP','www.bep.com.br'),
('041','Banco do Estado do Rio Grande do Sul S.A.','www.banrisul.com.br'),
('004','Banco do Nordeste do Brasil S.A.','www.banconordeste.gov.br'),
('265','Banco Fator S.A.','www.bancofator.com.br'),
('M03','Banco Fiat S.A.','www.bancofiat.com.br'),
('224','Banco Fibra S.A.','www.bancofibra.com.br'),
('626','Banco Ficsa S.A.','www.ficsa.com.br'),
('M18','Banco Ford S.A.','www.bancoford.com.br'),
('233','Banco GE Capital S.A.','www.ge.com.br'),
('734','Banco Gerdau S.A.','www.bancogerdau.com.br'),
('M07','Banco GMAC S.A.','www.bancogm.com.br'),
('612','Banco Guanabara S.A.','www.bcoguan.com.br'),
('M22','Banco Honda S.A.','www.bancohonda.com.br'),
('063','Banco Ibi S.A.','Banco Múltiplo	www.ibi.com.br'),
('M11','Banco IBM S.A.','www.ibm.com/br/financing/'),
('604','Banco Industrial do Brasil S.A.','www.bancoindustrial.com.br'),
('320','Banco Industrial e Comercial S.A.','www.bicbanco.com.br'),
('653','Banco Indusval S.A.','www.indusval.com.br'),
('630','Banco Intercap S.A.','www.intercap.com.br'),
('077-9','Banco Intermedium S.A.','www.intermedium.com.br'),
('249','Banco Investcred Unibanco S.A.',''),
('M09','Banco Itaucred Financiamentos S.A.','www.itaucred.com.br'),
('184','Banco Itaú BBA S.A.','www.itaubba.com.br'),
('479','Banco ItaúBank S.A','www.itaubank.com.br'),
('376','Banco J. P. Morgan S.A.','www.jpmorgan.com'),
('074','Banco J. Safra S.A.','www.jsafra.com.br'),
('217','Banco John Deere S.A.','www.johndeere.com.br'),
('076','Banco KDB S.A.','www.bancokdb.com.br'),
('757','Banco KEB do Brasil S.A.','www.bancokeb.com.br'),
('600','Banco Luso Brasileiro S.A.','www.lusobrasileiro.com.br'),
('212','Banco Matone S.A.','www.bancomatone.com.br'),
('M12','Banco Maxinvest S.A.','www.bancomaxinvest.com.br'),
('389','Banco Mercantil do Brasil S.A.','www.mercantil.com.br'),
('746','Banco Modal S.A.','www.bancomodal.com.br'),
('M10','Banco Moneo S.A.','www.bancomoneo.com.br'),
('738','Banco Morada S.A.','www.bancomorada.com.br'),
('066','Banco Morgan Stanley S.A.','www.morganstanley.com.br'),
('243','Banco Máxima S.A.','www.bancomaxima.com.br'),
('045','Banco Opportunity S.A.','www.opportunity.com.br'),
('M17','Banco Ourinvest S.A.','www.ourinvest.com.br'),
('623','Banco Panamericano S.A.','www.panamericano.com.br'),
('611','Banco Paulista S.A.','www.bancopaulista.com.br'),
('613','Banco Pecúnia S.A.','www.bancopecunia.com.br'),
('094-2','Banco Petra S.A.','www.personaltrader.com.br'),
('643','Banco Pine S.A.','www.bancopine.com.br'),
('724','Banco Porto Seguro S.A.',''),
('735','Banco Pottencial S.A.','www.pottencial.com.br'),
('638','Banco Prosper S.A.','www.bancoprosper.com.br'),
('M24','Banco PSA Finance Brasil S.A.',''),
('747','Banco Rabobank International Brasil S.A.','www.rabobank.com.br'),
('088-4','Banco Randon S.A.',''),
('356','Banco Real S.A.','www.bancoreal.com.br'),
('633','Banco Rendimento S.A.','www.rendimento.com.br'),
('741','Banco Ribeirão Preto S.A.','www.brp.com.br'),
('M16','Banco Rodobens S.A.','www.rodobens.com.br'),
('072','Banco Rural Mais S.A.','www.rural.com.br'),
('453','Banco Rural S.A.','www.rural.com.br'),
('422','Banco Safra S.A.','www.safra.com.br'),
('033','Banco Santander (Brasil) S.A.','www.santander.com.br'),
('250','Banco Schahin S.A.','www.bancoschahin.com.br'),
('743','Banco Semear S.A.','www.bancosemear.com.br'),
('749','Banco Simples S.A.','www.bancosimples.com.br'),
('366','Banco Société Générale Brasil S.A.','www.sgbrasil.com.br'),
('637','Banco Sofisa S.A.','www.sofisa.com.br'),
('012','Banco Standard de Investimentos S.A.','www.standardbank.com'),
('464','Banco Sumitomo Mitsui Brasileiro S.A.',''),
('082-5','Banco Topázio S.A.','www.bancotopazio.com.br'),
('M20','Banco Toyota do Brasil S.A.','www.bancotoyota.com.br'),
('M13','Banco Tricury S.A.','www.tricury.com.br'),
('634','Banco Triângulo S.A.','www.tribanco.com.br'),
('M14','Banco Volkswagen S.A.','www.bancovw.com.br'),
('M23','Banco Volvo (Brasil) S.A.',''),
('655','Banco Votorantim S.A.','www.bancovotorantim.com.br'),
('610','Banco VR S.A.','www.vr.com.br'),
('370','Banco WestLB do Brasil S.A.','www.westlb.com.br'),
('021','BANESTES S.A. Banco do Estado do Espírito Santo','www.banestes.com.br'),
('719','Banif-Banco Internacional do Funchal (Brasil)S.A.','www.banif.com.br'),
('755','Bank of America Merrill Lynch Banco Múltiplo S.A.','www.ml.com'),
('744','BankBoston N.A.','www.bankboston.com.br'),
('073','BB Banco Popular do Brasil S.A.','www.bancopopulardobrasil.com.br'),
('078','BES Investimento do Brasil S.A.-Banco de Investimento','www.besinvestimento.com.br'),
('069','BPN Brasil Banco Múltiplo S.A.','www.bpnbrasil.com.br'),
('070','BRB - Banco de Brasília S.A.','www.brb.com.br'),
('092-2','Brickell S.A. Crédito, financiamento e Investimento',''),
('104','Caixa Econômica Federal','www.caixa.gov.br'),
('477','Citibank N.A.','www.citibank.com/brasil'),
('081-7','Concórdia Banco S.A.','www.concordiabanco.com'),
('097-3','Cooperativa Central de Crédito Noroeste Brasileiro Ltda.',''),
('085-x','Cooperativa Central de Crédito Urbano-CECRED',''),
('099-x','Cooperativa Central de Economia e Credito Mutuo das Unicreds',''),
('090-2','Cooperativa Central de Economia e Crédito Mutuo das Unicreds',''),
('089-2','Cooperativa de Crédito Rural da Região de Mogiana',''),
('087-6','Cooperativa Unicred Central Santa Catarina',''),
('098-1','Credicorol Cooperativa de Crédito Rural',''),
('487','Deutsche Bank S.A. - Banco Alemão','www.deutsche-bank.com.br'),
('751','Dresdner Bank Brasil S.A. - Banco Múltiplo','www.dkib.com.br'),
('064','Goldman Sachs do Brasil Banco Múltiplo S.A.','www.goldmansachs.com'),
('062','Hipercard Banco Múltiplo S.A.','www.hipercard.com.br'),
('399','HSBC Bank Brasil S.A. - Banco Múltiplo','www.hsbc.com.br'),
('168','HSBC Finance (Brasil) S.A. - Banco Múltiplo',''),
('492','ING Bank N.V.','www.ing.com'),
('652','Itaú Unibanco Holding S.A.','www.itau.com.br'),
('341','Itaú Unibanco S.A.','www.itau.com.br'),
('079','JBS Banco S.A.','www.bancojbs.com.br'),
('488','JPMorgan Chase Bank','www.jpmorganchase.com'),
('014','Natixis Brasil S.A. Banco Múltiplo',''),
('753','NBC Bank Brasil S.A. - Banco Múltiplo','www.nbcbank.com.br'),
('086-8','OBOE Crédito Financiamento e Investimento S.A.',''),
('254','Paraná Banco S.A.','www.paranabanco.com.br'),
('409','UNIBANCO - União de Bancos Brasileiros S.A.','www.unibanco.com.br'),
('230','Unicard Banco Múltiplo S.A.','www.unicard.com.br'),
('091-4','Unicred Central do Rio Grande do Sul','www.unicred-rs.com.br'),
('084','Unicred Norte do Paraná','');

CREATE TABLE IF NOT EXISTS `cadastro_rel_bancos` (
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CODCADASTRO` char(32)  NOT NULL,
  `CODBANCO` int(11)  NOT NULL,
  PRIMARY KEY (`CODCADASTRO`,`CODBANCO`)
);



--
-- Estrutura da tabela `pessoa`
--









CREATE TABLE IF NOT EXISTS `conta` (
  `CODCONTA` char(32) NOT NULL DEFAULT '',
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NOME` varchar(70) DEFAULT NULL,
  `EMAIL` varchar(32) DEFAULT NULL,
  `SENHA` char(32) DEFAULT NULL,
  `SEXO` char(1) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  PRIMARY KEY (`CODCONTA`)
);




CREATE TABLE IF NOT EXISTS `fotos` (
  `CODFOTO` char(32) NOT NULL DEFAULT '',
  `DTA` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RAIZ` varchar(255) DEFAULT NULL,
  `FORMATO` varchar(255) DEFAULT NULL,
  `NOME` varchar(255) DEFAULT NULL,
  `TIPO` varchar(30) DEFAULT NULL,
  `ORIGINAL` varchar(255) DEFAULT NULL,
  `CROP` varchar(255) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL,
  `ORDEM` int(11) DEFAULT NULL,
  `DESTAQUE` char(1) DEFAULT '0',
  PRIMARY KEY (`CODFOTO`)
);

CREATE TABLE IF NOT EXISTS `fotos_rel_produtos` (
  `CODFOTO` char(32) NOT NULL DEFAULT '',
  `CODPRODUTO` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`CODFOTO`, `CODPRODUTO`)
);

-- http://www.webresourcesdepot.com/dynamic-dragn-drop-with-jquery-and-php/
-- http://www.webresourcesdepot.com/wp-content/uploads/file/jquerydragdrop/
-- http://www.webresourcesdepot.com/dynamic-dragn-drop-with-jquery-and-php/
-- http://johnny.github.io/jquery-sortable/










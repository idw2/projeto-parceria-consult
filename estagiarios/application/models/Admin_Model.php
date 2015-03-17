<?php

class Admin_Model extends Model {

    public function existe_cadastro($email_or_cpf_or_cnpj_or_id) {
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE EMAIL=:EMAIL OR CPF_CNPJ=:CPF_CNPJ OR ID=:ID");
        $query->bindParam(":EMAIL", $email_or_cpf_or_cnpj_or_id, PDO::PARAM_STR, 70);
        $query->bindParam(":CPF_CNPJ", $email_or_cpf_or_cnpj_or_id, PDO::PARAM_STR, 14);
        $query->bindParam(":ID", $email_or_cpf_or_cnpj_or_id, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_id($id) {
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE ID=:ID");
        $query->bindParam(":ID", $id, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }
    
    public function existe_email($id) {
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE EMAIL=:EMAIL");
        $query->bindParam(":EMAIL", $id, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }
    
    public function existe_avaliacao($coddadoscomplementares) {
        $query = $this->db->prepare("SELECT * FROM avaliacoes WHERE CODDADOSCOMPLEMENTARES=:CODDADOSCOMPLEMENTARES");
        $query->bindParam(":CODDADOSCOMPLEMENTARES", $coddadoscomplementares, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }
    
    public function existe_ficha_desligamento($coddadoscomplementares) {
        $query = $this->db->prepare("SELECT * FROM ficha_desligamento WHERE CODDADOSCOMPLEMENTARES=:CODDADOSCOMPLEMENTARES");
        $query->bindParam(":CODDADOSCOMPLEMENTARES", $coddadoscomplementares, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }
    
    public function existe_questionario_estagiario($coddadoscomplementares) {
        $query = $this->db->prepare("SELECT * FROM questionario_estagiario WHERE CODDADOSCOMPLEMENTARES=:CODDADOSCOMPLEMENTARES");
        $query->bindParam(":CODDADOSCOMPLEMENTARES", $coddadoscomplementares, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_conta_bancaria($codcadastro) {
        $query = $this->db->prepare("SELECT * FROM contas
INNER JOIN cadastro_rel_contas ON cadastro_rel_contas.CODCONTA=contas.CODCONTA
WHERE cadastro_rel_contas.CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_quantos_primeiro_acesso($email_or_cpf_or_cnpj) {
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE SENHA=:SENHA AND EMAIL=:EMAIL OR CPF_CNPJ=:CPF_CNPJ");
        $query->bindParam(":EMAIL", $email_or_cpf_or_cnpj, PDO::PARAM_STR, 70);
        $query->bindParam(":CPF_CNPJ", $email_or_cpf_or_cnpj, PDO::PARAM_STR, 14);
        $query->bindParam(":SENHA", $teste, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_iniciais($iniciais) {
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE ID=:ID");
        $query->bindParam(":ID", $iniciais, PDO::PARAM_STR, 20);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_administrador_rel_empresa($cpf, $codempresa) {
        $query = $this->db->prepare("SELECT cadastro.* FROM cadastro
INNER JOIN cadastro_rel_administradores ON cadastro_rel_administradores.CODCADASTRO=cadastro.CODCADASTRO
WHERE cadastro.CPF_CNPJ=:CPF_CNPJ AND cadastro_rel_administradores.CODEMPRESA_ENTIDADE='{$codempresa}'");
        $query->bindParam(":CPF_CNPJ", $cpf, PDO::PARAM_STR, 14);
        $query->execute();
        return $query->rowCount();
    }

    public function existe_estagiario_rel_empresa($cpf, $codempresa) {
        $query = $this->db->prepare("SELECT cadastro.* FROM cadastro
INNER JOIN cadastro_rel_estagiarios ON cadastro_rel_estagiarios.CODCADASTRO=cadastro.CODCADASTRO
WHERE cadastro.CPF_CNPJ=:CPF_CNPJ AND cadastro_rel_estagiarios.CODEMPRESA_ENTIDADE='{$codempresa}'");
        $query->bindParam(":CPF_CNPJ", $cpf, PDO::PARAM_STR, 14);
        $query->execute();
        return $query->rowCount();
    }

    public function confere_senha($email_or_id, $senha, $papel = null) {

        if ($papel != null) {
            $and = "AND PAPEL=:PAPEL";
        }

        $query = $this->db->prepare("SELECT * FROM cadastro WHERE (EMAIL=:EMAIL OR ID=:ID) AND SENHA=:SENHA {$and}");
        $query->bindParam(":EMAIL", $email_or_id, PDO::PARAM_STR, 70);
        $query->bindParam(":ID", $email_or_id, PDO::PARAM_STR, 20);
        $query->bindParam(":SENHA", $senha, PDO::PARAM_STR, 32);
        if ($papel != null) {
            $query->bindParam(":PAPEL", $papel, PDO::PARAM_STR, 255);
        }
        $query->execute();
        return $query->rowCount();
    }

    public function confere_senha_login($email, $id, $senha) {

        $query = $this->db->prepare("SELECT * FROM cadastro WHERE (EMAIL=:EMAIL OR ID=:ID) AND SENHA=:SENHA");
        $query->bindParam(":EMAIL", $email, PDO::PARAM_STR, 70);
        $query->bindParam(":ID", $id, PDO::PARAM_STR, 20);
        $query->bindParam(":SENHA", $senha, PDO::PARAM_STR, 32);
        if ($papel != null) {
            $query->bindParam(":PAPEL", $papel, PDO::PARAM_STR, 255);
        }
        $query->execute();
        return $query->rowCount();
    }

    public function testa_status($email_or_id, $senha) {
        $query = $this->db->prepare("SELECT * FROM cadastro WHERE (EMAIL=:EMAIL OR ID=:ID) AND SENHA=:SENHA AND STATUS=1");
        $query->bindParam(":ID", $email_or_id, PDO::PARAM_STR, 70);
        $query->bindParam(":EMAIL", $email_or_id, PDO::PARAM_STR, 70);
        $query->bindParam(":SENHA", $senha, PDO::PARAM_STR, 32);
        $query->execute();
        return $query->rowCount();
    }

    public function get_dados_conta($email_or_cpf_or_cnpj_or_codcadastro_or_id) {
        $this->_tabela = "cadastro";
        $where = "EMAIL='{$email_or_cpf_or_cnpj_or_codcadastro_or_id}' OR CPF_CNPJ='{$email_or_cpf_or_cnpj_or_codcadastro_or_id}' OR CODCADASTRO='{$email_or_cpf_or_cnpj_or_codcadastro_or_id}' OR ID='{$email_or_cpf_or_cnpj_or_codcadastro_or_id}'";
        return $this->read($where);
    }

    public function update_senha($codcadastro, $senha_nova, $lembrete) {
        $query = $this->db->prepare("UPDATE cadastro SET SENHA=:SENHA, LEMBRETE=:LEMBRETE WHERE CODCADASTRO=:CODCADASTRO");
        $query->bindParam(":CODCADASTRO", $codcadastro, PDO::PARAM_STR, 32);
        $query->bindParam(":SENHA", $senha_nova, PDO::PARAM_STR, 32);
        $query->bindParam(":LEMBRETE", $lembrete, PDO::PARAM_STR, 255);
        $query->execute();
        return true;
    }

    public function insert_dados_complementares(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `dados_complementares` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 32);
            $query->bindParam(":DTA_INICIO", $dados["DTA_INICIO"]);
            $query->bindParam(":DTA_FIM", $dados["DTA_FIM"]);
            if($dados["DTA_DESLIGAMENTO"] != ""){
                $query->bindParam(":DTA_DESLIGAMENTO", $dados["DTA_DESLIGAMENTO"]);
            }
            $query->bindParam(":BOLSA_VALOR", $dados["BOLSA_VALOR"], PDO::PARAM_INT);
            $query->bindParam(":CARGA_HORARIA", $dados["CARGA_HORARIA"], PDO::PARAM_STR);
            $query->bindParam(":INTITUICAO_ENSINO", $dados["INTITUICAO_ENSINO"], PDO::PARAM_STR, 255);
            $query->bindParam(":CARGO", $dados["CARGO"], PDO::PARAM_STR, 255);
            $query->bindParam(":CURSO", $dados["CURSO"], PDO::PARAM_STR, 255);
            $query->bindParam(":CARGA_HORARIA_OBS", $dados["CARGA_HORARIA_OBS"], PDO::PARAM_STR, 255);
            $query->bindParam(":REPRESENTANTE_INTITUICAO", $dados["REPRESENTANTE_INTITUICAO"], PDO::PARAM_STR, 255);
            $query->bindParam(":CARGO_REPRESENTANTE", $dados["CARGO_REPRESENTANTE"], PDO::PARAM_STR, 255);
            $query->bindParam(":CTPS", $dados["CTPS"], PDO::PARAM_STR, 70);
            $query->bindParam(":SERIE", $dados["SERIE"], PDO::PARAM_STR, 70);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_ficha_desligamento(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `ficha_desligamento` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODFICHADESLIGAMENTO", $dados["CODFICHADESLIGAMENTO"], PDO::PARAM_STR, 32);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_questionario_estagiario(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `questionario_estagiario` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODQUESTIONARIOESTAGIARIO", $dados["CODQUESTIONARIOESTAGIARIO"], PDO::PARAM_STR, 32);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_cadastro_rel_dados_complementares(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro_rel_dados_complementares` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_cadastro_empresa_entidade(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":OWNER", $dados["OWNER"], PDO::PARAM_STR, 32);
            $query->bindParam(":TIPO_CONTA", $dados["TIPO_CONTA"], PDO::PARAM_STR, 2);
            $query->bindParam(":ID", $dados["ID"], PDO::PARAM_STR, 20);
            $query->bindParam(":NOME_RAZAO_SOCIAL", $dados["NOME_RAZAO_SOCIAL"], PDO::PARAM_STR, 100);
            $query->bindParam(":CPF_CNPJ", $dados["CPF_CNPJ"], PDO::PARAM_STR, 14);
            $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":PAPEL", $dados["PAPEL"], PDO::PARAM_STR, 255);
            $query->bindParam(":NASCIMENTO_FUNDACAO", $dados["NASCIMENTO_FUNDACAO"], PDO::PARAM_STR);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            if ($dados["SITE"] != "" || $dados["SITE"] != null) {
                $query->bindParam(":SITE", $dados["SITE"], PDO::PARAM_STR, 100);
            }

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_avaliacao(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `avaliacoes` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODAVALIACAO", $dados["CODAVALIACAO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 32);
            $query->bindParam(":RENOVACAO", $dados["RENOVACAO"], PDO::PARAM_STR);
            $query->bindParam(":QUAL_METODO", $dados["QUAL_METODO"], PDO::PARAM_LOB);
            $query->bindParam(":DIAS_HORARIOS", $dados["DIAS_HORARIOS"], PDO::PARAM_LOB);
            $query->bindParam(":ASSIDUIDADE", $dados["ASSIDUIDADE"], PDO::PARAM_STR);
            $query->bindParam(":CRESCIMENTO", $dados["CRESCIMENTO"], PDO::PARAM_STR);
            $query->bindParam(":CAPACIDADE", $dados["CAPACIDADE"], PDO::PARAM_STR);
            $query->bindParam(":COOPERACAO", $dados["COOPERACAO"], PDO::PARAM_STR);
            $query->bindParam(":CUMPRIMENTO", $dados["CUMPRIMENTO"], PDO::PARAM_STR);
            $query->bindParam(":DINAMISMO", $dados["DINAMISMO"], PDO::PARAM_STR);
            $query->bindParam(":FLEXIBILIDADE", $dados["FLEXIBILIDADE"], PDO::PARAM_STR);
            $query->bindParam(":INICIATIVA", $dados["INICIATIVA"], PDO::PARAM_STR);
            $query->bindParam(":INTERESSE", $dados["INTERESSE"], PDO::PARAM_STR);
            $query->bindParam(":MOTIVACAO", $dados["MOTIVACAO"], PDO::PARAM_STR);
            $query->bindParam(":ORGANIZACAO", $dados["ORGANIZACAO"], PDO::PARAM_STR);
            $query->bindParam(":PONTUALIDADE", $dados["PONTUALIDADE"], PDO::PARAM_STR);
            $query->bindParam(":RELACIONAMENTO", $dados["RELACIONAMENTO"], PDO::PARAM_STR);
            $query->bindParam(":RESPEITO", $dados["RESPEITO"], PDO::PARAM_STR);
            $query->bindParam(":RESPONSABILIDADE", $dados["RESPONSABILIDADE"], PDO::PARAM_STR);
            $query->bindParam(":RESULTADO", $dados["RESULTADO"], PDO::PARAM_STR);
            $query->bindParam(":COMENTARIOS", $dados["COMENTARIOS"], PDO::PARAM_LOB);
            $query->bindParam(":PARCERIA", $dados["PARCERIA"], PDO::PARAM_LOB);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_solicitacao_estagio_and_informatica(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));
            
            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio_and_informatica` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODINFORMATICA", $dados["CODINFORMATICA"], PDO::PARAM_STR, 32);
            $query->bindParam(":INFORMATICA", $dados["INFORMATICA"], PDO::PARAM_STR, 255);
            $query->bindParam(":ORDEM", $dados["ORDEM"], PDO::PARAM_INT);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_solicitacao_estagio_and_idiomas(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));
            
            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio_and_idiomas` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODIDIOMA", $dados["CODIDIOMA"], PDO::PARAM_STR, 32);
            $query->bindParam(":IDIOMA", $dados["IDIOMA"], PDO::PARAM_STR, 255);
            $query->bindParam(":ORDEM", $dados["ORDEM"], PDO::PARAM_INT);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_solicitacao_estagio_and_beneficios(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));
            
            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio_and_beneficios` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODBENEFICIO", $dados["CODBENEFICIO"], PDO::PARAM_STR, 32);
            $query->bindParam(":BENEFICIO", $dados["BENEFICIO"], PDO::PARAM_STR, 255);
            $query->bindParam(":ORDEM", $dados["ORDEM"], PDO::PARAM_INT);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_solicitacao_estagio_and_cursos(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));
            
            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio_and_cursos` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCURSO", $dados["CODCURSO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CURSO", $dados["CURSO"], PDO::PARAM_STR, 255);
            $query->bindParam(":PERIODO", $dados["PERIODO"], PDO::PARAM_STR, 2);
            $query->bindParam(":GRAU", $dados["GRAU"], PDO::PARAM_STR);
            $query->bindParam(":ORDEM", $dados["ORDEM"], PDO::PARAM_INT);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_solicitacao_estagio(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));
            
            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio` ({$campos}) VALUES ({$keys});");

            $c = new Controller();
            
            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":SEXO", $dados["SEXO"], PDO::PARAM_STR);
            $query->bindParam(":FAIXA_ETARIA_INICIAL", $dados["FAIXA_ETARIA_INICIAL"], PDO::PARAM_INT);
            $query->bindParam(":FAIXA_ETARIA_FINAL", $dados["FAIXA_ETARIA_FINAL"], PDO::PARAM_INT);
            $query->bindParam(":EST_CIVIL", $dados["EST_CIVIL"], PDO::PARAM_STR, 32);
            $query->bindParam(":IS_IDIOMA", $dados["IS_IDIOMA"], PDO::PARAM_STR);
            $query->bindParam(":IS_INFORMATICA", $dados["IS_INFORMATICA"], PDO::PARAM_STR);
            $query->bindParam(":DEMAIS_REQUISITOS", $dados["DEMAIS_REQUISITOS"], PDO::PARAM_LOB);
            $query->bindParam(":DURACAO", $dados["DURACAO"], PDO::PARAM_STR, 2);
            $query->bindParam(":HORARIO_DE", $dados["HORARIO_DE"], PDO::PARAM_STR, 5);
            $query->bindParam(":HORARIO_ATE", $dados["HORARIO_ATE"], PDO::PARAM_STR, 5);
            $query->bindParam(":HORARIO_MES", $dados["HORARIO_MES"], PDO::PARAM_INT);
            $query->bindParam(":EFETIVACAO", $dados["EFETIVACAO"], PDO::PARAM_STR);
            $query->bindParam(":N_VAGAS", $dados["N_VAGAS"], PDO::PARAM_INT);
            $query->bindParam(":BOLSA_AUXILIO", $dados["BOLSA_AUXILIO"], PDO::PARAM_STR, 20);
            $query->bindParam(":BOLSA_VALOR", $c->limpaValorReal($dados["BOLSA_VALOR"]), PDO::PARAM_INT);
            $query->bindParam(":BOLSA_BENEFICIOS", $dados["BOLSA_BENEFICIOS"], PDO::PARAM_STR, 20);
            $query->bindParam(":VALE_REFEICAO", $dados["VALE_REFEICAO"], PDO::PARAM_STR);
            $query->bindParam(":VALE_TRANSPORTE", $dados["VALE_TRANSPORTE"], PDO::PARAM_STR);
            $query->bindParam(":ASS_MEDICA", $dados["ASS_MEDICA"], PDO::PARAM_STR);
            $query->bindParam(":SUPERVISOR_NOME", $dados["SUPERVISOR_NOME"], PDO::PARAM_STR, 70);
            $query->bindParam(":SUPERVISOR_CARGO", $dados["SUPERVISOR_CARGO"], PDO::PARAM_STR, 70);
            $query->bindParam(":SUPERVISOR_EMAIL", $dados["SUPERVISOR_EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":ATIVIDADES", $dados["ATIVIDADES"], PDO::PARAM_LOB);
            $query->bindParam(":ETAPAS", $dados["ETAPAS"], PDO::PARAM_LOB);
            $query->bindParam(":METODO", $dados["METODO"], PDO::PARAM_LOB);
            

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_cadastro_pf_short(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CPF_CNPJ", $dados["CPF_CNPJ"], PDO::PARAM_STR, 14);
            $query->bindParam(":OWNER", $dados["OWNER"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_cadastro_administrador_empresa_entidade(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":TIPO_CONTA", $dados["TIPO_CONTA"], PDO::PARAM_STR, 2);
            $query->bindParam(":NOME_RAZAO_SOCIAL", $dados["NOME_RAZAO_SOCIAL"], PDO::PARAM_STR, 100);
            $query->bindParam(":CPF_CNPJ", $dados["CPF_CNPJ"], PDO::PARAM_STR, 14);
            $query->bindParam(":EMAIL", $dados["EMAIL"], PDO::PARAM_STR, 70);
            $query->bindParam(":PAPEL", $dados["PAPEL"], PDO::PARAM_STR, 255);
            $query->bindParam(":NASCIMENTO_FUNDACAO", $dados["NASCIMENTO_FUNDACAO"], PDO::PARAM_STR);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);
            $query->bindParam(":SEXO", $dados["SEXO"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_cadastro_planilha(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":TIPO_CONTA", $dados["TIPO_CONTA"], PDO::PARAM_STR, 2);
            $query->bindParam(":NOME_RAZAO_SOCIAL", $dados["NOME_RAZAO_SOCIAL"], PDO::PARAM_STR, 100);
            $query->bindParam(":NOM_MAE", $dados["NOM_MAE"], PDO::PARAM_STR, 100);
            $query->bindParam(":NOM_PAI", $dados["NOM_PAI"], PDO::PARAM_STR, 100);
            $query->bindParam(":CPF_CNPJ", $dados["CPF_CNPJ"], PDO::PARAM_STR, 14);
            $query->bindParam(":RG", $dados["RG"], PDO::PARAM_STR, 70);
            $query->bindParam(":PAPEL", $dados["PAPEL"], PDO::PARAM_STR, 255);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);
            $query->bindParam(":OWNER", $dados["OWNER"], PDO::PARAM_STR, 32);
            
            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_endereco(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `enderecos` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODENDERECO", $dados["CODENDERECO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CEP", $dados["CEP"], PDO::PARAM_STR, 9);
            $query->bindParam(":LOGRADOURO", $dados["LOGRADOURO"], PDO::PARAM_STR, 255);
            $query->bindParam(":NUMERO", $dados["NUMERO"], PDO::PARAM_STR, 255);
            $query->bindParam(":COMPLEMENTO", $dados["COMPLEMENTO"], PDO::PARAM_STR, 255);
            $query->bindParam(":UF", $dados["UF"], PDO::PARAM_STR, 2);
            $query->bindParam(":CIDADE", $dados["CIDADE"], PDO::PARAM_STR, 255);
            $query->bindParam(":BAIRRO", $dados["BAIRRO"], PDO::PARAM_STR, 255);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_telefone(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `telefones` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODTELEFONE", $dados["CODTELEFONE"], PDO::PARAM_STR, 32);
            $query->bindParam(":DDD", $dados["DDD"], PDO::PARAM_STR, 10);
            $query->bindParam(":TELEFONE", $dados["TELEFONE"], PDO::PARAM_STR, 20);
            $query->bindParam(":RAMAL", $dados["RAMAL"], PDO::PARAM_STR, 20);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_solicitacao_estagio_rel_enderecos(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio_rel_enderecos` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODENDERECO", $dados["CODENDERECO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_cadastro_rel_endereco(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro_rel_enderecos` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODENDERECO", $dados["CODENDERECO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_dados_complementares_rel_enderecos(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            #echo "INSERT INTO `dados_complementares_rel_enderecos` ({$campos}) VALUES ({$keys});";
            #exit();
            
            $query = $this->db->prepare("INSERT INTO `dados_complementares_rel_enderecos` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODENDERECO", $dados["CODENDERECO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_cadastro_rel_administradores(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro_rel_administradores` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODEMPRESA_ENTIDADE", $dados["CODEMPRESA_ENTIDADE"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_conta_bancaria(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `contas` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODCONTA", $dados["CODCONTA"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODBANCO", $dados["CODBANCO"], PDO::PARAM_INT);
            $query->bindParam(":AGECIA", $dados["AGECIA"], PDO::PARAM_STR, 20);
            $query->bindParam(":AGECIA_DIGITO", $dados["AGECIA_DIGITO"], PDO::PARAM_STR, 10);
            $query->bindParam(":CC", $dados["CC"], PDO::PARAM_STR, 255);
            $query->bindParam(":STATUS", $dados["STATUS"], PDO::PARAM_STR);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_cadastro_rel_conta_bancaria(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro_rel_contas` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCONTA", $dados["CODCONTA"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_estagiarios_rel_empresas(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `estagiarios_rel_empresas` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODEMPRESA_ENTIDADE", $dados["CODEMPRESA_ENTIDADE"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_estagiarios_rel_administradores(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `estagiarios_rel_administradores` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODADMINISTRADOR", $dados["CODADMINISTRADOR"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function insert_dados_complementares_rel_telefones(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `dados_complementares_rel_telefones` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODTELEFONE", $dados["CODTELEFONE"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODDADOSCOMPLEMENTARES", $dados["CODDADOSCOMPLEMENTARES"], PDO::PARAM_STR, 9);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_solicitacao_estagio_rel_telefones(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `solicitacao_estagio_rel_telefones` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODTELEFONE", $dados["CODTELEFONE"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODSOLICITACAOESTAGIO", $dados["CODSOLICITACAOESTAGIO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }
    
    public function insert_cadastro_rel_telefone(Array $dados) {
        if (sizeof($dados) != 0) {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $keys = ":" . implode(",:", array_keys($dados));

            $query = $this->db->prepare("INSERT INTO `cadastro_rel_telefones` ({$campos}) VALUES ({$keys});");

            $query->bindParam(":CODTELEFONE", $dados["CODTELEFONE"], PDO::PARAM_STR, 32);
            $query->bindParam(":CODCADASTRO", $dados["CODCADASTRO"], PDO::PARAM_STR, 32);

            $query->execute();

            return true;
        } else {
            return false;
        }
    }

    public function get_conta_bancaria($codcadastro) {

        $query = $this->db->query("SELECT contas.*, cadastro_rel_contas.* FROM contas
INNER JOIN cadastro_rel_contas ON cadastro_rel_contas.CODCONTA=contas.CODCONTA
WHERE cadastro_rel_contas.CODCADASTRO='{$codcadastro}'");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function qntdd_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares = null) {

        if( $coddadoscomplementares != null ){
            $and = "AND dc.CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
        }
        
$query = $this->db->query("SELECT 
  dc.CODDADOSCOMPLEMENTARES,
  DATE_FORMAT( dc.DTA, '%d/%m/%Y - %Hh%i' ) AS DTA,
  DATE_FORMAT( dc.DTA_INICIO, '%d/%m/%Y' ) AS DTA_INICIO,
  DATE_FORMAT( dc.DTA_FIM, '%d/%m/%Y' ) AS DTA_FIM,
  DATE_FORMAT( dc.DTA, '%d/%m/%Y - %Hh%i' ) AS DTA,
  dc.BOLSA_VALOR,
  dc.CARGA_HORARIA,
  dc.CARGA_HORARIA_OBS,
  dc.INTITUICAO_ENSINO,
  dc.CARGO,
  dc.REPRESENTANTE_INTITUICAO,
  dc.CARGO_REPRESENTANTE,
  dc.CTPS,
  dc.SERIE,
  dc.CURSO,
  dc.STATUS,
  dc.CTPS,
  dc.SERIE,
  era.CODEMPRESA_ENTIDADE AS CODEMPRESA,
  stg.CODCADASTRO AS CODESTAGIARIO
FROM dados_complementares AS dc
INNER JOIN cadastro_rel_dados_complementares AS crdc ON crdc.CODDADOSCOMPLEMENTARES=dc.CODDADOSCOMPLEMENTARES
INNER JOIN cadastro AS stg ON stg.CODCADASTRO=crdc.CODCADASTRO
INNER JOIN estagiarios_rel_empresas AS era ON era.CODCADASTRO=stg.CODCADASTRO
WHERE stg.CODCADASTRO='{$codestagiario}' AND era.CODEMPRESA_ENTIDADE='{$codempresa}' {$and}");

        $query->execute();
        return $query->rowCount();
    }
    
    public function get_dados_complementares($codestagiario, $codempresa, $coddadoscomplementares = null, $list = TRUE) {

        if( $coddadoscomplementares != null ){
            $and = "AND dc.CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
        } else {
            if($list){
                $and = "GROUP BY dc.CODDADOSCOMPLEMENTARES ORDER BY dc.DTA ASC LIMIT 0,1";
            } else {
                $and = " ORDER BY dc.DTA ASC LIMIT 0,4";
            }           
        }
        
$query = $this->db->query("SELECT 
  dc.CODDADOSCOMPLEMENTARES,
  DATE_FORMAT( dc.DTA, '%d/%m/%Y - %Hh%i' ) AS DTA,
  dc.DTA_INICIO AS DTA_INICIO_USA,
  dc.DTA_FIM AS DTA_FIM_USA,
  DATE_ADD( dc.DTA_FIM, INTERVAL 1 DAY ) AS DTA_INICIO_USA_6_MESES,
  DATE_ADD( DATE_ADD( dc.DTA_FIM, INTERVAL 1 DAY ), INTERVAL 6 MONTH ) AS DTA_FIM_USA_6_MESES,
  DATE_FORMAT( dc.DTA_INICIO, '%d/%m/%Y' ) AS DTA_INICIO,
  DATE_FORMAT( dc.DTA_FIM, '%d/%m/%Y' ) AS DTA_FIM,
  DATE_FORMAT( dc.DTA_DESLIGAMENTO, '%d/%m/%Y' ) AS DTA_DESLIGAMENTO,
  dc.BOLSA_VALOR,
  dc.CARGA_HORARIA,
  dc.CARGA_HORARIA_OBS,
  dc.TERMO_ENTREGUE,
  dc.INTITUICAO_ENSINO,
  dc.CARGO,
  dc.REPRESENTANTE_INTITUICAO,
  dc.CARGO_REPRESENTANTE,
  dc.CTPS,
  dc.SERIE,
  dc.CURSO,
  dc.STATUS,
  dc.CTPS,
  dc.SERIE,
  era.CODEMPRESA_ENTIDADE AS CODEMPRESA,
  stg.CODCADASTRO AS CODESTAGIARIO
FROM dados_complementares AS dc
INNER JOIN cadastro_rel_dados_complementares AS crdc ON crdc.CODDADOSCOMPLEMENTARES=dc.CODDADOSCOMPLEMENTARES
INNER JOIN cadastro AS stg ON stg.CODCADASTRO=crdc.CODCADASTRO
INNER JOIN estagiarios_rel_empresas AS era ON era.CODCADASTRO=stg.CODCADASTRO
WHERE stg.CODCADASTRO='{$codestagiario}' AND era.CODEMPRESA_ENTIDADE='{$codempresa}' {$and}");

//echo "SELECT 
//  dc.CODDADOSCOMPLEMENTARES,
//  DATE_FORMAT( dc.DTA, '%d/%m/%Y - %Hh%i' ) AS DTA,
//  dc.DTA_INICIO AS DTA_INICIO_USA,
//  dc.DTA_FIM AS DTA_FIM_USA,
//  DATE_ADD( dc.DTA_INICIO, INTERVAL 6 MONTH ) AS DTA_INICIO_USA_6_MESES,
//  DATE_ADD( dc.DTA_FIM, INTERVAL 6 MONTH ) AS DTA_FIM_USA_6_MESES,
//  DATE_FORMAT( dc.DTA_INICIO, '%d/%m/%Y' ) AS DTA_INICIO,
//  DATE_FORMAT( dc.DTA_FIM, '%d/%m/%Y' ) AS DTA_FIM,
//  dc.BOLSA_VALOR,
//  dc.CARGA_HORARIA,
//  dc.CARGA_HORARIA_OBS,
//  dc.TERMO_ENTREGUE,
//  dc.INTITUICAO_ENSINO,
//  dc.CARGO,
//  dc.REPRESENTANTE_INTITUICAO,
//  dc.CARGO_REPRESENTANTE,
//  dc.CTPS,
//  dc.SERIE,
//  dc.CURSO,
//  dc.STATUS,
//  dc.CTPS,
//  dc.SERIE,
//  era.CODEMPRESA_ENTIDADE AS CODEMPRESA,
//  stg.CODCADASTRO AS CODESTAGIARIO
//FROM dados_complementares AS dc
//INNER JOIN cadastro_rel_dados_complementares AS crdc ON crdc.CODDADOSCOMPLEMENTARES=dc.CODDADOSCOMPLEMENTARES
//INNER JOIN cadastro AS stg ON stg.CODCADASTRO=crdc.CODCADASTRO
//INNER JOIN estagiarios_rel_empresas AS era ON era.CODCADASTRO=stg.CODCADASTRO
//WHERE stg.CODCADASTRO='{$codestagiario}' AND era.CODEMPRESA_ENTIDADE='{$codempresa}' {$and}";
//die();
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->BOLSA_VALOR_EXTENSO = "(". GExtenso::moeda($rows->BOLSA_VALOR) .")";
                $rows->BOLSA_VALOR = $c->formataReais($rows->BOLSA_VALOR); 
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function get_ficha_desligamento($coddadoscomplementares) {

        
        $query = $this->db->query("SELECT * FROM ficha_desligamento WHERE CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'");

        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function delete_dados_complementares($coddadoscomplementares) {        
        $query = $this->db->query("DELETE 
	dados_complementares, 
	dados_complementares_rel_enderecos, 
	dados_complementares_rel_telefones,
	enderecos,
	telefones
FROM dados_complementares
INNER JOIN dados_complementares_rel_enderecos ON dados_complementares_rel_enderecos.CODDADOSCOMPLEMENTARES=dados_complementares.CODDADOSCOMPLEMENTARES
INNER JOIN dados_complementares_rel_telefones ON dados_complementares_rel_telefones.CODDADOSCOMPLEMENTARES=dados_complementares.CODDADOSCOMPLEMENTARES
INNER JOIN enderecos ON dados_complementares_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
INNER JOIN telefones ON dados_complementares_rel_telefones.CODTELEFONE=telefones.CODTELEFONE
WHERE dados_complementares.CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'"); 

        return true;
    }
    
    public function get_questionario_estagiario($coddadoscomplementares) {

        
        $query = $this->db->query("SELECT * FROM questionario_estagiario WHERE CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'");

        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function get_nome_estagiario($codempresa) {
    
        $query = $this->db->query("SELECT STG_NOME as NOME FROM view_estagiarios WHERE EMP_CODCADASTRO='{$codempresa}' GROUP BY STG_CODCADASTRO ORDER BY STG_NOME ASC");

        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    

    public function get_enderecos($codcadastro) {

        $query = $this->db->query("SELECT enderecos.* FROM `enderecos` "
                . "INNER JOIN `cadastro_rel_enderecos` ON cadastro_rel_enderecos.CODENDERECO=enderecos.CODENDERECO "
                . "WHERE cadastro_rel_enderecos.CODCADASTRO='{$codcadastro}'"
                . "GROUP BY enderecos.CODENDERECO"
                . " ORDER BY enderecos.DTA DESC");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function get_enderecos_instituicao($coddadoscomplementares) {

        $query = $this->db->query("SELECT enderecos.* FROM `enderecos` "
                . "INNER JOIN `dados_complementares_rel_enderecos` ON dados_complementares_rel_enderecos.CODENDERECO=enderecos.CODENDERECO "
                . "WHERE dados_complementares_rel_enderecos.CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'"
                . "GROUP BY enderecos.CODENDERECO"
                . " ORDER BY enderecos.DTA DESC");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }

    public function get_bancos() {
        $query = $this->db->query("SELECT bancos.* FROM `bancos` ORDER BY CODBANCO ASC");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function get_arquivos($codcadastro = NULL, $codarquivo = NULL) {
        
        if( $codarquivo != NULL){
            $and = "AND CODARQUIVO='{$codarquivo}'";
        }
        
        $query = $this->db->query("SELECT arquivos.*, DATE_FORMAT( arquivos.DTA, '%d/%m/%Y - %Hh%i' ) AS DTA  FROM `arquivos` WHERE CODCADASTRO='{$codcadastro}' {$and} ORDER BY DTA DESC");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $dados[] = $rows;
            }
            return $dados;
        } else {
            return false;
        }
    }
    
    public function get_avaliacao($coddadoscomplementares) {
        
        $query = $this->db->query("SELECT avaliacoes.* FROM `avaliacoes` WHERE CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_lista_cadastro_entidade($search = NULL) {

        $c = new Controller();

        if ($search == null) {
            $where = "WHERE cadastro.TIPO_CONTA='pj'";
        } else {

            $nome_razao_social = $search;
            $cpf = $c->limpaCpf($search);
            $cnpj = $c->limpaCnpj($search);
            $id = $search;
            $email = $search;

            $where = "WHERE cadastro.TIPO_CONTA='pj' AND cadastro.NOME_RAZAO_SOCIAL LIKE '%{$nome_razao_social}%' OR cadastro.CPF_CNPJ LIKE '%{$cpf}%'  OR cadastro.CPF_CNPJ LIKE '%{$cnpj}%' OR cadastro.ID LIKE '%{$id}%' OR cadastro.EMAIL LIKE '%{$email}%' ";
        }

        $query = $this->db->query("SELECT cadastro.*,  DATE_FORMAT( cadastro.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM cadastro
        {$where}
        ORDER BY cadastro.NOME_RAZAO_SOCIAL ASC");
        $query->execute();
        if ($query->rowCount()) {

            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                $rows->CPF_CNPJ = $c->formataCnpj($rows->CPF_CNPJ);
                $rows->NOME_RAZAO_SOCIAL = html_entity_decode($rows->NOME_RAZAO_SOCIAL);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_lista_cadastro_ativas($codempresa_or_gestor = null) {

        $c = new Controller();

        if ($codempresa_or_gestor == null) {
            $qry = "SELECT cadastro.*, DATE_FORMAT( cadastro.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM cadastro 
INNER JOIN cadastro_rel_administradores ON cadastro_rel_administradores.CODEMPRESA_ENTIDADE=cadastro.CODCADASTRO 
WHERE cadastro.TIPO_CONTA='pj' AND cadastro.STATUS=1 
GROUP BY cadastro.CODCADASTRO
ORDER BY cadastro.NOME_RAZAO_SOCIAL ASC";
        } else {
            $qry = "SELECT 
	emp.CODCADASTRO AS EMP_CODCADASTRO,
	emp.NOME_RAZAO_SOCIAL AS EMP_NOME,
	DATE_FORMAT( emp.DTA, '%d/%m/%Y - %Hh%i' ) as EMP_DTA,
	emp.TIPO_CONTA AS EMP_TIPO_CONTA,  
	CONCAT( SUBSTRING( emp.CPF_CNPJ, -14, 2 ) , '.', SUBSTRING( emp.CPF_CNPJ, -12, 3 ), '.', SUBSTRING( emp.CPF_CNPJ, -9, 3 ), '/', SUBSTRING( emp.CPF_CNPJ, -6, 4 ), '-', SUBSTRING(  '07857774000182', -2 )) AS EMP_CNPJ,
	emp.ID AS EMP_ID, 
	emp.EMAIL AS EMP_EMAIL, 
	emp.SITE AS EMP_SITE, 
	emp.SENHA AS EMP_SENHA, 
	emp.LEMBRETE AS EMP_LEMBRETE, 
	emp.SEXO AS EMP_SEXO, 
	emp.PAPEL AS EMP_PAPEL, 
	DATE_FORMAT( emp.NASCIMENTO_FUNDACAO, '%d/%m/%Y' ) as EMP_FUNDADA_EM, 
	DATE_FORMAT( emp.NASCIMENTO_FUNDACAO, '%d' ) as EMP_DIA, 
	DATE_FORMAT( emp.NASCIMENTO_FUNDACAO, '%m' ) as EMP_MES, 
	DATE_FORMAT( emp.NASCIMENTO_FUNDACAO, '%Y' ) as EMP_ANO,
	emp.STATUS AS EMP_STATUS, 
	emp.OWNER AS EMP_OWNER
FROM cadastro AS adm
INNER JOIN cadastro_rel_administradores AS cra ON cra.CODCADASTRO=adm.CODCADASTRO
INNER JOIN cadastro AS emp ON emp.CODCADASTRO=cra.CODEMPRESA_ENTIDADE
WHERE (adm.PAPEL LIKE '%GESTOR%' OR adm.PAPEL LIKE '%ADMINISTRADOR%')
AND cra.CODEMPRESA_ENTIDADE!=adm.CODCADASTRO
AND cra.STATUS=1 AND emp.STATUS=1
AND adm.CODCADASTRO='{$codempresa_or_gestor}'";
        }


        $query = $this->db->query($qry);



        $query->execute();
        if ($query->rowCount()) {

            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->CODCADASTRO = strtolower($rows->CODCADASTRO);
                $rows->CPF_CNPJ = $c->formataCnpj($rows->CPF_CNPJ);
                $rows->NOME_RAZAO_SOCIAL = html_entity_decode($rows->NOME_RAZAO_SOCIAL);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_lista_cadastro_entidade_estagiarios($codcadastro = NULL, $codempresa_config = null, $search = NULL) {


        if ($_SESSION["PAPEL"] == "ESTAGIARIO") {

            if ($codcadastro != null) {
                $where = "WHERE view_estagiarios.STG_CODCADASTRO='{$codcadastro}'";
            }

            if ($codcadastro != null && $search != null) {

                $where = "WHERE view_estagiarios.STG_CODCADASTRO='{$codcadastro}'";
                $where .= "AND view_estagiarios.EMP_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_CNPJ LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_ID LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_FUNDADA_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NASCIDO_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NASCIDO_EM LIKE '%{$search}%'";
            }
            
        } else if ($_SESSION["PAPEL"] == "GESTOR") {

            if ($codcadastro != null) {
                $where = "WHERE view_estagiarios.ADM_CODCADASTRO='{$codcadastro}'";
            }

            if ($codcadastro != null && $search != null) {

                $where = "WHERE view_estagiarios.ADM_CODCADASTRO='{$codcadastro}'";
                $where .= "AND view_estagiarios.EMP_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_CNPJ LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_ID LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_FUNDADA_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NASCIDO_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NASCIDO_EM LIKE '%{$search}%'";
            }
            
        } else {

            if ($codcadastro != null) {
                $where = "WHERE view_estagiarios.EMP_CODCADASTRO='{$codcadastro}'";
            }

            if ($codcadastro != null && $search != null) {

                $where = "WHERE view_estagiarios.EMP_CODCADASTRO='{$codcadastro}'";
                $where .= "AND view_estagiarios.EMP_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_CNPJ LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_ID LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_FUNDADA_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NASCIDO_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NASCIDO_EM LIKE '%{$search}%'";
            } else if ($search != null) {

                $where = "WHERE view_estagiarios.EMP_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_CNPJ LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_ID LIKE '%{$search}%' ";
                $where .= "OR view_estagiarios.EMP_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.EMP_FUNDADA_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.ADM_NASCIDO_EM LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NOME LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_CPF LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_ID LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_EMAIL LIKE '%{$search}%'";
                $where .= "OR view_estagiarios.STG_NASCIDO_EM LIKE '%{$search}%'";
            }
        }

        $query = $this->db->query("SELECT view_estagiarios.* FROM view_estagiarios {$where} GROUP BY view_estagiarios.STG_CODCADASTRO ORDER BY view_estagiarios.EMP_NOME DESC");

        $query->execute();

        if ($query->rowCount()) {

            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {

                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_lista_cadastro_entidade_administradores($codcadastro = NULL, $search = NULL) {

        if ($codcadastro != null) {

            $where = "WHERE view_administradores.EMP_CODCADASTRO='{$codcadastro}'";
        }

        if ($codcadastro != null && $search != null) {

            echo aqui;
            $where = "WHERE view_administradores.EMP_CODCADASTRO='{$codcadastro}'";
            $where .= "AND view_administradores.EMP_NOME LIKE '%{$search}%'";
            $where .= "OR view_administradores.EMP_CNPJ LIKE '%{$search}%' ";
            $where .= "OR view_administradores.EMP_ID LIKE '%{$search}%' ";
            $where .= "OR view_administradores.EMP_EMAIL LIKE '%{$search}%'";
            $where .= "OR view_administradores.EMP_FUNDADA_EM LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_NOME LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_CPF LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_ID LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_EMAIL LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_NASCIDO_EM LIKE '%{$search}%'";
        } else if ($search != null) {

            $where = "WHERE view_administradores.EMP_NOME LIKE '%{$search}%'";
            $where .= "OR view_administradores.EMP_CNPJ LIKE '%{$search}%' ";
            $where .= "OR view_administradores.EMP_ID LIKE '%{$search}%' ";
            $where .= "OR view_administradores.EMP_EMAIL LIKE '%{$search}%'";
            $where .= "OR view_administradores.EMP_FUNDADA_EM LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_NOME LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_CPF LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_ID LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_EMAIL LIKE '%{$search}%'";
            $where .= "OR view_administradores.ADM_NASCIDO_EM LIKE '%{$search}%'";
        }

        $query = $this->db->query("SELECT view_administradores.* FROM view_administradores
        {$where} 
        ORDER BY view_administradores.EMP_NOME ASC");
        $query->execute();

        if ($query->rowCount()) {

            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->ADMIN_CODCADASTRO = strtolower($rows->ADMIN_CODCADASTRO);
                $rows->ADMIN_CODCADASTRO = strtolower($rows->ADMIN_CODCADASTRO);
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function delete_conta_bancaria($codconta) {
        $this->_tabela = "contas";
        $where = "CODCONTA='{$codconta}'";
        return $this->delete($where);
    }

    public function delete_cadastro_rel_conta_bancaria($codconta, $codcadastro) {
        $this->_tabela = "cadastro_rel_contas";
        $where = "CODCONTA='{$codconta}' AND CODCADASTRO='{$codcadastro}'";
        return $this->delete($where);
    }
    
    public function delete_arquivo($codarquivo) {
        $this->_tabela = "arquivos";
        $where = "CODARQUIVO='{$codarquivo}'";
        return $this->delete($where);
    }

    public function delete_cadastro_entidade($codcadastro) {
        $this->_tabela = "cadastro";
        $where = "CODCADASTRO='{$codcadastro}'";
        return $this->delete($where);
    }

    public function get_cods_cadastro_rel_endereco($codcadastro) {
        $this->_tabela = "cadastro_rel_enderecos";
        $where = "CODCADASTRO='{$codcadastro}'";
        return $this->read($where);
    }
    
    public function get_cods_dados_complementares_rel_endereco($coddadoscomplementares) {
        $this->_tabela = "dados_complementares_rel_enderecos";
        $where = "CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
        return $this->read($where);
    }

    public function delete_endereco($codendereco) {
        $this->_tabela = "enderecos";
        $where = "CODENDERECO='{$codendereco}'";
        return $this->delete($where);
    }

    public function delete_dados_complementares_rel_enderecos($coddadoscomplementares) {
        $this->_tabela = "dados_complementares_rel_enderecos";
        $where = "CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
        return $this->delete($where);
    }
    
    public function delete_cadastro_rel_endereco($codcadastro) {
        $this->_tabela = "cadastro_rel_enderecos";
        $where = "CODCADASTRO='{$codcadastro}'";
        return $this->delete($where);
    }

    public function get_cods_cadastro_rel_telefone($codcadastro) {
        $query = $this->db->query("SELECT * FROM cadastro_rel_telefones WHERE CODCADASTRO='{$codcadastro}'");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_cods_dados_complementares_rel_telefone($coddadoscomplementares) {
        $query = $this->db->query("SELECT * FROM dados_complementares_rel_telefones WHERE CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function delete_solicitacao_estagio($codsolicitacaoestagio) {
        $query = $this->db->query("DELETE 
	solicitacao_estagio, 
	solicitacao_estagio_and_beneficios,
	solicitacao_estagio_and_cursos,
	solicitacao_estagio_and_idiomas,
	solicitacao_estagio_and_informatica,
	solicitacao_estagio_rel_enderecos,
	solicitacao_estagio_rel_telefones,
	enderecos,
	telefones
FROM solicitacao_estagio
INNER JOIN solicitacao_estagio_and_beneficios ON solicitacao_estagio_and_beneficios.CODSOLICITACAOESTAGIO=solicitacao_estagio.CODSOLICITACAOESTAGIO
INNER JOIN solicitacao_estagio_and_cursos ON solicitacao_estagio_and_cursos.CODSOLICITACAOESTAGIO=solicitacao_estagio.CODSOLICITACAOESTAGIO
INNER JOIN solicitacao_estagio_and_idiomas ON solicitacao_estagio_and_idiomas.CODSOLICITACAOESTAGIO=solicitacao_estagio.CODSOLICITACAOESTAGIO
INNER JOIN solicitacao_estagio_and_informatica ON solicitacao_estagio_and_informatica.CODSOLICITACAOESTAGIO=solicitacao_estagio.CODSOLICITACAOESTAGIO
INNER JOIN solicitacao_estagio_rel_enderecos ON solicitacao_estagio_rel_enderecos.CODSOLICITACAOESTAGIO=solicitacao_estagio.CODSOLICITACAOESTAGIO
INNER JOIN enderecos ON solicitacao_estagio_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
INNER JOIN solicitacao_estagio_rel_telefones ON solicitacao_estagio_rel_telefones.CODSOLICITACAOESTAGIO=solicitacao_estagio.CODSOLICITACAOESTAGIO
INNER JOIN telefones ON solicitacao_estagio_rel_telefones.CODTELEFONE=telefones.CODTELEFONE
WHERE solicitacao_estagio.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'");
        $query->execute();
        return true;
    }

    public function delete_telefone($codtelefone) {
        $this->_tabela = "telefones";
        $where = "CODTELEFONE='{$codtelefone}'";
        return $this->delete($where);
    }

    public function delete_dados_complementares_rel_telefone($coddadoscomplementares) {
        $this->_tabela = "dados_complementares_rel_telefones";
        $where = "CODDADOSCOMPLEMENTARES='{$codcadastro}'";
        return $this->delete($where);
    }
    
    public function delete_cadastro_rel_telefone($codcadastro) {
        $this->_tabela = "cadastro_rel_telefones";
        $where = "CODCADASTRO='{$codcadastro}'";
        return $this->delete($where);
    }

    public function get_solicitacao($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT 
	solicitacao_estagio.*, 
	DATE_FORMAT( solicitacao_estagio.DTA, '%d/%m/%Y - %Hh%i' ) as DTA
        FROM 
	solicitacao_estagio 
        WHERE solicitacao_estagio.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_benficios($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT solicitacao_estagio_and_beneficios.* FROM solicitacao_estagio_and_beneficios
WHERE solicitacao_estagio_and_beneficios.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'
ORDER BY (solicitacao_estagio_and_beneficios.ORDEM+0) ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_idiomas($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT solicitacao_estagio_and_idiomas.* FROM solicitacao_estagio_and_idiomas
WHERE solicitacao_estagio_and_idiomas.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'
ORDER BY (solicitacao_estagio_and_idiomas.ORDEM+0) ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_informatica($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT solicitacao_estagio_and_informatica.* FROM solicitacao_estagio_and_informatica
WHERE solicitacao_estagio_and_informatica.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'
ORDER BY (solicitacao_estagio_and_informatica.ORDEM+0) ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_cursos($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT solicitacao_estagio_and_cursos.* FROM solicitacao_estagio_and_cursos
WHERE solicitacao_estagio_and_cursos.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'
ORDER BY (solicitacao_estagio_and_cursos.ORDEM+0) ASC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_telefones($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT telefones.* FROM telefones
INNER JOIN solicitacao_estagio_rel_telefones ON solicitacao_estagio_rel_telefones.CODTELEFONE=telefones.CODTELEFONE
WHERE solicitacao_estagio_rel_telefones.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'
ORDER BY solicitacao_estagio_rel_telefones.DTA DESC");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_enderecos($codsolicitacaoestagio) {
        
        $query = $this->db->query("SELECT enderecos.* FROM enderecos
INNER JOIN solicitacao_estagio_rel_enderecos ON solicitacao_estagio_rel_enderecos.CODENDERECO=enderecos.CODENDERECO
WHERE solicitacao_estagio_rel_enderecos.CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function get_solicitacao_estagio($codcadastro = NULL) {
        
        if($codcadastro != NULL){
            $where = "WHERE solicitacao_estagio.CODCADASTRO='{$codcadastro}' AND solicitacao_estagio.OCULTAR=0";
        }
        
        $query = $this->db->query("SELECT 
	solicitacao_estagio.CODSOLICITACAOESTAGIO, 
	DATE_FORMAT( solicitacao_estagio.DTA, '%d/%m/%Y - %Hh%i' ) as DTA,
        cadastro.NOME_RAZAO_SOCIAL as EMPRESA,
        concat(substr(cadastro.CPF_CNPJ,-(14),2),'.',substr(cadastro.CPF_CNPJ,-(12),3),'.',substr(cadastro.CPF_CNPJ,-(9),3),'/',substr(cadastro.CPF_CNPJ,-(6),4),'-',substr(cadastro.CPF_CNPJ,-(2))) AS CNPJ 
        FROM 
	solicitacao_estagio 
        INNER JOIN cadastro ON cadastro.CODCADASTRO=solicitacao_estagio.CODCADASTRO
        {$where}");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
               $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_cadastro($codcadastro_or_cpf_or_cnpj_or_id) {
        $query = $this->db->query("SELECT 
	cadastro.*, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%d' ) as DIA, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%m' ) as MES, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%Y' ) as ANO 
        FROM 
	cadastro WHERE CODCADASTRO='{$codcadastro_or_cpf_or_cnpj_or_id}' OR CPF_CNPJ='{$codcadastro_or_cpf_or_cnpj_or_id}' OR ID='{$codcadastro_or_cpf_or_cnpj_or_id}'");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                if ($rows->TIPO_CONTA == "pj") {
                    $rows->CNPJ = $c->formataCnpj($rows->CPF_CNPJ);
                } else {
                    $rows->CPF = $c->formataCpf($rows->CPF_CNPJ);
                }

                return $rows;
            }
        } else {
            return false;
        }
    }
    
    public function get_estagiario_view($codestagiario, $codempresa) {

        $query = $this->db->query("SELECT * FROM `view_estagiarios` WHERE `STG_CODCADASTRO`='{$codestagiario}' AND `EMP_CODCADASTRO`='{$codempresa}'");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_administrador($codcadastro_or_cpf_or_cnpj_or_id) {

        $query = $this->db->query("SELECT 
	cadastro.*, 
	cadastro_rel_administradores.CODEMPRESA_ENTIDADE,
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%d' ) as DIA, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%m' ) as MES, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%Y' ) as ANO FROM cadastro
INNER JOIN cadastro_rel_administradores ON cadastro_rel_administradores.CODCADASTRO=cadastro.CODCADASTRO
WHERE (cadastro.CODCADASTRO='{$codcadastro_or_cpf_or_cnpj_or_id}' OR cadastro.CPF_CNPJ='{$codcadastro_or_cpf_or_cnpj_or_id}' OR cadastro.ID='{$codcadastro_or_cpf_or_cnpj_or_id}')
GROUP BY cadastro.CODCADASTRO");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME_EMPRESA = $rows->NOME_RAZAO_SOCIAL;
                if ($rows->TIPO_CONTA == "pj") {
                    $rows->CNPJ = $c->formataCnpj($rows->CPF_CNPJ);
                } else {
                    $rows->CPF = $c->formataCpf($rows->CPF_CNPJ);
                }
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_administradores_empresa_entidade($codcadastro) {

        $query = $this->db->query("SELECT 
	cadastro.*, 
	cadastro_rel_administradores.CODEMPRESA_ENTIDADE,
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%d' ) as DIA, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%m' ) as MES, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%Y' ) as ANO FROM cadastro
INNER JOIN cadastro_rel_administradores ON cadastro_rel_administradores.CODCADASTRO=cadastro.CODCADASTRO
WHERE cadastro_rel_administradores.CODEMPRESA_ENTIDADE='{$codcadastro}' AND cadastro.CODCADASTRO NOT IN('{$codcadastro}')
AND cadastro_rel_administradores.STATUS=1
GROUP BY cadastro.CODCADASTRO");
        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME = $rows->NOME_RAZAO_SOCIAL;
                if ($rows->TIPO_CONTA == "pj") {
                    $rows->CNPJ = $c->formataCnpj($rows->CPF_CNPJ);
                } else {
                    $rows->CPF = $c->formataCpf($rows->CPF_CNPJ);
                }
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_estagiario($codcadastro_or_cpf_or_cnpj_or_id, $codempresa = NULL) {

        if ($codempresa != NULL) {
            $and = "AND estagiarios_rel_empresas.CODEMPRESA_ENTIDADE='{$codempresa}'";
        }

        $query = $this->db->query("SELECT 
	cadastro.*, 
	DATE_FORMAT( cadastro.DTA, '%d/%m/%Y - %Hh%i' ) as DTA_FORMATADA, 
	estagiarios_rel_empresas.CODEMPRESA_ENTIDADE,
	estagiarios_rel_administradores.CODADMINISTRADOR,
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%d' ) as DIA, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%m' ) as MES, 
	DATE_FORMAT( cadastro.NASCIMENTO_FUNDACAO, '%Y' ) as ANO FROM cadastro
INNER JOIN estagiarios_rel_empresas ON estagiarios_rel_empresas.CODCADASTRO=cadastro.CODCADASTRO
INNER JOIN estagiarios_rel_administradores ON estagiarios_rel_administradores.CODCADASTRO=cadastro.CODCADASTRO
WHERE (cadastro.CODCADASTRO='{$codcadastro_or_cpf_or_cnpj_or_id}' 
OR cadastro.CPF_CNPJ='{$codcadastro_or_cpf_or_cnpj_or_id}' 
OR cadastro.ID='{$codcadastro_or_cpf_or_cnpj_or_id}') 
{$and}
GROUP BY cadastro.CODCADASTRO");

        $query->execute();
        if ($query->rowCount()) {
            $c = new Controller();
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $rows->NOME_EMPRESA = $rows->NOME_RAZAO_SOCIAL;
                if ($rows->TIPO_CONTA == "pj") {
                    $rows->CNPJ = $c->formataCnpj($rows->CPF_CNPJ);
                } else {
                    $rows->CPF = $c->formataCpf($rows->CPF_CNPJ);
                }
                return $rows;
            }
        } else {
            return false;
        }
    }

    public function get_telefones_dados_complementares($cadestagiario, $cadempresa, $coddadoscomplementares) {
        
        $query = $this->db->query("SELECT telefones.* FROM
telefones
INNER JOIN dados_complementares_rel_telefones ON dados_complementares_rel_telefones.CODTELEFONE=telefones.CODTELEFONE
INNER JOIN cadastro_rel_dados_complementares ON cadastro_rel_dados_complementares.CODDADOSCOMPLEMENTARES=dados_complementares_rel_telefones.CODDADOSCOMPLEMENTARES
INNER JOIN estagiarios_rel_empresas ON estagiarios_rel_empresas.CODCADASTRO=cadastro_rel_dados_complementares.CODCADASTRO
WHERE cadastro_rel_dados_complementares.CODCADASTRO='{$cadestagiario}' 
AND estagiarios_rel_empresas.CODEMPRESA_ENTIDADE='{$cadempresa}'
AND dados_complementares_rel_telefones.CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'");

        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }
    
    public function get_telefones($codcadastro) {
        $query = $this->db->query("SELECT telefones.* FROM
telefones
INNER JOIN cadastro_rel_telefones ON cadastro_rel_telefones.CODTELEFONE=telefones.CODTELEFONE
WHERE cadastro_rel_telefones.CODCADASTRO='{$codcadastro}'
GROUP BY telefones.CODTELEFONE");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function get_cod_empresas_administrador($codcadastro) {
        $query = $this->db->query("SELECT cadastro_rel_administradores.CODEMPRESA_ENTIDADE FROM cadastro_rel_administradores
WHERE cadastro_rel_administradores.CODCADASTRO='{$codcadastro}' AND cadastro_rel_administradores.STATUS=1 ");
        $query->execute();
        if ($query->rowCount()) {
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                $obj[] = $rows;
            }
            return $obj;
        } else {
            return false;
        }
    }

    public function update_cadastro_empresa_entidade(Array $dados, $codcadastro) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "cadastro";
            $where = "CODCADASTRO='{$codcadastro}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_dados_complementares(Array $dados, $coddadoscomplementares) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "dados_complementares";
            $where = "CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }

    public function update_cadastro_administrador_empresa_entidade(Array $dados, $codcadastro, $codempresa_entidade) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "cadastro_rel_administradores";
            $where = "CODCADASTRO='{$codcadastro}' AND CODEMPRESA_ENTIDADE='{$codempresa_entidade}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }

    public function update_cadastro_estagiario_empresa_entidade(Array $dados, $codcadastro, $codempresa_entidade) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "estagiarios_rel_empresas";
            $where = "CODCADASTRO='{$codcadastro}' AND CODEMPRESA_ENTIDADE='{$codempresa_entidade}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_avaliacao(Array $dados, $coddadoscomplementares) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "avaliacoes";
            $where = "CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_solicitacao_estagio(Array $dados, $codsolicitacaoestagio) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "solicitacao_estagio";
            $where = "CODSOLICITACAOESTAGIO='{$codsolicitacaoestagio}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_ficha_desligamento(Array $dados, $coddadoscomplementares) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "ficha_desligamento";
            $where = "CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }
    
    public function update_questionario_estagiario(Array $dados, $coddadoscomplementares) {
        if (sizeof($dados) != 0) {
            $this->_tabela = "questionario_estagiario";
            $where = "CODDADOSCOMPLEMENTARES='{$coddadoscomplementares}'";
            $this->update($dados, $where);
            return true;
        } else {
            return false;
        }
    }

    public function update_cadastro_estagiario_rel_administrador($codadministrador, $codcadastro, $codempresa_entidade) {
        $query = $this->db->query("UPDATE estagiarios_rel_administradores 
	INNER JOIN estagiarios_rel_empresas ON estagiarios_rel_empresas.CODCADASTRO=estagiarios_rel_administradores.CODCADASTRO
	SET estagiarios_rel_administradores.CODADMINISTRADOR='{$codadministrador}'
	WHERE estagiarios_rel_empresas.CODEMPRESA_ENTIDADE='{$codempresa_entidade}' AND estagiarios_rel_administradores.CODCADASTRO='{$codcadastro}'");
        $query->execute();
        return true;
    }
    
    
    public function insert_files($dados) {
        $this->_tabela = "arquivos";
        $this->insert($dados);
        return true;
    }
    
    
}

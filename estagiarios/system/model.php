<?php

class Model {

    protected $db;
    protected $_tabela;
    protected $host = "mysql04.parceriaconsult.com.br";
    protected $username = "parceriaconsult1";
    protected $dbname = "parceriaconsult1";
    protected $password = "a1uO2SLWG";

    public function __construct() {
        $this->db = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
    }

    public function insert(Array $dados) {

        if (sizeof($dados) != 0 && $this->_tabela != "") {
            $campos = "`" . implode("`,`", array_keys($dados)) . "`";
            $valores = "'" . implode("','", array_values($dados)) . "'";
            $this->db->query("INSERT INTO `{$this->_tabela}` ({$campos}) VALUES ({$valores});");
        } else {
            return false;
        }
    }

    public function read($where = null, $group_by = null, $order_by = null, $limit = null) { 
        if ($this->_tabela != "") {
            $where = ( $where != null ? "WHERE {$where}" : "");
            $limit = ( $limit != null ? "{$limit}" : "");
            $order_by = ( $order_by != null ? "{$order_by}" : "");
            $group_by = ( $group_by != null ? "{$group_by}" : "");
            
            $q = $this->db->query("SELECT * FROM `{$this->_tabela}` {$where} {$group_by} {$order_by} {$limit};");
            if ($q->rowCount()) {
                return $q->fetch(PDO::FETCH_OBJ);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function read_list($where = null, $group_by = null, $order_by = null, $limit = null) {
        if ($this->_tabela != "") {
            $where = ( $where != null ? "WHERE {$where}" : "");
            $limit = ( $limit != null ? "{$limit}" : "");
            $order_by = ( $order_by != null ? "{$order_by}" : "");
            $group_by = ( $group_by != null ? "{$group_by}" : "");
            $q = $this->db->query("SELECT *, DATE_FORMAT( {$this->_tabela}.DTA, '%d/%m/%Y - %Hh%i' ) as DTA FROM `{$this->_tabela}` {$where} {$group_by} {$order_by} {$limit};");
            if ($q->rowCount()) {
                return $q;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function update(Array $dados, $where = null) {
        if (sizeof($dados) != 0 && $this->_tabela != "") {
            foreach ($dados as $campo => $valor) {
                $campos[] = "`{$campo}` = '{$valor}'";
            }
            if ($where != null) {

                $where = "WHERE {$where};";
            } else {
                $where = ";";
            }
            $campos = implode(", ", $campos);
       
            //echo "UPDATE `{$this->_tabela}` SET {$campos} {$where}";            exit();
            
            $this->db->query("UPDATE `{$this->_tabela}` SET {$campos} {$where}");
            return true;
        } else {
            return false;
        }
    }

    public function delete($where = null) {
        if ($this->_tabela != "") {         
            $this->db->query("DELETE FROM `{$this->_tabela}` WHERE {$where};");
        } else {
            return false;
        }
    }
    
    public function read_query($query) { 
        $q = $this->db->query($query);
        if ($q->rowCount()) {
            return $q->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }
    
    /**
     *
     * @Utf8_decode
     *
     * @Replace accented chars with latin
     *
     * @param string $string The string to convert
     *
     * @return string The corrected string
     *
     */
    public function decode_utf8($string)
    {
        $accented = array(
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ă', 'Ą',
            'Ç', 'Ć', 'Č', 'Œ',
            'Ď', 'Đ',
            'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ă', 'ą',
            'ç', 'ć', 'č', 'œ',
            'ď', 'đ',
            'È', 'É', 'Ê', 'Ë', 'Ę', 'Ě',
            'Ğ',
            'Ì', 'Í', 'Î', 'Ï', 'İ',
            'Ĺ', 'Ľ', 'Ł',
            'è', 'é', 'ê', 'ë', 'ę', 'ě',
            'ğ',
            'ì', 'í', 'î', 'ï', 'ı',
            'ĺ', 'ľ', 'ł',
            'Ñ', 'Ń', 'Ň',
            'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ő',
            'Ŕ', 'Ř',
            'Ś', 'Ş', 'Š',
            'ñ', 'ń', 'ň',
            'ò', 'ó', 'ô', 'ö', 'ø', 'ő',
            'ŕ', 'ř',
            'ś', 'ş', 'š',
            'Ţ', 'Ť',
            'Ù', 'Ú', 'Û', 'Ų', 'Ü', 'Ů', 'Ű',
            'Ý', 'ß',
            'Ź', 'Ż', 'Ž',
            'ţ', 'ť',
            'ù', 'ú', 'û', 'ų', 'ü', 'ů', 'ű',
            'ý', 'ÿ',
            'ź', 'ż', 'ž',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'р',
            'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
            );

        $replace = array(
            'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'A', 'A',
            'C', 'C', 'C', 'CE',
            'D', 'D',
            'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'a', 'a',
            'c', 'c', 'c', 'ce',
            'd', 'd',
            'E', 'E', 'E', 'E', 'E', 'E',
            'G',
            'I', 'I', 'I', 'I', 'I',
            'L', 'L', 'L',
            'e', 'e', 'e', 'e', 'e', 'e',
            'g',
            'i', 'i', 'i', 'i', 'i',
            'l', 'l', 'l',
            'N', 'N', 'N',
            'O', 'O', 'O', 'O', 'O', 'O', 'O',
            'R', 'R',
            'S', 'S', 'S',
            'n', 'n', 'n',
            'o', 'o', 'o', 'o', 'o', 'o',
            'r', 'r',
            's', 's', 's',
            'T', 'T',
            'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y',
            'Z', 'Z', 'Z',
            't', 't',
            'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y',
            'z', 'z', 'z',
            'A', 'B', 'B', 'r', 'A', 'E', 'E', 'X', '3', 'N', 'N', 'K', 'N', 'M', 'H', 'O', 'N', 'P',
            'a', 'b', 'b', 'r', 'a', 'e', 'e', 'x', '3', 'n', 'n', 'k', 'n', 'm', 'h', 'o', 'p',
            'C', 'T', 'Y', 'O', 'X', 'U', 'u', 'W', 'W', 'b', 'b', 'b', 'E', 'O', 'R',
            'c', 't', 'y', 'o', 'x', 'u', 'u', 'w', 'w', 'b', 'b', 'b', 'e', 'o', 'r'
            );

        return str_replace($accented, $replace, $string);
    }
    
    public function getCurrent_date() {
        
        $query = $this->db->query("SELECT NOW() as DTA");
        $query->execute();
        if ($query->rowCount()) {
            
            while ($rows = $query->fetch(PDO::FETCH_OBJ)) {
                return $rows->DTA;
            }
        } else {
            return false;
        }
    }

}

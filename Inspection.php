<?php


namespace App\Model\SpliteSQL;



use App\Control\Alerts\Message;
use App\Control\Consts\URLConsts;

class Inspection extends SGBD
{

    private static function Error(){
        Message::ErrorMessage('Por favor Preencha Todos os Campos');
    }

    #SQLcount
    /*count 1*/
    public static function sql_count_by_1_row($table, $row1, $value){
        return SQLselect::SELECT("$row1", "$table", "$row1", "$value", SQLconsts::count);
    }

    /*count 1 by row limit*/
     public static function sql_count_by_1_row_limit( $row1, $table, $where_row, $value , $limit){
        return  SQLselect::SELECT_WHERE_LIMIT("$row1", "$table", "$where_row", "$value", $limit,self::CountRows);
     }

    #Empty and Null Variables Verifying
    public static function is_not_empty(array $variaveis):  bool{
        for ($i = 0; $i < count($variaveis); $i++):
            if (in_array( '', $variaveis) || empty($variaveis[$i]) || $variaveis[$i] == null):
                Message::ErrorMessage('Campos Vazios');
                return false;
            else:
                return true;
            endif;
        endfor;
    }

}
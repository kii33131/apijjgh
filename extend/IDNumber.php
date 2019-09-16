<?php
/**
 * 身份信息验证类
 */
class IDNumber
{
    public static function checkId($id_number)
    {
        if(strlen($id_number) == 15 || strlen($id_number) == 18){
            if(strlen($id_number) == 15){
                $id_number = self::idcard_15to18($id_number);
            }
            if(self::idcard_checksum18($id_number)){
                return true;
            }else{

                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 将15位身份证升级到18位
     * 参数表 ：string $idcard 十五位身份证号码
     * @param $id_number
     * @return bool|string
     */
    public static function idcard_15to18($id_number)
    {
        if (strlen($id_number) != 15){
            return false;
        }else{// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($id_number, 12, 3), array('996', '997', '998', '999')) !== false){
                $id_number = substr($id_number, 0, 6) . '18'. substr($id_number, 6, 9);
            }else{
                $id_number = substr($id_number, 0, 6) . '19'. substr($id_number, 6, 9);
            }
        }
        $id_number = $id_number . self::idcard_verify_number($id_number);
        return $id_number;
    }

    /**
     * 计算身份证号码中的检校码
     * 函数名称：idcard_verify_number
     * 参数表 ：string $idcard_base 身份证号码的前十七位
     * 返回值 ：string 检校码
     * @param $id_number
     * @return bool|mixed
     */
    public static function idcard_verify_number($id_number)
    {
        if (strlen($id_number) != 17){
            return false;
        }
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); //debug 加权因子
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); //debug 校验码对应值
        $checksum = 0;
        for ($i = 0; $i < strlen($id_number); $i++){
            $checksum += substr($id_number, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        $verify_number = $verify_number_list[$mod];
        return $verify_number;
    }

    /**
     * 函数功能：18位身份证校验码有效性检查
     * 参数表 ：string $idcard 十八位身份证号码
     * @param $id_number
     * @return bool
     */
    public static function idcard_checksum18($id_number)
    {
        if (strlen($id_number) != 18){ return false; }
            $idcard_base = substr($id_number, 0, 17);
        if (self::idcard_verify_number($idcard_base) != strtoupper(substr($id_number, 17, 1))){
            return false;
        }else{
            return true;
        }
    }
}
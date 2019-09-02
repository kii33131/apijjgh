<?php
namespace app\api\validate;

class Initiation extends BaseValidate
{
    protected $rule = [
        //'type' => 'isNotEmpty|in:1,2',//1创客登录 2企业登录
        //'mobbile'=>'isNotEmpty',
        'name' => 'require|isNotEmpty',
        'sex' => 'require|isNotEmpty',
        //'nation' => 'require|isNotEmpty',
        'birthday' => 'require|isNotEmpty',
        'card_number' => 'require|isNotEmpty',
        'phone' => 'require|isNotEmpty',
        'education' => 'require|isNotEmpty',
        'marry_status' => 'require|isNotEmpty',
        'job_status' => 'require|isNotEmpty',
        'technical_level' => 'require|isNotEmpty',
        'place' => 'require|isNotEmpty',
        'is_peasant' => 'require|isNotEmpty',
        'is_industry' => 'require|isNotEmpty',
        'company_address' => 'require|isNotEmpty',
        'email' => 'require|isNotEmpty',
        'join_at' => 'require|isNotEmpty',
        'is_model_worker' => 'require|isNotEmpty',
        'difficulty' => 'require|isNotEmpty',
    ];


}

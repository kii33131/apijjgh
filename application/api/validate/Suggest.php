<?php
namespace app\api\validate;

class Suggest extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'phone' => 'require|isNotEmpty',
        'email' => 'require|isNotEmpty',
        'note' => 'require|isNotEmpty',

    ];


}

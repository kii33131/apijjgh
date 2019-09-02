<?php


namespace app\api\controller;


use app\model\InitiationModel;

class Initiation extends Base
{

    public function addInitiation(){
        $validate = new \app\api\validate\Initiation();
        $validate->goCheck();
        $data = input('post.');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['birthday'] =  strtotime($data['birthday']);
        //birthday
        $data['nation'] = '汉族';
        $model = new InitiationModel();
        $model->create($data);
        success([]);
    }

}
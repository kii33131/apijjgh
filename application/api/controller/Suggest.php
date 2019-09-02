<?php


namespace app\api\controller;


use app\api\validate\EditBusiness;
use app\model\BusinessModel;
use app\model\MessageModel;
use app\model\SuggestModel;

class Suggest extends Base
{
    public function addSuggest(){
        $validate = new \app\api\validate\Suggest();
        $validate->goCheck();
        $data = input('post.');
        $model = new SuggestModel();
        $model->create($data);
        success([]);
    }


}
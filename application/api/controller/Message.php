<?php


namespace app\api\controller;


use app\api\validate\EditBusiness;
use app\model\BusinessModel;
use app\model\MessageModel;

class Message extends Base
{
   public function getListByCategory(){
       $data =input('post.');
       $MessageModel= new MessageModel();
       $list=$MessageModel->getListByCategory($this->listRows,$data);
       success($list);
   }


   public function detail(){
       $data =input('post.');
       $MessageModel= new MessageModel();
       $list=$MessageModel->detail($data);
       success($list);

   }


}
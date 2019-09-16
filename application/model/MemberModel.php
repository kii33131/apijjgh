<?php
namespace app\model;

class MemberModel extends BaseModel
{
   protected $name = 'member';

   public function editMember($params, $userInfo)
   {
       if(empty($userInfo)){
           return ['code' => 0,'msg' => '请先登录'];
       }
       if(empty($params['username'])){
           return ['code' => 0,'msg' => '请填写真实姓名'];
       }
       $check = '/^1\d{10}$/';
       if(empty($params['mobile']) || !preg_match($check, $params['mobile'])){
           return ['code' => 0,'msg' => '请填入您的手机号码'];
       }
       // 检查身份证号
       if(empty($params['id_number']) || !\IDNumber::checkId($params['id_number'])) {
           return ['code' => 0, 'msg' => '请填入正确的身份证号'];
       }
       $userInfo->username = $params['username'];
       $userInfo->mobile = $params['mobile'];
       $userInfo->id_number = $params['id_number'];
       $userInfo->save();
       return ['code' => 1, 'msg' => '完善成功'];
   }
}
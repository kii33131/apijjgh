<?php

namespace app\model;

use app\api\service\Union;
use think\Db;

class InitiationModel extends BaseModel
{
    protected $name = 'initiation';

    public function getInitiationInfo($userinfo)
    {
        if (empty($userinfo)) {
            return ['code' => 0, 'msg' => '请先登录'];
        }
        $result = $this
            ->where('member_id', $userinfo->id)
            ->find();
        return ['code' => 1, 'msg' => '','data' => $result];
    }

    public function getVerify($params, $userinfo)
    {
        if(empty($params['id_number']) || !\IDNumber::checkId($params['id_number'])){
            return ['code' => 0, 'msg' => '请输入正确的身份证号'];
        }
        if(empty($params['username'])){
            return ['code' => 0, 'msg' => '请输入姓名'];
        }
        $Union = new Union();
//        $access_token = $Union->getAccessToken();
        $access_token = '213c64e043d973ad72508d1d49bfb0731e74d545eec402eec95d6a18654cddb0';
        if(empty($access_token)){
            return ['code' => 0, 'msg' => '获取省总工会信息失败'];
        }
        $result = $Union->getUserByNameAndCertificateNo($params, $access_token);
        // 不是会员或者不是九江市的会员
        if($result['code'] != 200 || $result['data']['area']['id'] != 10010){
            return ['code' => 0, 'msg' => '匹配不成功！'];
        }
        $InitiationInfo = $this
            ->where('member_id', $userinfo->id)
            ->find();
        // 名族 婚姻状态 就业状态 技术等级 户籍类型
        $date_time = date('Y-m-d H:i:s');
        if(empty($InitiationInfo)){
            $userData = $result['data'];
            $save_data = [
                'member_id' => $userinfo->id,
                'name' => $userData['name'],
                'sex' => $userData['sex'],
                'nation' => $userData['nation'],
                'birthday' => strtotime($userData['birthDay']),
                'card_number' => $userData['certificateNo'],
                'phone' => $userData['phone'],
                'education' => $userData['degreeEdu'],
                'marry_status' => $userData['maritalStatus'],
                'job_status' => $userData['job'],
                'technical_level' => $userData['skillLevel'],
                'place' => $userData['personType'],
                'is_peasant' => $userData['isFarmerWorkers'],
                'created_at' => $date_time,
                'is_industry' => $userData['isIndustrialWorkers'],
                'company_address' => $userData['companyAddress'],
                'email' => !empty($userData['email']) ? $userData['email'] : '',
                'join_at' => $userData['joinDate'],
                'is_model_worker' => $userData['isModelWorkers'],
                'difficulty' => $userData['isDifficultWorkers']
            ];
            $this->save($save_data);
        }
        // 直接鉴定为会员
        Db::name('member')->where('id',$userinfo->id)->update(['is_vip' => 3]);
        return ['code' => 1, 'msg' => '匹配成功！'];
    }
}
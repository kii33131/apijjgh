<?php
namespace app\api\controller;

use app\api\service\Union;
use app\model\InitiationModel;
use think\Db;

class Initiation extends Base
{
    public function addInitiation()
    {
        $result = [];
        if(empty($this->userinfo)){
            $result = ['code' => 0,'msg' => '请先登录'];
        }
        $member_id = $this->userinfo->id;
        $is_vip = $this->userinfo->is_vip;
        $model = new InitiationModel();
        // 检查是否已申请过
        $InitiationInfo = $model
            ->where('member_id',$member_id)
            ->find();
        $validate = new \app\api\validate\Initiation();
        $validate->goCheck();
        $data = input('post.');

        // 新申请
        if(empty($InitiationInfo) && $is_vip == 1){
            Db::startTrans();
            try{
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['birthday'] =  strtotime($data['birthday']);
                //birthday
                $data['member_id'] = $member_id;
                $model->create($data);

                // 会员表信息完善
                Db::name('member')->where('id',$member_id)->update(['is_vip' => 2]);
                $result = ['code' => 1,'msg' => '已提交申请，待审核'];
                Db::commit();
            }catch (\Exception $e){
                Db::rollback();
                $result = ['code' => 0,'msg' => '申请失败'];
            }
        }elseif(!empty($InitiationInfo) && $is_vip == 4){
            // 未通过 重新申请
            Db::startTrans();
            try{
                $data['birthday'] =  strtotime($data['birthday']);
                //birthday
                $model->where('id',$InitiationInfo['id'])->update($data);
                // 会员表信息完善
                Db::name('member')->where('id',$member_id)->update(['is_vip' => 2]);
                Db::commit();
                $result = ['code' => 1,'msg' => '已重新提交申请，待审核'];
            }catch (\Exception $e){
                Db::rollback();
                $result = ['code' => 0,'msg' => '申请失败'];
            }
        }elseif(!empty($InitiationInfo) && $is_vip == 3){
            // 已通过，完善
            $data['birthday'] =  strtotime($data['birthday']);
            //birthday
            $model->where('id',$InitiationInfo['id'])->update($data);
            // 会员表信息完善
            Db::name('member')->where('id',$member_id)->update(['is_vip' => 2]);
            $result = ['code' => 1,'msg' => '完善信息成功'];
        }
        success($result);
    }

    public function info()
    {
        $userinfo = $this->userinfo;
        $model = new InitiationModel();
        success($model->getInitiationInfo($userinfo));
    }

    public function verify()
    {
        $userinfo = $this->userinfo;
        $params = input('post.');
        $model = new InitiationModel();
        success($model->getVerify($params, $userinfo));
    }

    public function dict()
    {
        $Union = new Union();
//        $access_token = $Union->getAccessToken();
        $access_token = '213c64e043d973ad72508d1d49bfb0731e74d545eec402eec95d6a18654cddb0';
        $data = [];
        $nation_data = $Union->getSysData($access_token,'nation');
        $degree_edu_data = $Union->getSysData($access_token,'degree_edu');
        $marital_status_data = $Union->getSysData($access_token,'marital_status');
        $job_status_data = $Union->getSysData($access_token,'job_status');
        $skill_level_data = $Union->getSysData($access_token,'skill_level');
        $person_type_data = $Union->getSysData($access_token,'household_registration_type');
        $nation_list = [];
        $degree_edu_list = [];
        $marital_status_list = [];
        $job_status_list = [];
        $skill_level_list = [];
        $person_type_list = [];
        array_map(function($value) use (&$nation_list){
            $nation_list[] = [
                'name' => $value['label'],
                'value' => $value['value'],
            ];
        }, $nation_data);
        array_map(function($value) use (&$degree_edu_list){
            $degree_edu_list[] = [
                'name' => $value['label'],
                'value' => $value['value'],
            ];
        }, $degree_edu_data);
        array_map(function($value) use (&$marital_status_list){
            $marital_status_list[] = [
                'name' => $value['label'],
                'value' => $value['value'],
            ];
        }, $marital_status_data);
        array_map(function($value) use (&$job_status_list){
            $job_status_list[] = [
                'name' => $value['label'],
                'value' => $value['value'],
            ];
        }, $job_status_data);
        array_map(function($value) use (&$skill_level_list){
            $skill_level_list[] = [
                'name' => $value['label'],
                'value' => $value['value'],
            ];
        }, $skill_level_data);
        array_map(function($value) use (&$person_type_list){
            $person_type_list[] = [
                'name' => $value['label'],
                'value' => $value['value'],
            ];
        }, $person_type_data);
        $data['nation_list'] = $nation_list;
        $data['degree_edu_list'] = $degree_edu_list;
        $data['marital_status_list'] = $marital_status_list;
        $data['job_status_list'] = $job_status_list;
        $data['skill_level_list'] = $skill_level_list;
        $data['person_type_list'] = $person_type_list;
        success($data);
    }
}
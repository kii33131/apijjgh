<?php
namespace app\model;

class ActivityModel extends BaseModel
{
    protected $name = 'activity';

    public function getActivityList()
    {
        $time = time();
        $list = $this
            ->where('status',1)
            ->where('begin_time','<=',$time)
            ->where('end_time','>',$time)
            ->select();
        return $list;
    }

    public function AddApply($data = [])
    {
        if(empty($data['name'])){
            return ['code' => 0,'msg' => '请填入您的姓名'];
        }
        if(empty($data['sex']) || !in_array($data['sex'],[1,2])){
            return ['code' => 0,'msg' => '请选择您的性别'];
        }
        if(empty($data['age'])){
            return ['code' => 0,'msg' => '请填入您的年龄'];
        }
        if(empty($data['phone'])){
            return ['code' => 0,'msg' => '请填入您的手机号码'];
        }
        if(empty($data['work_unit'])){
            return ['code' => 0,'msg' => '请填入您的工作单位'];
        }
    }
}
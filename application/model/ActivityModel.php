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

    public function getActivityDetail($id)
    {
        return $this
            ->where('id',$id)
            ->find();
    }

    public function AddApply($data = [])
    {
        if(empty($data['activity_id']) || !is_numeric($data['activity_id']) || $data['activity_id'] <= 0){
            return ['code' => 0,'msg' => '请选择活动'];
        }
        if(empty($data['name'])){
            return ['code' => 0,'msg' => '请填入您的姓名'];
        }
        if(empty($data['sex']) || !in_array($data['sex'],[1,2])){
            return ['code' => 0,'msg' => '请选择您的性别'];
        }
        if(empty($data['age']) || !is_numeric($data['age'])){
            return ['code' => 0,'msg' => '请填入您的年龄'];
        }
        $check = '/^1\d{10}$/';
        if(empty($data['phone']) || !preg_match($check, $data['phone'])){
            return ['code' => 0,'msg' => '请填入您的手机号码'];
        }
        if(empty($data['work_unit'])){
            return ['code' => 0,'msg' => '请填入您的工作单位'];
        }
        $time = time();
        $activity_detail = $this
            ->where('id',$data['activity_id'])
            ->where('status',1)
            ->where('begin_time','<=',$time)
            ->where('end_time','>',$time)
            ->find();
        if(empty($activity_detail)){
            return ['code' => 0,'msg' => '活动已失效'];
        }
        try{
            $model = new ActivityLogsModel();
            $model->data($data)->save();
            return ['code' => 1,'msg' => '报名成功'];
        }catch (\Exception $e){
            return ['code' => 0,'msg' => '报名失败'];
        }
    }
}
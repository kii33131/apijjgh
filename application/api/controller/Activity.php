<?php
namespace app\api\controller;

use app\model\ActivityModel;

class Activity extends Base
{
    public function activityList()
    {
        $ActivityModel = new ActivityModel();
        success($ActivityModel->getActivityList());
    }

    public function apply()
    {
        $data =input('post.');
        $model = new ActivityModel();
        $list=$model->AddApply($data);
        success($list);
    }
}
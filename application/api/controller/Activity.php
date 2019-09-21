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

    public function detail()
    {
        $id  = input('post.id');
        $ActivityModel = new ActivityModel();
        success($ActivityModel->getActivityDetail($id));
    }

    public function apply()
    {
        $userinfo = $this->userinfo;
        $data =input('post.');
        $model = new ActivityModel();
        $list=$model->AddApply($data,$userinfo);
        success($list);
    }
}

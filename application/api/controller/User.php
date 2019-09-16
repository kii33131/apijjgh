<?php


namespace app\api\controller;


use app\model\MemberModel;

class User extends Base
{
    public function profile()
    {
        $userInfo = $this->userinfo;
        $params = $this->request->param();
        $Member = new MemberModel();
        success($Member->editMember($params,$userInfo));
    }

    public function info()
    {
        success($this->userinfo);
    }
}
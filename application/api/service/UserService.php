<?php

namespace app\api\service;

use app\model\MemberModel;
use think\Db;

class UserService
{
    public static function connect($params = [])
    {
        $time = time();
        $values = [
            'openid'        => $params['openid'],
            'nickname'      => isset($params['userinfo']['nickname']) ? $params['userinfo']['nickname'] : '',
            'avatar'      => isset($params['userinfo']['avatar']) ? $params['userinfo']['avatar'] : '',
            'gender'      => isset($params['userinfo']['sex']) ? $params['userinfo']['sex'] : 0,
            'logintime'     => $time,
        ];

        $member = new MemberModel();
        $member_info = MemberModel::get(['openid' => $params['openid']]);
        if ($member_info) {
            $member_info->logintime = $time;
            $member_info->nickname = $values['nickname'];
            $member_info->gender = $values['gender'];
            $member_info->avatar = $values['avatar'];
            $member->save();
            return self::direct($member_info->id);
        } else {
            // 默认注册一个会员
            $member_info = self::register($values);
            if (!$member_info) {
                return false;
            }
            return $member_info;
        }
    }

    public static function direct($member_id)
    {
        $user = MemberModel::get($member_id);
        if ($user) {
            Db::startTrans();
            try {
                $ip = request()->ip();
                $time = time();

                $user->prevtime = $user->logintime;
                //记录本次登录的IP和时间
                $user->loginip = $ip;
                $user->logintime = $time;
                $user->token = \Random::uuid();
                $user->save();

                Db::commit();
                return $user;
            } catch (Exception $e) {
                Db::rollback();
                return false;
            }
        } else {
            return false;
        }
    }

    public static function register($values)
    {
        $ip = request()->ip();
        $time = time();

        $params = [
            'openid'  => $values['openid'],
            'nickname'  => $values['nickname'],
            'gender'  => $values['gender'],
            'avatar'  => htmlspecialchars(strip_tags($values['avatar'])),
            'logintime' => $time,
            'loginip'   => $ip,
            'prevtime'  => $time,
            'status'    => 1,
            'token'    => \Random::uuid(),
        ];

        //账号注册时需要开启事务,避免出现垃圾数据
        Db::startTrans();
        try {
            $user = MemberModel::create($params, true);
            Db::commit();
            return $user;
        } catch (Exception $e) {
            Db::rollback();
            return false;
        }
    }
}
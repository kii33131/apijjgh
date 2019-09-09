<?php

namespace app\model;

class BannerModel extends BaseModel
{
    protected $name = 'banner';

    public function getAllBanner()
    {
        return $this
            ->field('id,title,url,image')
            ->where('status',1)
            ->order('create_time','desc')
            ->select();
    }
    public function getImageAttr($name, $value, $data = [])
    {
        return !empty($value['image']) ? config('upload_domain') . $value['image'] : '';
    }
}
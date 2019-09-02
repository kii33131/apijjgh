<?php

namespace app\model;


use think\Db;

class MessageModel extends BaseModel
{
    protected $name = 'message';

    public function getListByCategory($limit,$data){
        $where = [];
        if(isset($data['category'])&&$data['category']){
            $where['category'] = $data['category'];
        }
        if(isset($data['channel'])&&$data['channel']){
            $where['channel'] = $data['channel'];
        }
        $where['status']=1;
        return self::where($where)->order('id desc')
            ->paginate($limit, false,  ['query' => request()->param()])->each(function ($item){
                $item->image =json_decode($item->image);
            });
    }


    public function detail($data){

        $result=self::get($data['id']);
        if($result['image']){
            $result['image'] =json_decode($result['image']);
        }else{
            $result['image'] =[];
        }
        if($result['enclosure']){
            $result['enclosure'] =json_decode($result['enclosure']);
        }else{
            $result['enclosure'] =[];
        }

        return $result;
    }
}
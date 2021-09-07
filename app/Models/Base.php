<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{   
    /**
     * [getone 查询单个数据 模型关联]
     * @param  array   $where [当前表的条件 关联其他模型的话就要在其他模型上面写]
     * $where=[
            'id'=>1,
            ['age','>',2],
            ['date','between','1,2'],
            ['type','in',[1,2]],
            ['name','or','sb'],
        ];
     * @param  array   $field [限制当前表的字段 不可跨表限制 需要限制的话 只能在模型关联的方法里面限制]
     * @param  string  $with  [模型关联 模型定义的方法]
     * @param  boolean $array [是否转换成数组]
     * @return [object or array]  [对象或数组]
    */
    public function getone($where=[],$field=[],$with='',$array=false)
    {   
        //字段处理
        if(empty($field)){
            $field=['*'];
        }
        $list=$this->select($field);

        //where处理  
        if(!empty($where)){
           $list=$this->CustomizeWhere($list,$where);
        }
        
        //模型关联
        if(!empty($with)){
            $list=$list->with($with);
        }
        
        $list=$list->first();

        if($array){
            $list=$list->toArray();
        }

        return $list;
    }
    
    /**
     * [getlist 查询多个数据 模型关联]
     * @param  array   $where [当前表的条件 关联其他模型的话就要在其他模型上面写]
     * $where=[
            'id'=>1,
            ['age','>',2],
            ['date','between','1,2'],
            ['type','in',[1,2]],
            ['name','or','sb'],
        ];
     * @param  array   $field [限制当前表的字段 不可跨表限制 需要限制的话 只能在模型关联的方法里面限制]
     * @param  array  $order [排序 ['排序字段,正序或倒叙']]
     * @param  array  $limit [查询多少条 [0=>'开始',1=>'查询数量']]
     * @param  array  $with  [模型关联 模型定义的方法]
     * @param  boolean $array [是否转换成数组]
     * @return [object or array]    [对象或数组]
    */
    public function getlist($where=[],$field=[],$order=[],$limit=[],$with=[],$array=false)
    {   
        //字段处理
        if(empty($field)){
            $field=['*'];
        }
        $list=$this->select($field);

        //where处理  
        if(!empty($where)){
           $list=$this->CustomizeWhere($list,$where);
        }
        
        //模型关联
        if(!empty($with)){
            $list=$list->with($with);
        }

        //排序处理
        $list=$this->CustomizeOrderBy($list,$order);

        //数量
        if(!empty($limit)){ 
            //分页处理
            if(is_array($limit)){
               $offset=$limit[0];
               $limit=$limit[1];
            }else{
               $offset=0;
               $limit=15;
            }
            $list=$list->offset($offset)->limit($limit);
        }

        $list=$list->get();
        if($array){
            $list=$list->toArray();
        }
        return $list;
    }
    
    /**
     * [getlists 查询多个数据 模型关联 带分页]
     * @param  array  $where [当前表的条件 关联其他模型的话就要在其他模型上面写]
     * $where=[
            ['id','>=',2]
       ];
     * @param  array  $field [限制当前表的字段 不可跨表限制 需要限制的话 只能在模型关联的方法里面限制]
     * @param  array  $order [排序 ['排序字段,正序或倒叙']]
     * @param  number $limit [查询多少条]
     * @param  array  $with  [模型关联 模型定义的方法]
     * @return [object]      [对象]
    */
    public function getlists($where=[],$field=[],$order=[],$limit='15',$with=[])
    {   
        //字段处理
        if(empty($field)){
            $field=['*'];
        }
        $list=$this->select($field);

        //where处理  
        if(!empty($where)){
           $list=$this->CustomizeWhere($list,$where);
        }
        
        //模型关联
        if(!empty($with)){
            $list=$list->with($with);
        }

        //排序处理
        $list=$this->CustomizeOrderBy($list,$order);

        $list=$list->paginate($limit)->appends(request()->all());
        
        return $list;
    }
    
    /**
     * [edit 编辑数据]
     * @param  [array] $where [当前表的条件]
     * @param  [array] $data  [修改参数与内容 默认数据表中存在 created_at 和 updated_at 你不想让Eloquent自动管理，请将模型中的 $timestamps 属性设置为 false]
     * @return [number]        [影响行数]
    */
    public function edit($where,$data)
    {   
        $res=$this;
        if(!empty($where)){
           $res=$this->CustomizeWhere($res,$where);
           if(!$res){
              return false;
           }
        }else{
          return false;
        }
        $res=$res->update($data);
        return $res;
    }
    
    // 添加数据 一维数组 并返回插入id  不支持批量插入 批量插入 请参考 create方法  或者 model::insert(二维数组)
    public function add($data)
    {
        if(empty($data)){
           return false;
        }elseif(!is_array($data)){
           return false;
        }
        //遍历数组 组装添加的数据
        foreach ($data as $key => $value) {
            $this->$key=$value;
        }
        $res=$this->save();
        $key=$this->primaryKey;
        //返回插入id
        $id=$this->$key;
        return $id;
    }
    
    /**
     * [del description]
     * @param  [array] $where [当前表的条件]
     * $where=[
            ['id','>=',2]
       ];
     * @return [number]        [影响行数]
    */
    public function del($where)
    {  
       $res=$this;
       if(!empty($where)){
           $res=$this->CustomizeWhere($res,$where);
           if(!$res){
              return false;
           }
       }else{
          return false;
       }
       $res=$res->delete();
       return $res;
    }
   
    /**
     * [聚合查询]
     * @param  array  $where [条件]
     * @param  string $field [字段]
     * @param  string $use   [以下选项]
      // count 统计数量，参数是要统计的字段名（可选）
      // max   获取最大值，参数是要统计的字段名（必须）
      // min   获取最小值，参数是要统计的字段名（必须）
      // avg   获取平均值，参数是要统计的字段名（必须）
      // sum   获取总分，参数是要统计的字段名（必须）
    */
    public function use($where=[],$field='',$use='count')
    {   
        $res=$this;
        if(!empty($where)){
           $res=$this->CustomizeWhere($res,$where);
           if(!$res){
              return false;
           }
        }
    
        $res=$res->$use($field);
        return $res;
    }

    /**
     * [组合where条件 用来处理复杂的where条件]
     * @param [type] $list  [模型对象]
     * @param [type] $where [where条件]
        $where=[
            'id'=>1,
            ['age','>',2],
            ['date','between','1,2'],
            ['type','in',[1,2]],
            ['name','or','sb'],
        ];
        这里只封装常见的 有需要可以自己添加
    */
    public function CustomizeWhere($list,$where)
    {
        if(empty($where)||empty($list)){
           return false;
        }else{
            foreach ($where as $key => $value) {
                if(is_array($value)){
                    if($value[1]=='>'||$value[1]=='<'||$value[1]=='<>'||$value[1]=='<='||$value[1]=='>='||strtolower($value[1])=='like'||$value[1]=='='){
                        $list=$list->where($value[0],$value[1],$value[2]);
                    }elseif(strtoupper($value[1])=='BETWEEN'){
                        if(!is_array($value[2])){
                            $value[2]=explode(',', $value[2]);
                        }
                        $list=$list->whereBetween($value[0],$value[2]);
                    }elseif(strtoupper($value[1])=='NOTBETWEEN'){
                        if(!is_array($value[2])){
                            $value[2]=explode(',', $value[2]);
                        }
                        $list=$list->whereNotBetween($value[0],$value[2]);
                    }elseif(strtoupper($value[1])=='IN'){
                        if(!is_array($value[2])){
                            $value[2]=explode(',', $value[2]);
                        }
                        $list=$list->whereIn($value[0],$value[2]);
                    }elseif(strtoupper($value[1])=='NOTIN'){
                        if(!is_array($value[2])){
                            $value[2]=explode(',', $value[2]);
                        }
                        $list=$list->whereNotIn($value[0],$value[2]);
                    }elseif(strtoupper($value[1])=='OR'){
                        $list=$list->orWhere($value[0],$value[2]);
                    }else{
                        continue;
                    }
                }else{
                    $list=$list->where($key,$value);
                }        
            }
            return $list;
        }
    }

    /**
     * [组合排序条件]
     * @param [type] $list  [模型对象]
     * @param [type] $order [排序条件]
    */
    public function CustomizeOrderBy($list,$order)
    {
        //排序处理
        if(empty($order)){
           $order_key=$this->primaryKey;
           $sort='asc';
           $list=$list->orderBy($order_key,$sort);
        }else{
            if(is_array($order)){
               foreach ($order as $key => $value) {
                   $value=explode(',', $value);
                   $list=$list->orderBy($value[0],$value[1]);
               }
            }else{
               $order_key=$this->primaryKey;
               $sort='asc';
               $list=$list->orderBy($order_key,$sort);
            }
        }

        return $list;
    }

}

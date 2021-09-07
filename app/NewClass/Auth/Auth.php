<?php
namespace app\NewClass\Auth;

use DB;

/**
 * 权限认证类
 * 功能特性：
 * 1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      $auth=new Auth();  $auth->check('规则名称','用户id')
 * 2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth=new Auth();  $auth->check('规则1,规则2','用户id','and')
 *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限。 当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
 * 3，一个用户可以属于多个用户组(think_auth_group_access表 定义了用户所属用户组)。我们需要设置每个用户组拥有哪些规则(think_auth_group 定义了用户组权限)
 *
 * 4，支持规则表达式。
 *      在auth_rules 表中定义一条规则时，如果type为1， rule_condition字段就可以定义规则表达式。 如定义{score}>5  and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。
*/

class Auth
{

    //默认配置
    protected $_config;

    protected $uid;//由于每个人的用户表的 id 不同 

    public function __construct()
    {   
        $prefix                             = '';
        $this->_config=[
            'AUTH_ON'           => true, // 认证开关
            'AUTH_TYPE'         => 1, // 认证方式，1为实时认证；2为登录认证。
            'AUTH_GROUP'        => trim($prefix . 'jh_auth_groups'), // 用户组数据表名
            'AUTH_GROUP_ACCESS' => trim($prefix . 'jh_auth_group_accesses'), // 用户-用户组关系表
            'AUTH_RULE'         => trim($prefix . 'jh_auth_rules'), // 权限规则表
            'AUTH_USER'         => trim($prefix . 'jh_admins'), // 用户表
            'uid'               => 'admin_id', // 用户表id  由于每个用户的id名称不同 
        ];
        $this->uid='admin_id';
    }

    /**
     * 检查权限
     * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组  被验证的路由
     * @param uid  int           认证用户的id admin_id
     * @param string mode        执行check的模式
     * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return boolean           通过验证返回true;失败返回false
     */
    public function check($name, $uid, $type = 1, $mode = 'url', $relation = 'or')
    {
        if (!$this->_config['AUTH_ON']) {
            return true;
        }
        $authList = $this->getAuthList($uid, $type); //获取用户需要验证的所有有效规则列表
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //保存验证通过的规则名
        if ('url' == $mode) {
            $REQUEST = unserialize(strtolower(serialize($_REQUEST)));
        }
        foreach ($authList as $auth) {
            $query = preg_replace('/^.+\?/U', '', $auth);
            if ('url' == $mode && $query != $auth) {
                parse_str($query, $param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST, $param);
                $auth      = preg_replace('/\?.*$/U', '', $auth);
                if (in_array($auth, $name) && $intersect == $param) {
                    //如果节点相符且url参数满足
                    $list[] = $auth;
                }
            } else if (in_array($auth, $name)) {
              
                $list[] = $auth;
            }
        }
        if ('or' == $relation and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ('and' == $relation and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户id获取用户组,返回值为数组
     * @param  uid int     用户id
     * @return array       用户所属的用户组 array(
     *     array('admin_id'=>'用户id','group_id'=>'用户组id','group_name'=>'用户组名称','rule_id'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)
     */
    public function getGroups($uid)
    {  
        static $groups = array();
        if (isset($groups[$uid])) {
            return $groups[$uid];
        }
        $a=$this->_config['AUTH_GROUP_ACCESS'];
        $g=$this->_config['AUTH_GROUP'];
        //用户组明细表  和 用户组表
        // $user_groups = Db::name($a)->alias('a')->field([])->join("$g g","=")->where(["a.$this->uid"=>$uid,'g.group_status'=>1])->select();
        $where=[
            ["$a.$this->uid",'=',$uid],
            ["$g.group_status",'=',1],
        ];
        $user_groups = DB::table($a)
            ->join($g, "$a.group_id", '=', "$g.group_id")
            ->where($where)
            ->select("$a.*", "$g.*")
            ->get();
        if(empty($user_groups)){
           $groups[$uid]=[];
        }else{
           $groups[$uid]=$user_groups->toArray();
        }
        return $groups[$uid];
    }

    /**
     * 获得权限列表
     * @param integer $uid  用户id admin_id
     * @param integer $type
     */
    protected function getAuthList($uid, $type)
    {   
        static $_authList = array(); //保存用户验证通过的权限列表
        $t                = implode(',', (array) $type);
        if (isset($_authList[$uid . $t])) {
            return $_authList[$uid . $t];
        }
        if (2 == $this->_config['AUTH_TYPE'] && isset($_SESSION['_AUTH_LIST_' . $uid . $t])) {
            return $_SESSION['_AUTH_LIST_' . $uid . $t];
        }
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids    = array(); //保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g->rule_id, ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid . $t] = array();
            return array();
        }
       
        $map =[
            ['rule_status','=',1],
        ];
        //读取用户组所有权限规则
        $rules = DB::table($this->_config['AUTH_RULE'])
                ->whereIn('rule_id', $ids)
                ->where($map)
                ->select('rule_id',"rule_condition", "rule_url")
                ->get()->toArray();
        //循环规则，判断结果。
        $authList = array(); //
        foreach ($rules as $rule) {
            if (!empty($rule->rule_condition)) {
                //根据rule_condition进行验证
                $user = $this->getUserInfo($uid); //获取用户信息,一维数组
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule->rule_condition);
                //dump($command);//debug
                @(eval('$rule_condition=(' . $command . ');'));
                if ($rule_condition) {
                    $authList[] = strtolower($rule->rule_url);
                }
            } else {
                //只要存在就记录
                $authList[] = strtolower($rule->rule_url);
            }
        }
        $_authList[$uid . $t] = $authList;
        if (2 == $this->_config['AUTH_TYPE']) {
            //规则列表结果保存到session
            $_SESSION['_AUTH_LIST_' . $uid . $t] = $authList;
        }
        return array_unique($authList);
    }

    /**
     * 获得用户资料,根据自己的情况读取数据库
     */
    protected function getUserInfo($uid)
    {
        static $userinfo = array();
        if (!isset($userinfo[$uid])) {
            $userinfo[$uid] = DB::table($this->_config['AUTH_USER'])
                ->where($this->uid,$uid)
                ->select()
                ->first();
        }
        return get_object_vars($userinfo[$uid]);
    }

}

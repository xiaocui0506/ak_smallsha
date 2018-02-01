<?php
namespace Smallsha\wuxianji;



/**
 * 个人博客：迹忆博客
 * 博客地址：www.onmpw.com
 * 封装无限级分类
 */
class wuXian{
    /**
     * 配置项
     * @var array
     */
    private $config = array(
        'requestField'=>array('id'),
        'queryType'=>1,  //查询方式    1-表示使用非递归方式    2-表示使用递归方式
        'parFieldname'=>'parId',
        'idFieldname' => 'id',
        'isReturnDep' => 1 //是否返回深度，1表示返回深度        0 表示不反悔
    );
    /**
     * 要查询的数据
     * @var array
     */
    private $channels;  //要查询的数据
    /**
     * 存放整理完成的数据
     * @var array
     */
    private $html = array();
    /**
     * 过程中用到的栈
     * @var array
     */
    private $stack = array();
    /* private $channels = array(
        array('id'=>1,'name'=>"衣服",'parId'=>0),
        array('id'=>2,'name'=>"书籍",'parId'=>0),
        array('id'=>3,'name'=>"T恤",'parId'=>1),
        array('id'=>4,'name'=>"裤子",'parId'=>1),
        array('id'=>5,'name'=>"鞋子",'parId'=>1),
        array('id'=>6,'name'=>"皮鞋",'parId'=>5),
        array('id'=>7,'name'=>"运动鞋",'parId'=>5),
        array('id'=>8,'name'=>"耐克",'parId'=>7),
        array('id'=>9,'name'=>"耐克",'parId'=>3),
        array('id'=>10,'name'=>"鸿星尔克",'parId'=>7),
        array('id'=>11,'name'=>"小说",'parId'=>2),
        array('id'=>12,'name'=>"科幻小说",'parId'=>11),
        array('id'=>13,'name'=>"古典名著",'parId'=>11),
        array('id'=>14,'name'=>"文学",'parId'=>2),
        array('id'=>15,'name'=>"四书五经",'parId'=>14)
    ); */
    /**
     * 构造函数，主要对实例进行一些初始化工作
     * @param array $config
     */
    public function __construct($config=array()){
        if(count($config)>0){
            $this->config = array_merge($this->config,$config);
        }
        
    }


    public function test(){
    	return '12321312';
    }
    /**
     * 设置要查询的数据
     * @param array $channels
     * @return operaChannel  返回当前对象
     */
    public function setData($channels=array()){
        $this->channels = $channels;
        return $this;
    }
    /**
     * 开始流程
     */
    public function start(){
        /*
         * 判断查询方式
         */
        if($this->config['queryType'] == 1){
            $this->query();
        }else{
            $this->recurQuery(0,1);
        }
    }
    /**
     * 非递归查询函数
     */
    private function query(){
        /*
         * 首先将顶级栏目入栈
         */
        foreach($this->channels as $key=>$val){
            if($val[$this->config['parFieldname']] == 0){
                $this->push($val,1);
            }
        }
        do{
            $par = $this->pop();
            for($i=0;$i<count($this->channels);$i++){
                if($this->channels[$i][$this->config['parFieldname']] == $par['channel'][$this->config['idFieldname']]){
                    $this->push($this->channels[$i],$par['dep']+1);
                }
            }
            if($this->config['isReturnDep'] == 1){
                $arr = array('dep'=>$par['dep']);
            }elseif($this->config['isReturnDep'] == 0){
                $arr = array();
            }
            foreach($this->config['requestField'] as $v){
                $arr[$v] = $par['channel'][$v];
            }
            $this->html[] = $arr;
        }while(count($this->stack)>0);
    }
    
    private function recurQuery($parid,$dep){
        /*
         * 遍历数据，查找parId为参数$parid指定的id
         */
        for($i = 0;$i<count($this->channels);$i++){
            if($this->channels[$i]['parId'] == $parid){
                if($this->config['isReturnDep'] == 1){
                    $arr = array('dep'=>$dep);
                }elseif($this->config['isReturnDep'] == 0){
                    $arr = array();
                }
                foreach($this->config['requestField'] as $v){
                    $arr[$v] = $this->channels[$i][$v];
                }
                $this->html[] = $arr;
                self::recurQuery($this->channels[$i]['id'],$dep+1);
            }
        }
    }
    
    /**
     * 入栈函数
     * @param array $channel  要入栈的数据
     * @param int $dep   深度
     */
    private function push($channel,$dep){
        array_push($this->stack,array('channel'=>$channel,'dep'=>$dep));
    }
    /**
     * 出栈函数
     * @return mixed
     */
    private function pop(){
        return array_pop($this->stack);
    }
    /**
     * 返回最后结果
     */
    public function getResult(){
        return $this->html;
    }
    
}
?>

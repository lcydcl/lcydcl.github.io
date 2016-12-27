<?php

Class IndexAction extends Action
{
	public function index()
	{
		//echo U(GROUP_NAME.'/List/index');die;
		//将缓存文件到runtime 中temp文件中。
		
		if(!$list=S('index_list'))
		{echo 111;
			$list=M('cate')->where(array('pid'=>0))->order('sort')->select();
			//p($topCate);
			import('Class.Category',APP_PATH);
			$cate=M('cate')->order('sort')->select();
			$db=M('blog');
			$field=array('id','title','time');
			foreach($list as $k=>$v)
			{
				$cids=Category::getChildsId($cate,$v['id']);
				$cids[]=$v['id'];
				$where=array('cid'=>array('IN',$cids));
				$list[$k]['blog']=$db->field($field)->where($where)->order('time DESC')->select();
			}
		}
	

		//生成缓存
		S('index_list',$list,1);
		$this->cate=$list;
	//	p($cate);die;
		$this->display();
	}
} 
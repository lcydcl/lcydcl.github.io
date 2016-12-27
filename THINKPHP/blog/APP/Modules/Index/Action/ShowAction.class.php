<?php

Class ShowAction extends Action
{
	Public function index()
	{
		$id=(int)$_GET['id'];
	  //$where=array('id'=>'$id');
	//setInc给指定的字段加一
      M('blog')->where(array('id'=>$id))->setInc('click');
	  $field=array('id','title','time','content','cid');
	  $this->blog=M('blog')->field($field)->find($id);

	 $cid=$this->blog['cid'];
	 import('Class.Category',APP_PATH);
	 $cate=M('cate')->order('sort')->select();
	 $this->parent=Category::getParents($cate,$cid);

	  $this->display();
	}
	//当采用缓存机制的时候，不走index函数的时候，需要采用此函数，对文章进行自增一
	Public function clickNum()
	{
		$id=(int)$_GET['id'];
		$where=array('id'=>$id);
		//为了保存一致注意
		$click=M('blog')->where($where)->getField('click');
		M('blog')->where($where)->setInc('click');

		//w威慑呢这样写
		echo 'document.write('.$click.')';
	}
}
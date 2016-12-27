<?php
Class ListAction extends Action
{
	Public function index()
	{
		import('Class.Category',APP_PATH);
		import('ORG.Util.Page');

		$id=(int)$_GET['id'];
		$cate=M('cate')->order('sort')->select();

		
		$cids=Category::getChildsId($cate,$id);    
		$cid[]=$id;


		$where=array('cid'=>array('IN',$cids));
		$count=M('blog')->where($where)->count();
		
		$page=new Page($count,1);
		$limit=$page->firstRow.','.$page->listRows;

		
		$this->blog=D('BlogView')->getAll($where,$limit);
        $this->page=$page->show(); 
        $this->display();
	}
}
?>    
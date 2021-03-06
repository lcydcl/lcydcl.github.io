<?php
Class CategoryAction extends CommonAction
{
	//分类列表视图
	Public function index()
	{
		import('Class.Category',APP_PATH);
		$cate=M('cate')->order('sort ASC')->select(); 
		//$cate=Category::getParents($cate,12);
		//$cate=Category::getChilds($cate,4);
		//$cate=Category::unLimitedForLayer($cate,'cate');
		// p($cate);
		$this->cate=Category::unLimitedForLevel($cate,'&nbsp;&nbsp;--');
		$this->display();
	}
	//添加分类视图
	Public function addCate()
	{
		$this->pid=I('pid',0,'intval');
		$this->display();
	}
	//添加分类表单处理
	Public function runAddCate()
	{
		if(M('cate')->add($_POST))
		{
			$this->success('添加成功',U(GROUP_NAME.'/Category/index'));
		}else
		{
			$this->error('添加失败');
		}
	}
	//排序
	Public function sortCate()
	{
		$db=M('cate');
		foreach ($_POST as $id => $sort) {
			$db->where(array('id'=>$id))->setField('sort',$sort);
		}
		$this->redirect(GROUP_NAME.'/Category/index');
	}
}
?>  
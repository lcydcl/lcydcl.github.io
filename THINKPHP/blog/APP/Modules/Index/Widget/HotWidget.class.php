<?php
Class HotWidget extends Widget
{
	Public function render($data)
	{
		$field=array('id','title','click');
		$data['blog']=M('blog')->field($field)->order('click DESC')->limit(5)->select();

		return $this->renderFile('',$data);
	}
}
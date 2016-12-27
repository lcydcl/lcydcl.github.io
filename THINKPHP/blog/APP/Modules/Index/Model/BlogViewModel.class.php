  <?php
  Class BlogViewModel extends ViewModel
  {
  	Protected $viewFields=array(
  		'blog'=>array(
  			'id','title','time','click','summary',
  			'_type'=>'LEFT'
  			),
  		'cate'=>array(
  			'name','_on'=>'blog.cid=cate.id'
  			)
  		);
  	Public function getAll($where,$limit)
  	{
      //按照文章发布时间降序进行排列
  		return $this->where($where)->limit($limit)->order('time DESC')->select();
  	}
  }
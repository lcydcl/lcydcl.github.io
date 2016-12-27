<?php
Class BlogAction extends CommonAction
{
	//博文列表
	Public function index()
	{
		$this->blog=D('BlogRelation')->getBlogs();
  		$this->display();
	}
	//删除/还原到回收站
	Public function toTrach()
	{
		$type=(int)$_GET['type'];
		//p($type);die;
		$msg=$type ? '删除':'还原 ';
		$update=array(
				'id'=>(int)$_GET['id'],
				'del'=>$type
			);
		//M('blog')->where(array('id'=>(int)$_GET['id']))->save($update);
		//M('blog')->where(array('id'=>(int)$_GET['id']))->setField('del',1);
		if(M('blog')->save($update))
		{
			$this->success($msg.'成功',U(GROUP_NAME.'/Blog/index'));
		}else
		{
			$this->error($msg.'失败');
		}
	
	}
	//回收站
	Public function trach()  
	{
		$this->blog=D('BlogRelation')->getBlogs(1);
		$this->display('index');

	}
	Public function delete()
	{
		$id=(int)$_GET['id'];
		if(M('blog')->delete($id))
		{
			M('blog_attr')->where(array('bid'=>$id))->delete();
			$this->success('删除成功',U(GROUP_NAME.'/Blog/Trach'));		
		}
		else
		{
			$this->error('删除失败');
		}

	}
    




	//添加博文
	Public function blog()
	{
		//所属分类
		import('Class.Category',APP_PATH);
		$cate=M('cate')->order('sort')->select();
		$this->cate=Category::unlimitedForLevel($cate);

		//博文属性
		$this->attr=M('attr')->select();


		$this->display();
	}
	//添加博文表单处理
	Public function addBlog()
	{
		
		$data=array(
			'title'=>$_POST['title'],
			'content'=>$_POST['content'],
			'summary'=>$_POST['summary'],
			'time'=>time(),
			'click'=>(int)$_POST['click'],
			'cid'=>(int)$_POST['cid']
			);
		if($bid=M('blog')->add($data))
		{
			if(isset($_POST['aid']))
			{
				$sql='INSERT INTO`'.C('DB_PREFIX').'blog_attr`(bid,aid)
				VALUES';
				foreach ($_POST['aid'] as  $v)
				{
					$sql.='('.$bid.','.$v.'),';
				}
				$sql=rtrim($sql,',');
				M('blog_attr')->query($sql);
			}
			$this->success('添加成功',U(GROUP_NAME.'/Blog/index'));	
		}else
		{
			$this->error('添加失败');
		}
		/*if(isset($_POST['aid']))
		{
			foreach($_POST['aid'] as $v)
			{
				$data['attr'][]=$v;
			}
		}
		D('BlogRelation')->relation(true)->add($data);
		
		$this->display();*/
	}

	//编辑器图片上传处理
	Public function upload()
	{
		import('ORG.Net.UploadFile'); 
		$upload=new UploadFile();//优先级比较高
		$upload->autoSub=true;
		$upload->subType='date';
		$upload->dateFormatd='Ym';
		if($upload->upload('./Uploads/'))
		{
			$info=$upload->getUploadFileInfo();
			import('ORG.Util.Image');
			Image::water('./Uploads/'.$info[0]['savename'],'./Data/logo.png');
			echo json_encode(array(
				'url'=>$info[0]['savename'],
				'title'=> htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
				'original'=>$info[0]['name'],
				'state'=>'SUCCESS'
				));
			
		}else
		{
			echo json_encode(array(
				'state'=>$upload->getErrorMsg()
				));
		}
		
	
		 
   
      /*{
        'url'      :'a.jpg',   //保存后的文件路径
        'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
        'original' :'b.jpg',   //原始文件名
        'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
      }*/
     
	}

}
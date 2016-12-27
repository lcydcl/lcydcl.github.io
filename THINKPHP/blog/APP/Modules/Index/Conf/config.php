<?php
return array(
	'APP_AUTOLOAD_PATH'=>'@.TagLib',
	'TAGLIB_BUILD_IN'=>'Cx,Hd',

	//开启静态缓存
	 //{id}说明以get的方式得到静态缓存，module代表当前控制器
	 'HTML_CACHE_ON'=>true,
	 'HTML_CACHE_RULES'=>array(
	 	'Show:index'=>array('{:module}_{:action}_{id}',0),
	 	),
	 //动态缓存方式
	 //存在错误，windows不支持memcache动态缓存
	 'DATA_CACHE_TYPE'=>'File',
	 'MEMCACH_HOST'=>'127.0.0.1',
	 'MEMCACHE_PORT'=>11211
	); 
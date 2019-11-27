<?php
namespace Owenzhou\LaravelRbac;

class Permission{

	//递归获取目下所有文件
	protected static function getFiles($dir){
		if( !is_dir($dir) ){
			return $dir;
		}

		$result = [];
		$handle = opendir($dir);
		while(false !== ($file = readdir($handle))){
			if($file == '.' || $file == '..')
				continue;

			$realPath = $dir.DIRECTORY_SEPARATOR.$file;
			if( is_file($realPath) ){
				$result[] = $realPath;
			}else{
				$result = array_merge($result, self::getFiles($realPath));
			}
		}
		return $result;
	}

	//根据目录获取权限控制器及权限列表
	public static function getPermissions($path = __DIR__, $namespace = 'App\Http\Controllers'){
		//$files = glob($path . DIRECTORY_SEPARATOR .'*.php');
		$files = self::getFiles($path);
    	$list = [];
    	foreach($files as $index => $file){
    		$class = $namespace.'\\'.basename($file, '.php');
			if( false !== ($find = stristr($file, $namespace)) ){
				$class = str_ireplace([$namespace, '.php'], [$namespace, ''], $find);
			}
			
    		$reflect = new \ReflectionClass( $class );
    		if( !($doc = $reflect->getDocComment()) )
    			continue;

    		$contr =  trim($doc, "/*\r\n ");
    		$list[$index]['name'] = $contr;
			$list[$index]['methods'] = [];
    		$methods = $reflect->getMethods(\ReflectionMethod::IS_PUBLIC);
    		foreach($methods as $i => $method){
    			if( !($mDoc = $reflect->getMethod($method->name)->getDocComment()) )
    				continue;
    			if( !preg_match('/[\x{4e00}-\x{9fa5}]/u', $mDoc) )
    				continue;
    			$fDoc = trim($mDoc, "/*\n\t ");
				$list[$index]['methods'][$i]['name'] = $fDoc;
    			$list[$index]['methods'][$i]['route'] = $class. '@' .$method->name;

    		}
    	}
		$list = array_values($list);
    	return $list;
	}

}
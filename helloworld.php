<?php

defined ( '_JEXEC' ) or die ();

/*
require_once JPATH_ADMINISTRATOR . '/components/com_content/models/article.php';

$new_article = new ContentModelArticle ();

$options = array (
		'driver' => 'mysqli',
		'host' => '192.168.120.18',
		'user' => 'root',
		'password' => '123456',
		'database' => 'shengzhi',
		'prefix' => 'qyfy_' 
);

$db_dede = JDatabaseDriver::getInstance ( $options );

$query_dede = $db_dede->getQuery ( true );

$query_dede->select ( $db_dede->quoteName ( array ('id','title') ) )
		   ->from ( $db_dede->quoteName ( '#__archives' ) )
           ->where ( $db_dede->quoteName ( 'typeid' ) . ' = 267' )
           ->order ( 'sortrank ASC' )
		   ->setLimit(0,10);;

$db_dede->setQuery ( $query_dede );

$results_dedeart = $db_dede->loadObjectList ();

if ($results_dedeart) {
	foreach ( $results_dedeart as $art ) {
		$query_art = $db_dede->getQuery ( true );
		
		$query_art->select ( $db_dede->quoteName ( 'body' ) )
		          ->from ( $db_dede->quoteName ( '#__addonarticle' ) )
		          ->where ( $db_dede->quoteName ( 'aid' ) . ' = ' . $art->id );
		
		$db_dede->setQuery ( $query_art );
		
		$artbody = $db_dede->loadResult ();
		
		$data_art = array (
				'id' => 0,
				'title' => $art->title,
				'articletext' => $artbody,
				'state' => 1,
				'alias' => $cat_ks->alias . '_' . $art->id,
				'catid' => $cat_ks->id,
				'language' => '*' 
		);
		
		if ($new_article->save ( $data_art )) {
			var_dump ( $art->title . ' save to ' . $cat_ks->title );
		} else {
			var_dump ( $art->title . 'fail to!' );
			var_dump ( $new_article->getErrors () );
		}
	}
}




/* 
 * ------------------以下是将科室中的文章转存到Joomla中-----------*/

require_once  JPATH_ADMINISTRATOR . '/components/com_content/models/article.php';

$new_article = new ContentModelArticle();

$db = JFactory::getDbo();
$query = $db->getQuery(true);

$query->select($db->quoteName(array('id','asset_id','title','note','alias')))
		->from($db->quoteName('#__categories'))
		->where($db->quoteName('id') . ' > 264')
		->order('id ASC')
		->setLimit(10,40);

//echo $query->dump();

$db->setQuery($query);

$results_ca = $db->loadObjectList();

//var_dump($results_ca);die;

$options = array (
		'driver' => 'mysqli',
		'host' => '192.168.120.18',
		'user' => 'root',
		'password' => '123456',
		'database' => 'shengzhi',
		'prefix' => 'qyfy_'
);

$db_dede = JDatabaseDriver::getInstance ( $options );

foreach($results_ca  as $cat_ks){
//	var_dump($cat_ks);
	$query_dede = $db_dede->getQuery(true);

	$query_dede->select($db_dede->quoteName(array('id','title')))
			->from($db_dede->quoteName('#__archives'))
			->where($db_dede->quoteName('typeid') . ' = ' .$cat_ks->note)
			->order('weight ASC');

	$db_dede->setQuery($query_dede);

	$results_dedeart = $db_dede->loadObjectList();

	if($results_dedeart){
		foreach($results_dedeart as $art){
			$query_art = $db_dede->getQuery(true);
			
			$query_art->select($db_dede->quoteName('body'))
					->from($db_dede->quoteName('#__addonarticle'))
					->where($db_dede->quoteName('aid') . ' = ' .$art->id);
			
			$db_dede->setQuery($query_art);

			$artbody= $db_dede->loadResult();
				
			$data_art = array (
					'id' => 0,
					'title' => $art->title,
					'articletext' => $artbody,
					'state' => 1,
					'alias' => $cat_ks->alias.'_'.$art->id,
					'catid' => $cat_ks->id,
					'language' => '*',
			);
				
			if($new_article->save($data_art)){
				var_dump($art->title.' save to '.$cat_ks->title);
			}else{
				var_dump($art->title.'fail to!');
				var_dump($new_article->getErrors());
			}
		}
	}
} 

 /*------------------以上是将科室中的文章转存到Joomla中-----------*/





/* 
 * 
  --------------------以下是把科室的目录转存到Joomla中----------------------------

require_once JPATH_ADMINISTRATOR . '/components/com_categories/models/category.php';
require_once JPATH_ADMINISTRATOR . '/components/com_categories/tables/category.php';

$new_category = new CategoriesModelCategory ();

$options = array (
		'driver' => 'mysqli',
		'host' => '192.168.120.18',
		'user' => 'root',
		'password' => '123456',
		'database' => 'shengzhi',
		'prefix' => 'qyfy_' 
);

$db_dede = JDatabaseDriver::getInstance ( $options );

$query_dede = $db_dede->getQuery ( true );


// SELECT `id`,`typename`,`typedir`
// FROM `qyfy_arctype`
// WHERE `reid` = '0'
// ORDER BY sortrank ASC LIMIT 0, 10 


$query_dede->select($db_dede->quoteName(array('id','typename','typedir')))
		->from($db_dede->quoteName('#__arctype'))
		->order('sortrank ASC')
		->where($db_dede->quoteName('reid') . ' = '. $db_dede->quote('0'))
		->setLimit(4,57);    //(数量，开始位置 )

//echo $query_dede->dump();

$db_dede->setQuery($query_dede);

$results_dedetype = $db_dede->loadObjectList(); 

//var_dump( $results_dedetype);die;

foreach ($results_dedetype as $sanjikeshi){

	$keshiname3 = substr($sanjikeshi->typedir,strrpos($sanjikeshi->typedir,'/')+1,strlen($sanjikeshi->typedir)-strrpos($sanjikeshi->typedir,'/'));

	$data3 = array (
			'id' => 0,
			'hits' => '0',
			'parent_id' => '0',
			'extension' => 'com_content',
			'title' => $sanjikeshi->typename,
			'alias' => $keshiname3,
			'note' => $sanjikeshi->id,    //把原来的ID存入备注中，方便之后存入文章
			'published' => '1',
			'access' => '1',
			'language' => '*'
	);
	
	//var_dump($data3);

 	if($new_category->save($data3)){
		var_dump($sanjikeshi->typename.'save to db ');
	}else {
		var_dump($sanjikeshi->typename.'fail ');
	}
	
	//以下是把这层目录的子目录读出来，然后存到这层子目录下
	$par_id = $new_category->getState('category.id');

	$query2 = $db_dede->getQuery(true);
	$query2->select($db_dede->quoteName(array('id','typename','typedir')))
			->from($db_dede->quoteName('#__arctype'))
			->order('sortrank ASC')
			->where($db_dede->quoteName('reid') . ' = '. $sanjikeshi->id);
	
	$db_dede->setQuery($query2);
	$results4 = $db_dede->loadObjectList();
	
	foreach ( $results4 as $sijikeshi ) {
		$keshiname4 = substr ( $sijikeshi->typedir, strrpos ( $sijikeshi->typedir, '/' ) + 1, strlen ( $sijikeshi->typedir ) - strrpos ( $sijikeshi->typedir, '/' ) );
		$data4 = array (
				'id' => 0,
				'hits' => '0',
				'parent_id' => $par_id,
				'extension' => 'com_content',
				'title' => $sijikeshi->typename,
				'alias' => $keshiname4,
				'note' => $sijikeshi->id,
				'published' => '1',
				'access' => '1',
				'language' => '*' 
		);
		
		if ($new_category->save ( $data4 )) {
			var_dump ( $sijikeshi->typename . 'save to db ' );
		} else {
			var_dump ( $sijikeshi->typename . 'fail' );
		}
	}  
} 


 --------------------以上是把科室的目录转存到Joomla中----------------------------
 */

/*
	SELECT `id`,`title`,`senddate`
	FROM `qyfy_archives`
	WHERE `typeid` = 3
	ORDER BY senddate ASC LIMIT 0, 1
 */

/*  $query_dede->select($db_dede->quoteName(array('id','title','senddate')))
			->from($db_dede->quoteName('#__archives'))
			->where($db_dede->quoteName('typeid') . ' = 10')
			->where($db_dede->quoteName('arcrank') . ' = 0')
			->order('senddate ASC')
 			->setLimit(100,120);    
 
 
 $db_dede->setQuery($query_dede);
 
 $results_dedeart = $db_dede->loadObjectList(); */
 
 //var_dump( $results_dedeart);
 
/*     foreach ( $results_dedeart as $art ) {
	$query_art = $db_dede->getQuery ( true );
	$query_art->select ( $db_dede->quoteName ( 'imgurls' ) )
			  ->from ( $db_dede->quoteName ( '#__addonimages' ) )
	          ->where ( $db_dede->quoteName ( 'aid' ) . ' = ' . $art->id );
	$db_dede->setQuery ( $query_art );
	$artbody= $db_dede->loadResult();
	
	$str_1 = "{dede:pagestyle maxwidth='800' pagepicnum='12' ddmaxwidth='200' row='3' col='4' value='2'/}";
	$str_2 = "{dede:pagestyle maxwidth='800' pagepicnum='12' ddmaxwidth='200' row='3' col='4' value='1'/}";
	$str_3 = "{dede:pagestyle maxwidth='800' pagepicnum='1' ddmaxwidth='200' row='3' col='4' value='1'/}";
	$str_4 = "text=''";
	
	$artbody = str_replace($str_1, "", $artbody);
	$artbody = str_replace($str_2, "", $artbody);
	$artbody = str_replace($str_3, "", $artbody);
	$artbody = str_replace($str_4, "", $artbody);
	
	$artbody = str_replace("{dede:", "<", $artbody);
	$artbody = str_replace("{/dede:", "</", $artbody);
	$artbody = str_replace("}", ">", $artbody);
	$artbody = str_replace("ddimg", "src", $artbody);
	
	$created_date=date('Y-m-d H:i:s', $art->senddate);

	$data_art = array (
			'id' => 0,
			'title' => $art->title,
			'articletext' => $artbody,
			'state' => 1,
			'alias' => 'meiti_'.$art->id,
			'created' => $created_date,
			'catid' => '23',
			'language' => '*',
	); */
	

	//var_dump($data_art);
 	
/*  	if ($new_article->save ( $data_art )) {
		var_dump ( $art->title . ' saved');
	} else {
		var_dump ( $art->title . 'fail to!' );
		var_dump ( $new_article->getErrors () );
	}  
	 
} */

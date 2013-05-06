<?php

class AdminHelper extends AppHelper {
	
	public $helpers = array("Html","Paginator");
	
	
	public function attachMediaLink($model,$key,$val,$post_back) {
		
		return $this->Html->link("Attach Media",array("controller"=>"media_files","action"=>"attach_media",$model,$key,$val,base64_encode($post_back)));
		
	}

	public function attachPostUrl($model,$key,$val,$post_back,$extra = array()) {
		
		$ops = array(
					"plugin"=>"",
					"controller"=>"attach_post",
					"action"=>"index",
					$model,
					$key,
					$val,
					"cb"=>base64_encode($post_back)
				);

		$ops = array_merge($ops,$extra);

		return $this->Html->url($ops);

	}

	public function attachMediaUrl($model,$key,$val,$post_back,$extra = array()) {
		
		$ops = array(
					"plugin"=>"",
					"controller"=>"attach_media",
					"action"=>"index",
					$model,
					$key,
					$val,
					"cb"=>base64_encode($post_back)
				);

		$ops = array_merge($ops,$extra);

		return $this->Html->url($ops);

	}
	
	public function monthlyReportLink($opt = array()) {
		
		$params = array();
		
		$date = $opt['date'];
		
		$data = $opt['data'];
		//check to see if we have a dim_domain_id 
		if(isset($data['Filters']['dim_domain_id'])) {
			
			$params['dim_domain_id'] = $data['Filters']['dim_domain_id'];
			
		}
		
		$params[] = $date;
		
		
		$link = array("controller"=>"traffic_reports","action"=>"day");
		
		//merge link and params
		
		$merge = array_merge($link,$params);
		
		return $this->Html->link($opt['label'],$merge);
		
		
	}
	
	public function quickTagEdit($Tags,$show_delete = false) {
		
		$str = '';
		
		foreach($Tags as $t) {
			$str.="<div class='well well-small' style='float:left; margin-right:3px;'>";
			if (!empty($t['user_id'])) {
				
				$str .= "<i class='icon icon-user'></i> ";
			}
			$str .= $this->link($t['name'],array("controller"=>"tags","action"=>"edit",$t['id'],"plugin"=>""),array("target"=>"_blank"));
			if ($show_delete) {
				$str .= "&nbsp; <button class='btn btn-mini btn-danger remove-tag-btn' data-tag-id='{$t['id']}' type='button'>x</button>";
			}
			$str .="</div>";
		}
		
		return "<div class='clearfix'>{$str}</div>";
		
	}
	
	public function adminPaging() {
	
		$pages = $this->Paginator->numbers(array(
	
				"tag"=>"li",
				"separator"=>null,
				"currentClass"=>"active",
				"modulus"=>5
		));
	
	
		$next = $this->Paginator->next("&rarr;",array("tag"=>"li","escape"=>false),null,array("tag"=>"li","escape"=>false));
		$prev = $this->Paginator->prev("&larr;",array("tag"=>"li","escape"=>false),null,array("tag"=>"li","escape"=>false));
	
		$list = $this->Html->tag("ul",$prev.$pages.$next,array("class"=>"nav nav-pills"));
	
		$p = $this->Paginator->counter(array(
				'format' =>'<strong>Page</strong> <span class="badge badge-info">%page% of %pages%</span> Total <span class="badge badge-success">%count%</span>'
		));
	
		return $this->Html->tag("div",$p.$list,array("class"=>"adminPager"));
	
	}
	
	public function url($url) {
	
		if(is_array($url) && !isset($ops['cb'])) $url['cb'] = base64_encode($this->request->here);
	
		return $this->Html->url($url);
	
	}
	
	public function link($label,$url,$ops=array()) {
		
		
		if(!isset($this->request->params['named']['cb'])) $ops['cb'] = base64_encode($this->request->here);
		
		return $this->Html->link($label,$url,$ops);
		
	}
	
	
}



?>
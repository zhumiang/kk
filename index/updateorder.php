<?php
/**
 * @copyright Copyright (c) 2005 - 2008 kele China Inc.
 * @author zhuming
 * @package kelecms
 * @subpackage app/contro
 * @version $Id: updateorder.php  2008--@zhuming$
 */
!defined('kele_start') && die('NOTFINDE');
class indexupdateorder {	
	private $model;
	private $contro;
	public  $view;

	public function indexupdateorder($model,$contro,$view){
		$this->model=$model;
		$this->contro=$contro;
		$this->view=$view;
		if(in_array($this->model,array('show'))){
			kelemonitor::power($this->model,$this->view);
			indexupdateorder::$model($view);
		}
		else kele::exception('error','model');
	}
	public function show($view){
		set_time_limit(0);
		$site=keledatabase::getarray("site_order","","*");
		$api="api.php";
		$order=keledatabase::getarray("order_manage","","max(order_num) as oid,currency","","currency");
		if($order){
			foreach ($order as $val){
				$orderid[$val['currency']]=$val['oid'];
			}
		}		
		keledata::pushmsg("开始导入信息.....");
		foreach ($site as $val){
			if(isset($orderid[$val['name']]))$oid=$orderid[$val['name']];
			else $oid='0';
			$url=$val['value']."/".$api."?key=".md5($val['api_key'])."&signature=".md5($val['api_signature'])."&order_id=".$oid;
			$getval=keledata::kelecurl($url);
			if($getval&&$getval!=""){
				if(substr($getval, 0,5)!=="array"){
					$error=true;
					keledata::pushmsg($val['name']."订单获取失败....");
					continue;
				}
				eval("\$orders = $getval;");
				keledata::pushmsg("已获取".$val['name']."的订单正在导入数据库.....");
				$orders=keledata::addval($orders);
				foreach ($orders as $value){
					if(!isset($value['products'])){
						continue;
					}
					$address="name:".$value['delivery_name']."<br>"."street address:".
						$value['delivery_street_address']."<br>city:".$value['delivery_city'].
						"<br>state:".$value['delivery_state']."<br>country:".
						$value['delivery_country']."<br>ZIP:".$value['delivery_postcode'];
					$insert=array($value['orders_id'],$value['trade_no'],$address,$value['customers_email_address'],
							$value['customers_telephone'],$value['customers_telephone2'],
							$value['payment_module_code'],$value['text'],$value['value'],
							$value['date_added'],$val['name'],'1');
					$fields=array('order_num','deal_num','customer_address','email',
							'customer_phone','customer_phone2','payment','order_price','price_to_rmb',
							'paytime','currency','ispass');
					keledatabase::insert($insert,"order_manage",$fields);
					$inertid=keledatabase::insert_id();
					foreach ($value['products'] as $product){
						if(substr($product['products_image'],0,5)!="http:")
							$img=$val['value']."/".$product['products_image'];
						$img=kelefile::miniImg($img,100,100,true);
						$insert=array($product['products_model'],$product['products_name'],$img,
								$inertid,$product['product_option']);
						$fields=array('product_itemid','product_name','product_img','order_id','product_options');
						keledatabase::insert($insert,"order_product",$fields);
					}
					keledata::pushmsg("成功导入一条订单".$val['name'].$value['orders_id']."....");
				}
			}else{
				$error=true;
				keledata::pushmsg($val['name']."订单获取失败....");
			}
		}
		if($error){
			kele::exception('error','updateorder');
		}else{
			kele::exception('system','updateorder');
		}
	}
}
?>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="http://www.shop.com//Public/Home/css/base.css" type="text/css">
	<link rel="stylesheet" href="http://www.shop.com//Public/Home/css/global.css" type="text/css">
	<link rel="stylesheet" href="http://www.shop.com//Public/Home/css/header.css" type="text/css">
	<link rel="stylesheet" href="http://www.shop.com//Public/Home/css/fillin.css" type="text/css">
	<link rel="stylesheet" href="http://www.shop.com//Public/Home/css/footer.css" type="text/css">

	<script type="text/javascript" src="http://www.shop.com//Public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="http://www.shop.com//Public/Home/js/cart2.js"></script>

</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="http://www.shop.com//Public/Home/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<form action="<?php echo U('add');?>" method="post">
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息</h3>
				<div class="address_select">
					<ul>
						<?php if(is_array($addresses)): $i = 0; $__LIST__ = $addresses;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$address): $mod = ($i % 2 );++$i;?><li <?php if(($address["is_default"]) == "1"): ?>class="cur"<?php endif; ?> >
							<input type="radio" name="address_id" value="<?php echo ($address["id"]); ?>" <?php if(($address["is_default"]) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo ($address["receiver"]); ?> <?php echo ($address["province_name"]); ?> <?php echo ($address["city_name"]); ?> <?php echo ($address["area_name"]); ?> <?php echo ($address["detail_address"]); ?> <?php echo ($address["tel"]); ?>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式</h3>
				<div class="delivery_select">
					<table>
						<thead>
							<tr>
								<th class="col1">送货方式</th>
								<th class="col2">运费</th>
								<th class="col3">运费标准</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($deliverys)): $i = 0; $__LIST__ = $deliverys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$delivery): $mod = ($i % 2 );++$i;?><tr <?php if(($delivery["is_default"]) == "1"): ?>class="cur"<?php endif; ?>>
								<td>
									<input type="radio" name="delivery_id" value="<?php echo ($delivery["id"]); ?>" <?php if(($delivery["is_default"]) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo ($delivery["name"]); ?>
								</td>
								<td>￥<?php echo ($delivery["price"]); ?></td>
								<td><?php echo ($delivery["intro"]); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>
				<div class="pay_select">
					<table>
						<?php if(is_array($getPayTypes)): $i = 0; $__LIST__ = $getPayTypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$getPayType): $mod = ($i % 2 );++$i;?><tr <?php if(($getPayType["is_default"]) == "1"): ?>class="cur"<?php endif; ?>>
							<td class="col1"><input type="radio" name="pay_type_id" value="<?php echo ($getPayType["id"]); ?>" <?php if(($getPayType["is_default"]) == "1"): ?>checked="checked"<?php endif; ?> /><?php echo ($getPayType["name"]); ?></td>
							<td class="col2"><?php echo ($getPayType["intro"]); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->
			<div class="receipt">
				<h3>发票信息</h3>
				<div class="receipt_info">
					<p>个人发票</p>
					<p>内容：明细</p>
				</div>

				<div class="receipt_select">
						<ul>
							<li>
								<label for="">发票抬头：</label>
								<input type="radio" name="invoice_type" value="0" checked="checked" class="personal" />个人
								<input type="radio" name="invoice_type" value="1" class="company"/>单位
								<input type="text" name="invoice_name" class="txt company_input" disabled="disabled" />
							</li>
							<li>
								<label for="">发票内容：</label>
								<input type="radio" name="invoce_content" checked="checked"  value="明细"/>明细
								<input type="radio" name="invoce_content"  value="办公用品"/>办公用品
								<input type="radio" name="invoce_content"  value="体育休闲"/>体育休闲
								<input type="radio" name="invoce_content"  value="耗材"/>耗材
							</li>
						</ul>
				</div>
			</div>
			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col2">规格</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
					<?php if(is_array($shoppingCars)): $i = 0; $__LIST__ = $shoppingCars;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$shoppingCar): $mod = ($i % 2 );++$i;?><tr>
							<td class="col1"><a href=""><img src="<?php echo PICTURE_URL; ?>Uploads/<?php echo ($shoppingCar["logo"]); ?>" alt="" /></a>  <strong><a href=""><?php echo ($shoppingCar["name"]); ?></a></strong></td>
							<td class="col2"> </td>
							<td class="col3">￥<?php echo ($shoppingCar["shop_price"]); ?></td>
							<td class="col4"> <?php echo ($shoppingCar["num"]); ?></td>
							<td class="col5"><span>￥499.00</span></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span>4 件商品，总商品金额：</span>
										<em>￥5316.00</em>
									</li>
									<li>
										<span>返现：</span>
										<em>-￥240.00</em>
									</li>
									<li>
										<span>运费：</span>
										<em>￥10.00</em>
									</li>
									<li>
										<span>应付总额：</span>
										<em>￥5076.00</em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:$('form').submit()" ><span>提交订单</span></a>
			<p>应付总额：<strong>￥5076.00元</strong></p>
			
		</div>
	</div>
		</form>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="http://www.shop.com//Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="http://www.shop.com//Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="http://www.shop.com//Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="http://www.shop.com//Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
<script type="text/javascript">
</script>
</body>
</html>
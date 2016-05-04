<?php 

class ControllerProductAjaxsearch extends Controller {  

public function index(){ 

  

  $this->load->model('catalog/category');

$this->load->model('tool/image');

$this->load->model('catalog/product');

 $filter_name = $this->request->get['search'];

$array = array();





 /*$category_query = $this->db->query("SELECT ppd.product_id, ppd.name `product_name`, pcd.category_id, 

GROUP_CONCAT(pcd.name  SEPARATOR '|') `Category_names`, GROUP_CONCAT(pcd.category_id  SEPARATOR '|') `Category_ids`

FROM ". DB_PREFIX ."product_description ppd

LEFT JOIN ". DB_PREFIX ."product_to_category pptd ON pptd.product_id = ppd.product_id

LEFT JOIN ". DB_PREFIX ."category_description pcd ON pcd.category_id = pptd.category_id

LEFT JOIN ". DB_PREFIX ."product p ON ppd.product_id = p.product_id

WHERE p.quantity != 0 AND (ppd.name like '%".$filter_name."%') GROUP BY 1") ;*/

$category_query = $this->db->query("SELECT p.product_id, p.model as product_name, cd.category_id, GROUP_CONCAT( cd.name
SEPARATOR  '|' )  `Category_names` , GROUP_CONCAT( cd.category_id
SEPARATOR  '|' )  `Category_ids` 
FROM ". DB_PREFIX ."product p JOIN ". DB_PREFIX ."product_to_category ptc ON p.product_id = ptc.product_id
JOIN ". DB_PREFIX ."category_description cd ON cd.category_id = ptc.category_id
WHERE p.quantity != 0 AND (p.product_id LIKE '%".$filter_name."%' OR p.model LIKE '%".$filter_name."%') GROUP BY 1") ;


if ($category_query->num_rows) { 

  $categoryNames = $category_query->row['Category_names'];

 $categoriesId = $category_query->row['Category_ids'];  

  

     $categories =  explode('|' ,$categoryNames);

   $categoryIdArray =  explode('|' ,$categoriesId);

}   else {

$categories =  array();

   $categoryIdArray = array();  

   }

  $limit= $this->config->get('history_limit');

$data = array(

'filter_name' => $filter_name,

'filter_description'=> true,

'start'  => 0,

'limit'   => $limit);

 $product_total = $this->model_catalog_product->getTotalProducts($data);

$_SESSION['totel_product']=$product_total;


if ($category_query->num_rows) { 
	$results = $this->model_catalog_product->getProducts($data);  
}
//print_r($product_total);



?>



<div id="ajaxdiv" style = "z-index:2000";>



<style >



.gsearchfont_mini{font-family:arial,tahoma,verdana,sans-serif; font-weight:bold; color:#<?php $value_color = $this->config->get('color_id');  if (isset($value_color)) { echo $this->config->get('color_id');}else{echo $color = '1B3570';}?>; font-weigth:bold; }

.gsearchfont{font-family:arial,tahoma,verdana,sans-serif; padding-left:10px; color: #<?php $value_color = $this->config->get('color_id');  if (isset($value_color)) { echo $this->config->get('color_id');}else{echo $color = '1B3570';}?>;font-weight:bold; }

.gprice-old{padding-left:10px;color: #F00;text-decoration: line-through;}

.gprice-new{padding-left:10px;color: #555; font-weight:bold; }

.ajaxsearch{border: 1px solid #ccc;  overflow-y:scroll; height:380px;}

li.shadow { padding-left:20px; padding: 7px;list-style-type:none;}

li.shadow:hover {background-color:#<?php $value_color = $this->config->get('color_id');  if (isset($value_color)) { echo $this->config->get('color_id');}else{echo $color = '1B3570';}?>; -moz-box-shadow: 0 0 1px rgba(0,0,0,0.5); -webkit-box-shadow: 0 0 1px rgba(0,0,0,0.5);box-shadow: 0 0 1px rgba(0,0,0,0.5);}

li:hover span{color:white}

li.shadow_mini{margin: 0px;padding: 3px;list-style-type:none;}

li.shadow_mini:hover {background-color:#<?php $value_color = $this->config->get('color_id');  if (isset($value_color)) { echo $this->config->get('color_id');}else{echo $color = '1B3570';}?>; -moz-box-shadow: 0 0 2px rgba(0,0,0,0.5); -webkit-box-shadow: 0 0 2px rgba(0,0,0,0.5);box-shadow: 0 0 2px rgba(0,0,0,0.5);}

.position_line{border-bottom: 1px solid #ddd;  margin-top:5px; margin-bottom:10px; height:10px;}

.position_line_text{background:white;  display:inline-block; color:grey; height:10px; padding-left:20px; margin-top:2px;}

</style>

<?php $status = $this->config->get('gcolors_status');

if($status == 1){?>

<div class="ajaxsearch">





<?php

$value = 0; 

//$status = $this->config->get('gcolors_status');

//if($status == 1){

foreach ($categories as $category) { 

 

$url = '';

        $url .= '&search=' . urlencode(html_entity_decode($filter_name, ENT_QUOTES, 'UTF-8'));

        $url .= '&category_id=' . $categoryIdArray[$value];;

        $url .= '&sub_category=true';

        $url .= '&description=true';

        $categoryLink =  $this->url->link('product/search', $url);



      ?>

        

 <li class="shadow_mini">

 

  <a style="text-decoration: none;" href="<?php echo $categoryLink;?>"><div  style="float:left;"></div>

    

  <div style="padding-left:17px;  color:black;"><span class="gsearchfont_mini"> en &nbsp;<?php echo $categories[$value];?> </span>

   </div></a> </li>

  

  







 <?php $value++;  }  ?>



 <div class="position_line"> 

  <div class="position_line_text"> Productos</div>

 </div>



 <?php if(isset($results)){ ?>
 
  <?php $j = 0; $count=0; foreach ($results as $result) {

     

 $count++;

  

  if($count>20) {

    break;

  }  

  

  



//$link = $this->url->link('product/product',  '&product_id=' . $result['product_id']);

$link =  'index.php?route=product/ajaxsearch/senddata&key=' . $filter_name . '&total_product=' . $product_total . '&product_id='.   $result['product_id']  ;



if ($result['image']) {

 $image = $this->model_tool_image->resize($result['image'], 50,50);

} else {

$image = false;

}

if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {

 $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));

} else {

$price = false;

}

 

if ((float)$result['special']) {

 $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));

} else {

$special = false;

}

$array[] = array('href'=>$link,'product_id'=>$result['product_id'],'name'=>$result['name'],'image'=>$image,'model'=>$result['model'],'quantity'=>$result['quantity'],'price'=>$price,'special'=> $special,'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..');

 ?>

 

 <li class="shadow">

 

  <a style="text-decoration: none;"  id="url" href="<?php echo $link; ?>"   ><div  style="float:left;"><img height="35px" width="35px" src="<?php echo $image;?>"></div>

   <div>

    <span class="gsearchfont"><?php echo $result['name'];?> </span>

    <br />

    <?php if (!$special) { ?>

          <span class="gprice-new"><?php echo $price?></span>

          <?php } else { ?>

          <span class="gprice-old"><?php echo $special?></span><span class="gprice-new"><?php echo $price?></span>

          <?php } ?>

   </div> 

   </a> 

  </li>



  <!-- <tr>

    <td><a href="<?php echo $link;?>"><img  height="30px" width="30px" src="<?php echo $image;?>" /></a></td>

    <td><div><?php echo $result['name'];?></div></td>

    <td><div><?php echo $price?></div></td>

  </tr>  -->

  <?php  

 }

}

}

?>

 <input type="hidden" name="total_product" value="<?php echo $product_total; ?>" />



</div>

<?php

      

    }

  public function senddata(){

    $ip=$this->db->escape($this->request->server['REMOTE_ADDR']);

    $cust_id= $this->customer->isLogged();

    $product_id = $_GET['product_id'];

    $keyword = $_GET['key'];

    $records = $_GET['total_product'];

    $this->db->query("insert into gsearch_history (keyword,product_id,records,customer_id,ip) values('".$keyword."','".$product_id."','".$records."','".$cust_id."','".$ip."')");

    $link_product = $this->url->link('product/product',  '&product_id=' . $product_id );

    $this->redirect($link_product);

  }

}

?>
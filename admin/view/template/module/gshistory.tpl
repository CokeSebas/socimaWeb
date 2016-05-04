<?php
//==============================================================================
// Gsearch Plugin
// 
// Author: Onjection Solutions
// E-mail: gaurav@onjection.com
// Website: http://www.onjection.com
//==============================================================================


 echo $header; ?>

<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a> <?php } ?>
   
  </div>
  <div class="box">
  <div class="heading"><h1>gSearch History</h1><div class="buttons"><a onclick="location = '<?php echo $back; ?>';" class="button"><span><?php echo "Back"; ?></span></a></div> </div> <br>
  
 <table class="list">
          <thead>
            <tr>
              
              <td class="left"><?php echo "Time"; ?></td>
              <td class="right"><?php echo "Search Keyword";?></td>
              <td class="right"><?php echo "Results";?></td>
              <td class="right"><?php echo "Product ID";?></td>
        <td class="right"><?php echo "Customer Name";?></td>
      <!--  <td class="right"><?php echo "IP Address";?></td> -->
        <td class="right"><?php echo "Action";?></td>
            </tr>
          </thead>
          <tbody>
            
            <?php foreach ($search_history as $list) { ?>
            <tr>           
            <td class="left"><?php echo $list['search_time']; ?></td>
              <td class="right"><?php echo $list['keyword']; ?></td>
              <td class="right"><?php echo $list['records']; ?></td>
               <td class="right"><?php echo $list['product_id']; ?></td>
              <?php if($list['customer_name']==""){ ?>
              <td class="right"><?php echo "guest"; ?></td>     
              <?php }
              else { ?>
               <td class="right"><?php echo $list['customer_name']; ?></td>  
               <?php } ?>  
            <!--   <td class="right"><?php echo $list['ip']; ?></td>     -->
              <td class="right"><div class="buttons"><a onclick="location ='<?php echo $delete_history."&delete_id=".$list['id']; ?>';" class="button"><span><?php echo "Delete"; ?></span></a></div></td>                  
              </tr>
            <?php } ?>
          </tbody>
        </table>
 
     <div class="pagination"><?php echo $pagination; ?></div>
</div>
<?php echo $footer; ?>

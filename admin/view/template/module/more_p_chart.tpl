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
  <div class="heading"><h1>gSearch History by Product Hits </h1><div class="buttons"><a onclick="location = '<?php echo $back; ?>';" class="button"><span><?php echo "Back"; ?></span></a></div> </div> <br>
  </form>
 <table class="list">
          <thead>
            <tr>
              
             
              <td class="left"><?php echo "Product Name";?></td>
              <td class="left"><?php echo "Number of Hits";?></td>
        
            </tr>
          </thead>
          <tbody>
            
            <?php foreach ($get_morekeyword_chart as $list) { ?>
            <tr>           
            
              <td class="left"><?php echo $list['product_name']; ?></td>
              <td class="left"><?php echo $list['num']; ?></td>
                          
        </tr>
      <?php } ?>
          </tbody>
        </table>
    </form>
     
</div>
<?php echo $footer; ?>

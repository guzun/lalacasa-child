<?php 
global $wpdb, $pmpro_msg, $pmpro_msgt, $pmpro_levels, $current_user, $pmpro_currency_symbol;
if($pmpro_msg)
{
?>
<div class="message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
<div class="row membership">
    
  <?php 
  $restrict_options = kleo_memberships();
  
  $levelsno = count($pmpro_levels);
  $levelsno = ($levelsno == 0)? 1:$levelsno;
  $level_cols = 12/$levelsno;
  
  $newoptions = sq_option('membership');
  if (is_array($newoptions) && !empty($newoptions) )
  {
    $popular = $newoptions['kleo_membership_popular'];
    $kleo_pmpro_levels_order = $newoptions['kleo_pmpro_levels_order'];
  }
  else 
  {
    $popular = get_option('kleo_membership_popular');
    $kleo_pmpro_levels_order = get_option('kleo_pmpro_levels_order');
  }
  
  switch ($level_cols)
  {
      case "1":
        $level_cols = "one";
        break;
      case "2":
        $level_cols = "two";
        break;
      case "3":
        $level_cols = "three";
        break;
      case "4":
        $level_cols = "four";
        break;
      case "6":
        $level_cols = "six";
        break;
      case "12":
        $level_cols = "twelve";
        break;
      default: 
        $level_cols = "three";
        break;
  }
  $level_cols = apply_filters('kleo_pmpro_level_columns', $level_cols);
  
  $pmpro_levels_sorted = array();
  
  if (is_array($kleo_pmpro_levels_order)) 
  {
    asort($kleo_pmpro_levels_order);


    foreach($kleo_pmpro_levels_order as $k => $v)
    {
      if(!empty($pmpro_levels[$k])) {
        $pmpro_levels_sorted[$k] = $pmpro_levels[$k];
        unset($pmpro_levels[$k]);
      }
    }
    $pmpro_levels_sorted = $pmpro_levels_sorted + $pmpro_levels;
  }
 else  
 {
   $pmpro_levels_sorted = $pmpro_levels;
 }
  
  foreach($pmpro_levels_sorted as $level)
  {
    if(isset($current_user->membership_level->ID))
      $current_level = ($current_user->membership_level->ID == $level->id);
    else
      $current_level = false;
  ?>
    <?php 
        // don't show free membership option for Real estate Pro (ID = 1047)
        if( ( bp_get_profile_field_data('field=1047&user_id='.get_current_user_id() ) == 'Real Estate Pro' && !pmpro_isLevelFree($level) )
          || ( bp_get_profile_field_data('field=1047&user_id='.get_current_user_id() ) != 'Real Estate Pro' && pmpro_isLevelFree($level))
          || !is_user_logged_in()  ){
            // 1047 is THE ID of the field when you edit 'I am ' filed from here:
            //http://lalacasa.staging.wpengine.com/wp-admin/users.php?page=bp-profile-setup&group_id=1&field_id=1047&mode=edit_field
            // you'll see that ID
        
       
    ?>
  <div class="<?php echo $level_cols;?> columns">
    <ul class="pricing-table<?php if ($popular == $level->id) echo ' popular';?>">
      <li class="title"><?php echo $level->name; ?></li>
      <li class="description">
        <?php
        //recurring part
        if(pmpro_isLevelFree($level))
        {
          echo "<strong>" . __('Free', 'pmpro') . "</strong>";
        }
        elseif($level->billing_amount != '0.00')
        {
          if($level->billing_limit > 1)
          {     
            if($level->cycle_number == '1')
            {
              printf(__('%s per %s for %d more %s.', 'Recurring payment in cost text generation. E.g. $5 every month for 2 more payments.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period), $level->billing_limit, pmpro_translate_billing_period($level->cycle_period, $level->billing_limit));         
            }       
            else
            { 
              printf(__('%s every %d %s for %d more %s.', 'Recurring payment in cost text generation. E.g., $5 every 2 months for 2 more payments.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number), $level->billing_limit, pmpro_translate_billing_period($level->cycle_period, $level->billing_limit));          
            }
          }
          elseif($level->billing_limit == 1)
          {
            printf(__('%s after %d %s.', 'Recurring payment in cost text generation. E.g. $5 after 2 months.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number));                  
          }
          else
          {
            if($level->cycle_number == '1')
            {
              printf(__('%s per %s.', 'Recurring payment in cost text generation. E.g. $5 every month.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, pmpro_translate_billing_period($level->cycle_period));          
            }       
            else
            { 
              printf(__('%s every %d %s.', 'Recurring payment in cost text generation. E.g., $5 every 2 months.', 'pmpro'), $pmpro_currency_symbol . $level->billing_amount, $level->cycle_number, pmpro_translate_billing_period($level->cycle_period, $level->cycle_number));         
            }     
          }
        }     

        //trial
        if(pmpro_isLevelTrial($level))
        {
          if($level->trial_amount == '0.00')
          {
            if($level->trial_limit == '1')
            {
              echo ' ' . _x('After your initial payment, your first payment is Free.', 'Trial payment in cost text generation.', 'pmpro');
            }
            else
            {
              printf(' ' . _x('After your initial payment, your first %d payments are Free.', 'Trial payment in cost text generation.', 'pmpro'), $level->trial_limit);
            }
          }
          else
          {
            if($level->trial_limit == '1')
            {
              printf(' ' . _x('After your initial payment, your first payment will cost %s.', 'Trial payment in cost text generation.', 'pmpro'), $pmpro_currency_symbol . $level->trial_amount);
            }
            else
            {
              printf(' ' . _x('After your initial payment, your first %d payments will cost %s.', 'Trial payment in cost text generation. E.g. ... first 2 payments will cost $5', 'pmpro'), $level->trial_limit, $pmpro_currency_symbol . $level->trial_amount);
            }
          }
        }

        $expiration_text = pmpro_getLevelExpiration($level);
        if($expiration_text)
        {
        ?>
          <br /><span class="pmpro_level-expiration"><?php echo $expiration_text?></span>
        <?php
        }
        ?>
      </li>
      <li class="price">
        <?php if(pmpro_isLevelFree($level) || $level->initial_payment === "0.00") { ?>
            <?php echo $pmpro_currency_symbol?><strong><?php _e('0', 'pmpro');?></strong>
        <?php } else { ?>
            <?php echo $pmpro_currency_symbol?><?php echo $level->initial_payment?>
        <?php } ?>
      </li>
      <?php if ($level->description) { ?>
      <li class="bullet-item extra-description"><?php echo $level->description;?></li>
      <?php } ?>
      
      <?php 
      global $kleo_pay_settings;
      foreach ($kleo_pay_settings as $set) {      
        if ($restrict_options[$set['name']]['showfield'] != 2) { ?>
        <li class="bullet-item <?php if($restrict_options[$set['name']]['type'] == 1 || ($restrict_options[$set['name']]['type'] == 2 && isset($restrict_options[$set['name']]['levels']) && is_array($restrict_options[$set['name']]['levels']) && in_array($level->id,$restrict_options[$set['name']]['levels'])) ) { _e("unavailable",'pmpro');}?>"><?php echo $set['front'];?></li>
        <?php 
        }
      } 
      
      do_action('kleo_pmpro_after_membership_table_items', $level);
      ?>
      
      <li class="cta-button">
        <?php if(empty($current_user->membership_level->ID)) { ?>
          <a class="<?php if ($popular == $level->id) echo 'button radius'; else echo 'button radius small secondary';?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'Choose a level from levels page', 'pmpro');?></a>               
        <?php } elseif ( !$current_level ) { ?>                 
          <a class="<?php if ($popular == $level->id) echo 'button radius'; else echo 'button radius small secondary';?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'Choose a level from levels page', 'pmpro');?></a>            
        <?php } elseif($current_level) { ?>      
          <a class="button radius small secondary disabled" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'pmpro');?></a>
        <?php } ?>
                
      </li>
    </ul>
  </div>
  <?php  
    }
  }
  ?>
    
</div>



<nav id="nav-below" class="navigation" role="navigation" style="display: inline-block;">
  <div class="nav-previous alignleft">
    <?php if(!empty($current_user->membership_level->ID)) { ?>
      <a href="<?php echo pmpro_url("account")?>" class="small radius button link-button"><?php _e('&larr; Return to Your Account', 'pmpro');?></a>
    <?php } else { ?>
      <a href="<?php echo home_url()?>" class="small radius button link-button"><?php _e('&larr; Return to Home', 'pmpro');?></a>
    <?php } ?>
  </div><br>&nbsp;<br><br>
</nav>
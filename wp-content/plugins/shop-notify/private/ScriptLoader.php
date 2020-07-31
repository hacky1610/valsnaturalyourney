<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ScriptLoader {
  public static function Load($wpAdapter)
  {
    $wpAdapter->EnqueueStyle("admin","css/admin.css"); 
    $wpAdapter->EnqueueStyle("animate","css/animate.css"); 

    $wpAdapter->EnqueueStyle("admin_bootstrap","css/bootstrap.css?"); 
    $wpAdapter->EnqueueStyle("admin_fontselect","css/fontselect.css?"); 
    $wpAdapter->EnqueueExternalStyle('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css');
    $wpAdapter->EnqueueExternalStyle('bootstrap_select', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css');
    $wpAdapter->EnqueueStyle("default","css/default.css?"); 
     
    // Include our custom jQuery file with WordPress Color Picker dependency
    $wpAdapter->EnqueueScript('logger','js/logger.js');
    $wpAdapter->EnqueueScript('admin_script','js/admin.js');
    $wpAdapter->EnqueueScript('common','js/common.js');

    $wpAdapter->EnqueueExternalScript('popper','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
    $wpAdapter->EnqueueExternalScript('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js');
    $wpAdapter->EnqueueExternalScript('bootstrap_select','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js');
  
    $wpAdapter->EnqueueScript('bootstrap_notify','js/bootstrap-notify.js');
    $wpAdapter->EnqueueScript('input_mask','js/jquery.inputmask.bundle.js');
    $wpAdapter->EnqueueScript('fontselect','js/jquery.fontselect.js');
  }
}


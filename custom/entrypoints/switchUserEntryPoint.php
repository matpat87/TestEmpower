<?php
/**
 * Login as another user in SugarCRM and switch back to admin user
 *
 * Simply put this file into a custom entry point file and
 * browse to it with the parameters 'user_name' or 'back_to_sudo'
 *
 * Usage:
 *    http://xxxxxxxxx/index.php?entryPoint=switchUserEntryPoint&user_name=mylittlepony
 *    http://xxxxxxxxx/index.php?entryPoint=switchUserEntryPoint&back_to_sudo=1
 * 
 * @author Karl Metum <karl.metum@codehacker.se>
 * @link http://www.codehacker.se
 */
if(!empty($_GET['user_id']) && $GLOBALS['current_user']->is_admin)
{
  $user_focus = BeanFactory::getBean('Users');
  $user_focus->retrieve($_GET['user_id']);
  if(!empty($user_focus->id))
  {
    if(empty($_SESSION['sudo_user_id']))
      $_SESSION['sudo_user_id'] = $GLOBALS['current_user']->id;

    $GLOBALS['current_user'] = $user_focus;
    $_SESSION['authenticated_user_id'] = $user_focus->id;
    echo "Successfully logged in as " . $GLOBALS['current_user']->user_name;

    if(!empty($_SESSION['breadCrumbs']))
    {
      $_SESSION['breadCrumbs'] = new BreadCrumbStack($user_focus->id, '');
    }

    $queryParams = array(
      'module' => 'Home',
      'action' => 'index',    
    );

    SugarApplication::redirect('index.php?' . http_build_query($queryParams)); 

    return;
  }
}
elseif(!empty($_GET['back_to_sudo']) && !empty($_SESSION['sudo_user_id']))
{
  $user_focus = BeanFactory::getBean('Users');
  $user_focus->retrieve($_SESSION['sudo_user_id']);
  if($user_focus->is_admin)
  {
    $_SESSION['sudo_user_id'] = null;
    $GLOBALS['current_user'] = $user_focus;
    $_SESSION['authenticated_user_id'] = $user_focus->id;
    echo "Successfully logged back to sudo user: " . $GLOBALS['current_user']->user_name;

    if(!empty($_SESSION['breadCrumbs']))
    {
      $_SESSION['breadCrumbs'] = new BreadCrumbStack($user_focus->id, '');
    }

    $queryParams = array(
      'module' => 'Home',
      'action' => 'index',    
    );
    SugarApplication::redirect('index.php?' . http_build_query($queryParams)); 

    return;
  }
}

die("No dice.");

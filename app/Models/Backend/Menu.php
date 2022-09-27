<?php

namespace App\Models\Backend;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = 'ck_backend_menu';
  public $timestamps = false;

  public function setMenu($path)
  {

    $setMenu = array();
    $txtMenu = '';
    $pid = array();
    $row = \Cache::remember('Menu-'.\Auth::user()->id, 10, function() {
      $Menu = Menu::where('active', '<>', 'N')->orderBy('sort', 'asc')->orderBy('id', 'asc');
      return $Menu->get();
    });
    if( $row ){
      foreach( $row AS $r ){
        if( !isset($setMenu[$r->ref][$r->id]) )
        {
          $active = '';
          if( substr_count($r->url, '/') == 0 ){
            $active = $r->url==$path?'Y':'N';
          }else{
            $active = substr_count($path, (empty($r->url)?'1':$r->url)) > 0?'Y':'N';
          }
          $setMenu[$r->ref][] = (object) ['id'=>$r->id,'name'=>$r->name,'link'=>$r->url,'icon'=>$r->icon,'active'=>$active];
        }
      }
    }

    if( $setMenu[0] ){
      /**
       *---------------------------------------------------------------------------------------------------------------------------------------------------------
       */
      foreach( $setMenu[0] AS $key => $mMenu ){
        $subMenu  = '';
        $subActive  = '';
        if( empty($setMenu[$mMenu->id]) ){
          $txtMenu .= '
                <li>
                    <a href="'.asset($mMenu->link).'" class=" waves-effect">
                        <i class="'.$mMenu->icon.'"></i>
                        <span>'.$mMenu->name.'</span>
                    </a>
                </li>';
        }else{
          /**
           *---------------------------------------------------------------------------------------------------------------------------------------------------------
           */
          foreach( $setMenu[$mMenu->id] AS $sMenu ){
            if( empty($setMenu[$sMenu->id]) ){
              $subMenu .= '<li><a href="'.asset($sMenu->link).'">'.$sMenu->name.'</a></li>';
            }else{
              /**
               *---------------------------------------------------------------------------------------------------------------------------------------------------------
               */
              $subMenu2   = '';
              $subActive2 = '';
              foreach( $setMenu[$sMenu->id] AS $sMenu2 ){
                if( empty($setMenu[$sMenu2->id]) ){
                  $subMenu2 .= '<li><a href="'.asset($sMenu2->link).'">'.$sMenu->name.'</a></li>';
                }else{
                  /**
                   *---------------------------------------------------------------------------------------------------------------------------------------------------------
                   */
                  $subMenu3   = '';
                  $subActive3 = '';
                  foreach( $setMenu[$sMenu2->id] AS $sMenu3 ){
                    $subMenu3 .= '<li><a href="'.asset($sMenu3->link).'">'.$sMenu3->name.'</a></li>';
                  }

                  $subMenu2 .= '
                  <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="'.$sMenu2->icon.'"></i>
                        <span>'.$sMenu2->name.'</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        '.$subMenu3.'
                    </ul>
                  </li>';
                }
              }

              $subMenu .= '
              <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="'.$sMenu2->icon.'"></i>
                    <span>'.$sMenu2->name.'</span>
                </a>
                <ul class="sub-menu" aria-expanded="true">
                    '.$subMenu2.'
                </ul>
              </li>';
            }
          }


          $txtMenu .= '
          <li>
              <a href="javascript: void(0);" class="has-arrow waves-effect">
                  <i class="'.$mMenu->icon.'"></i>
                  <span>'.$mMenu->name.'</span>
              </a>
              <ul class="sub-menu" aria-expanded="true">
                  '.$subMenu.'
              </ul>
            </li>';
        }
      }
    }

    return $txtMenu;
  }
}

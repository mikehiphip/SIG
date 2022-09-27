<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InitModel extends Model
{
  use SoftDeletes;
  protected function serializeDate(\DateTimeInterface $date)
  {
    return $date->format('Y-m-d H:i:s');
  }

  /*
    public function newQuery($excludeDeleted = true)
    {
  		if( request('withTrashed') == 'true' ){
  			return parent::newQuery()->withTrashed();
  		}else if( request('onlyTrashed') == 'true' ){
  			if( request('onlyModel') == substr(strrchr(static::class, "\\"), 1) ){
  				return parent::newQuery()->onlyTrashed();
  			}else{
  				return parent::newQuery();
  			}
  		}else{
  			return parent::newQuery();
  		}
    }
  */

    public static function boot()
    {
        parent::boot();

        static::creating(function($sData)
        {
    			//$sData->created_by	= \Auth::user()->id??null;
    			$sData->created_at	= \Carbon\Carbon::now();
    			//$sData->updated_by	= \Auth::user()->id??null;
        });

        static::updating(function($sData)
        {
    			//$sData->updated_by	= \Auth::user()->id??null;
    			$sData->updated_at	= \Carbon\Carbon::now();
        });

        static::saving(function($sData)
        {

  			if( $sData->wasChanged() )
  			{
  				//$sData->updated_by	= \Auth::user()->id;
  				$sData->updated_at	= \Carbon\Carbon::now();
  			}
        });
/*
        static::deleting(function($sData)
        {
    			//$sData->updated_by	= \Auth::user()->id;
    			//$sData->updated_at	= \Carbon\Carbon::now();
        });

        static::restoring(function($sData)
        {
    			//$sData->updated_by	= \Auth::user()->id;
    			//$sData->updated_at	= \Carbon\Carbon::now();
        });
*/
    }

    public function scopesearch($sQuery)
    {
  		if( request('Where') ){
  			foreach(request('Where') AS $sKey => $sValue){
  				if( $sValue ){
  					if( strpos($sKey,'.') ){
  						list($sModel, $sField) = explode('.',$sKey);
  						$sQuery->whereHas($sModel, function ($query) use ($sField, $sValue) {
  							$query->where($sField, $sValue);
  						});
  					}else{
  						$sQuery->where($sKey, $sValue);
  					}
  				}
  			}
  		}

  		if( request('Like') ){
  			foreach(request('Like') AS $sKey => $sValue){
  				if( $sValue ){
  					if( strpos($sKey,'.') ){
  						list($sModel, $sField) = explode('.',$sKey);
  						$sQuery->whereHas($sModel, function ($query) use ($sField, $sValue) {
  							$query->where($sField, 'like', '%'.$sValue.'%');
  						});
  					}else{
  						$sQuery->where($sKey, 'like', '%'.$sValue.'%');
  					}
  				}
  			}
		  }
		if (request('DateRange')) {
			foreach (request('DateRange') as $sKey => $sDate) {
				if ($sDate) {
				if (strpos($sKey, '.')) {
					list($sModel, $sField) = explode('.', $sKey);
					$sQuery->whereHas($sModel, function ($query) use ($sField, $sRow) {
					$query->whereBetween($sField, [
						$sRow['date1'],
						$sRow['date2'] . ' 23:59:59'
					]);
					});
				} else {
					$sDate = explode(' - ', $sDate);
					$sQuery->whereBetween($sKey, [
					date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $sDate[0]))),
					date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $sDate[1])))
					]);
				}
				}
			}
		}
       	return $sQuery;
    }

	public function scopeActive($sQuery, $active = 'Y')
	{
		return $sQuery->where('isActive', $active);
	}

	public function scopeLocal($sQuery, $local = null)
	{
		if ($local) {
			return $sQuery->where('locale_id', $local);
		} else {
		if (\Request::segment(2) == 'backend') {
			return $sQuery->where('locale_id', \Request::segment(1));
		} else {
			if (empty(\Config::get('locale'))) {
				$local = \Session::has('locale') ? \Session::get('locale') : 'en';
				return $sQuery->where('locale_id', $local);
			} else {
				return $sQuery->where('locale_id', \Config::get('locale'));
			}
		}
		}
	}

	public function TimeDiff($field){
		$time = '';
		$date1 = new \DateTime($this->{$field});
		$date2 = $date1->diff(new \DateTime());
		$time .= empty($date2->y)?'':$date2->y.' ปี ';
		$time .= empty($date2->m)?'':$date2->m.' เดือน ';
		$time .= empty($date2->d)?'':$date2->d.' วัน ';
		$time .= empty($date2->h)?'':$date2->h.' ชั่วโมง ';
		$time .= empty($date2->i)?'':$date2->i.' นาที ';
		if( $date2->i < 1 )	$time .= empty($date2->s)?'':$date2->s.' วินาที ';
		return $time;
	}

	public function LanguageLocale($name)
	{
		if (\Config::get('land') != 'en') {
		$name = $name . '_locale';
		} else {
		$name = $name . '_en';
		}
		return $this->$name;
	}

	public function Language2tb($name, $value)
	{
		if (\Config::get('land') == 'en') {
		return $this->global->$name;
		} else {
		return $value;
		}
	}


	public function dateFormat($field, $format = 'd/m/Y H:i')
	{
		if (empty($this->{$field})) {
		return '-';
		} else {
		$date1 = new \DateTime($this->{$field});
		return $date1->format($format);
		}
	}


	public function pricePromotion($cat_id, $product_id, $sPrice)
	{


		$sRow = \Cache::remember('Promotion' . \Config::get('locale'), 30,  function () {
		$sPro = [];
		$sRow = \App\Models\Promotion\WebDiscount::local()->active()
			->whereRaw("'" . date('Y-m-d H:i:s') . "' BETWEEN date_start AND date_end")
			->orderBy('date_start', 'desc')
			->first();
		if ($sRow) {
			$sPro['w'] = ['T' => $sRow->type, 'D' => $sRow->discount, 'L' => $sRow->limit];
		}

		$sRow = \App\Models\Promotion\Category::local()->active()
			->whereRaw("'" . date('Y-m-d H:i:s') . "' BETWEEN date_start AND date_end")
			->orderBy('date_start', 'asc')
			->get();
		if ($sRow->count()) {
			foreach ($sRow as $r) {
			$sPro['c'][$r->category_id] = ['T' => $r->type, 'D' => $r->discount, 'L' => $r->limit];
			}
		}

		$sRow = \App\Models\Promotion\Product::local()->active()
			->whereRaw("'" . date('Y-m-d H:i:s') . "' BETWEEN date_start AND date_end")
			->orderBy('date_start', 'asc')
			->get();
		if ($sRow->count()) {
			foreach ($sRow as $r) {
			$sPro['p'][$r->product_id] = ['T' => $r->type, 'D' => $r->discount, 'L' => $r->limit];
			}
		}
		return $sPro;
		});

		$tPrice = $nPrice = $sPrice;
		if ($sRow) {
		if (isset($sRow['w'])) {
			if ($sRow['w']['T'] == 'B') {
			$nPrice = $sPrice - $sRow['w']['D'];
			} else {
			$nPrice = $sPrice - ($sPrice * ($sRow['w']['D'] / 100));
			}
			if ($nPrice < $tPrice) $tPrice = $nPrice;
		}
		if (isset($sRow['c'])) {
			if (array_key_exists($cat_id, $sRow['c'])) {
			if ($sRow['c'][$cat_id]['T'] == 'B') {
				$nPrice = $sPrice - $sRow['c'][$cat_id]['D'];
			} else {
				$nPrice = $sPrice - ($sPrice * ($sRow['c'][$cat_id]['D'] / 100));
			}
			}
			if ($nPrice < $tPrice) $tPrice = $nPrice;
		}
		if (isset($sRow['p'])) {
			if (array_key_exists($product_id, $sRow['p'])) {
			if ($sRow['p'][$product_id]['T'] == 'B') {
				$nPrice = $sPrice - $sRow['p'][$product_id]['D'];
			} else {
				$nPrice = $sPrice - ($sPrice * ($sRow['p'][$product_id]['D'] / 100));
			}
			}
			if ($nPrice < $tPrice) $tPrice = $nPrice;
		}
		}

		return ($tPrice == $sPrice) ? null : $tPrice;
	}
}

<?php
function checkImage($path = '', $placeholder = '') {
    if (empty($placeholder)) {
        $placeholder = 'placeholder.png';
    }

    if (!empty($path)) {
        $url = explode('storage', $path);
        $url = public_path() . '/storage' . $url[1];
        $isFile = explode('.', $url);
        if (file_exists($url) && count($isFile) > 1)
            return $path;
        else
            return asset(env('PUBLIC_PREFIX').'admin/img/' . $placeholder);
    }else {
        return asset(env('PUBLIC_PREFIX').'admin/img/' . $placeholder);
    }
}

function walletTypes()
{
    return [
        1   =>  'Bitcoin',
        2   =>  'Ethereum'
    ];
}

function settingValue($key) {
    $setting = \DB::table('settings')->where('option_name',$key)->first();
    if ($setting)
        return $setting->option_value;
    else
        return '';
}

function siteIcon($option_name,$other_option)
{
    $site_icon = settingValue($option_name);
    $site_icon_url = asset(env('PUBLIC_PREFIX').'images/'.$other_option);
    if(!empty($site_icon) && file_exists(public_path() . '/storage/uploads/settings/'.$site_icon))
    {
      $site_icon_url = asset(env('PUBLIC_PREFIX').'storage/uploads/settings/'.$site_icon);
    }
    return $site_icon_url;
}

?>
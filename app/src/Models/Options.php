<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class Options extends Eloquent
{
    protected $table = 'swiftsc_options';

    public function getSiteInformation()
    {
        $options = [
            'siteurl',
            'blogname',
            'admin_email',
            'new_admin_email',
        ];

        return Options::selectRaw('option_name, option_value')
                ->whereIn('option_name', $options)
                ->get();
    }
}

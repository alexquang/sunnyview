<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelpController extends Controller
{
    public function handle(Request $request)
    {
        $path = strtr('docs/SunnyView-@category.pdf', [
            '@category' => ucfirst($request->route()->uri),
        ]);

        if (Storage::exists($path)) {
            return Storage::download($path);
        };

        abort(404, 'Content Not Found');
    }
}

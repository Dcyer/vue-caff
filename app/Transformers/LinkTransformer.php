<?php

namespace App\Transformers;

use App\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link)
    {
        return [
            'id'    => $link->id,
            'title' => $link->title,
            'link'  => $link->link,
            'logo'  => $link->logo,
        ];
    }
}
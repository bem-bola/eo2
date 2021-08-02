<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('play_list', [$this, 'play_list']),
            new TwigFunction('src_iframe', [$this, 'src_iframe']),
        ];
    }

    public function play_list(string $value)
    {
        $str = '/embed/';
        $nb = strpos($value, $str);
        
        return substr($value, $nb + strlen($str));
    }

    public function src_iframe(string $value)
    {
        $youTube = 'https://www.youtube.com/';


        // on recupere l'identifiant de la vidéo youtube
        // ex: https://www.youtube.com/watch?v=5czivbHlAb0 renvoit 5czivbHlAb0
        $str = substr($value,  strpos($value, '$youTube/watch?v=') + strlen("$youTube/watch?v=")-1);

        $id =  strpos($str, "&t") ? str_replace(substr($str,  strpos($str, '&t')), "", $str) : $str;
        
        // On reconstitue le lien iframe
        $src = $youTube . 'embed/' . $id;

        return compact('src', 'id', 'str');
    }
}
// https://youtu.be/5czivbHlAb0
// https://www.youtube.com/embed/5czivbHlAb0
// https://www.youtube.com/watch?v=5czivbHlAb0
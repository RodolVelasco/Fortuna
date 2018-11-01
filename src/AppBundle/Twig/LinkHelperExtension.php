<?php

namespace AppBundle\Twig;

class LinkHelperExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('delete_link', [$this, 'fnDeleteLink'], ['is_safe' => ['all']]),
            new \Twig_SimpleFunction('update_link', [$this, 'fnUpdateLink'], ['is_safe' => ['all']]),
        ];
    }

    public function fnDeleteLink($target)
    {
        if (is_object($target)) {
            $target = $target->getId();
        }
        return "data-delete-link='$target'";
    }

    public function fnUpdateLink($target)
    {
        if (is_object($target)) {
            $target = $target->getId();
        }
        return "data-update-link='$target'";
    }

    public function getName()
    {
        return 'link_helper';
    }
}

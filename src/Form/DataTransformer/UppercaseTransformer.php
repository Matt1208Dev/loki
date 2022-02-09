<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class UppercaseTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if ($value === null) {
            return;
        }

        return ucfirst($value);
    }

    public function ReverseTransform($value)
    {
        if ($value === null) {
            return;
        }

        return ucfirst($value);
    }
}
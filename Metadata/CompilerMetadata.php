<?php

/*
 * This file is part of the OverblogThriftBundle package.
 *
 * (c) Overblog <http://github.com/overblog/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Overblog\ThriftBundle\Metadata;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CompilerMetadata
{
    /**
     * @var string
     */
    private $path;

    public function __construct(array $options)
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'path' => null,
        ]);
        $resolvedOptions = $resolver->resolve($options);

        foreach ($resolvedOptions as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function create(array $options)
    {
        return new static($options);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}

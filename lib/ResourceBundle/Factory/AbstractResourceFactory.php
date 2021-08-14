<?php
/*
 * This file is part of the Expense project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Guennichi\ResourceBundle\Factory;

use Guennichi\ResourceBundle\Model\ResourceInterface;

abstract class AbstractResourceFactory implements ResourceFactoryInterface
{
    protected ResourceFactoryInterface $innerFactory;

    public function setInnerFactory(ResourceFactoryInterface $innerFactory): void
    {
        $this->innerFactory = $innerFactory;
    }

    /**
     * @inheritDoc
     */
    public function createNew(): ResourceInterface
    {
        return $this->innerFactory->createNew();
    }
}

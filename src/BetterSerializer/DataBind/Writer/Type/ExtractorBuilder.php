<?php
declare(strict_types=1);

/**
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Type;

use BetterSerializer\DataBind\Writer\Type\Chain\ArrayMember;
use BetterSerializer\DataBind\Writer\Type\Chain\ObjectMember;
use BetterSerializer\DataBind\Writer\Type\Chain\SimpleMember;

/**
 * Class ExtractorBuilder
 * @author mfris
 * @package BetterSerializer\DataBind\Writer\Type
 */
final class ExtractorBuilder
{

    /**
     * @return ExtractorInterface
     */
    public function build(): ExtractorInterface
    {
        $extractor = new Extractor();
        $extractor->addChainMember(new SimpleMember());
        $extractor->addChainMember(new ObjectMember());
        $extractor->addChainMember(new ArrayMember($extractor));

        return $extractor;
    }
}
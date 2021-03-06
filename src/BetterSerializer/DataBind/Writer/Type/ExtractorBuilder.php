<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Writer\Type;

use BetterSerializer\DataBind\Writer\Type\Chain\ArrayMember;
use BetterSerializer\DataBind\Writer\Type\Chain\DateTimeMember;
use BetterSerializer\DataBind\Writer\Type\Chain\ClassMember;
use BetterSerializer\DataBind\Writer\Type\Chain\SimpleMember;

/**
 *
 */
final class ExtractorBuilder
{

    /**
     * @return ExtractorInterface
     */
    public static function build(): ExtractorInterface
    {
        $extractor = new Extractor();
        $extractor->addChainMember(new SimpleMember());
        $extractor->addChainMember(new DateTimeMember());
        $extractor->addChainMember(new ClassMember());
        $extractor->addChainMember(new ArrayMember($extractor));

        return $extractor;
    }
}

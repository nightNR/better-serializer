<?php
declare(strict_types=1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */

namespace BetterSerializer\DataBind\Reader\Processor\Factory;

use BetterSerializer\DataBind\MetaData\Model\PropertyModel\PropertyMetaDataInterface;
use BetterSerializer\DataBind\MetaData\Type\TypeInterface;
use BetterSerializer\DataBind\Reader\Processor\Factory\PropertyMetaDataChain\ChainMemberInterface as MetaDataMember;
use BetterSerializer\DataBind\Reader\Processor\Factory\TypeChain\ChainMemberInterface as TypeMember;
use BetterSerializer\DataBind\Reader\Processor\Factory\TypeChain\ChainMemberInterface;
use BetterSerializer\DataBind\Reader\Processor\ProcessorInterface;
use LogicException;
use ReflectionException;
use RuntimeException;

/**
 *
 */
final class ProcessorFactory implements ProcessorFactoryInterface
{

    /**
     * @var MetaDataMember[]
     */
    private $metaDataChainMembers;

    /**
     * @var TypeMember[]
     */
    private $typeChainMembers;

    /**
     * @param MetaDataMember[] $metaDataChainMembers
     * @param TypeMember[] $typeChainMembers
     */
    public function __construct(array $metaDataChainMembers = [], array $typeChainMembers = [])
    {
        $this->metaDataChainMembers = $metaDataChainMembers;
        $this->typeChainMembers = $typeChainMembers;
    }

    /**
     * @param PropertyMetaDataInterface $metaData
     * @return ProcessorInterface
     * @throws LogicException
     */
    public function createFromMetaData(PropertyMetaDataInterface $metaData): ProcessorInterface
    {
        foreach ($this->metaDataChainMembers as $chainMember) {
            $processor = $chainMember->create($metaData);

            if ($processor) {
                return $processor;
            }
        }

        throw new LogicException("Unknown type - '" . get_class($metaData->getType()) . "'");
    }

    /**
     * @param TypeInterface $type
     * @return ProcessorInterface
     * @throws LogicException
     */
    public function createFromType(TypeInterface $type): ProcessorInterface
    {
        foreach ($this->typeChainMembers as $chainMember) {
            $processor = $chainMember->create($type);

            if ($processor) {
                return $processor;
            }
        }

        throw new LogicException("Unknown type - '" . get_class($type) . "'");
    }

    /**
     * @param MetaDataMember $chainMember
     */
    public function addMetaDataChainMember(MetaDataMember $chainMember): void
    {
        $this->metaDataChainMembers[] = $chainMember;
    }

    /**
     * @param ChainMemberInterface $chainMember
     */
    public function addTypeChainMember(TypeMember $chainMember): void
    {
        $this->typeChainMembers[] = $chainMember;
    }
}

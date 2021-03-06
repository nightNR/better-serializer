<?php
declare(strict_types = 1);

/*
 * @author Martin Fris <rasta@lj.sk>
 */
namespace BetterSerializer\DataBind\Reader\Injector;

/**
 *
 */
interface InjectorInterface
{

    /**
     * @param object $object
     * @param mixed $data
     * @return mixed
     */
    public function inject(object $object, $data): void;
}

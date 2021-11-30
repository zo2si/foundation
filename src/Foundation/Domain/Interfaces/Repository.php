<?php namespace App\Foundation\Domain\Interfaces;

interface Repository
{
    /**
     * Save an entity to repository.
     *
     * @param \App\Foundation\Domain\Entity $entity
     */
    public function save($entity);

    /**
     * Fetch an entity from repository by its identity.
     *
     * @param mixed $id
     * @param bool $throws Whether throws an EntityNotFound exception.
     * @return \App\Foundation\Domain\Entity|null
     *
     * @throws \App\Foundation\Domain\Exceptions\EntityNotFound
     */
    public function fetch($id, $throws = false);

}
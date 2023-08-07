<?php

namespace App\Hateoas;

use App\Models\Pessoas;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class PessoasHateoas
{
    use CreatesLinks;

    public function self(Pessoas $pessoas): ?Link
    {
        return $this->link('pessoas.show', ['id' => $pessoas->id]);
    }

    public function index(): ?Link
    {
        return $this->link('pessoas.index');
    }

    public function store(): ?Link
    {
        return $this->link('pessoas.store');
    }

    public function update(Pessoas $pessoas): ?Link
    {
        return $this->link('pessoas.update', ['id' => $pessoas->id]);
    }

    public function destroy(Pessoas $pessoas): ?Link
    {
        return $this->link('pessoas.destroy', ['id' => $pessoas->id]);
    }

}

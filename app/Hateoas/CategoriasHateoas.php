<?php

namespace App\Hateoas;

use App\Models\Categorias;
use GDebrauwer\Hateoas\Link;
use GDebrauwer\Hateoas\Traits\CreatesLinks;

class CategoriassHateoas
{
    use CreatesLinks;

    public function self(Categorias $categorias): ?Link
    {
        return $this->link('categorias.show', ['id' => $categorias->id]);
    }

    public function index(): ?Link
    {
        return $this->link('categorias.index');
    }

    public function store(): ?Link
    {
        return $this->link('categorias.store');
    }

    public function update(Categorias $categorias): ?Link
    {
        return $this->link('categorias.update', ['id' => $categorias->id]);
    }

    public function destroy(Categorias $categorias): ?Link
    {
        return $this->link('categorias.destroy', ['id' => $categorias->id]);
    }

}

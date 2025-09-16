<?php

namespace PHPMaker2025\pssk2025;

/**
 * Lookup table interface
 */
interface LookupTableInterface
{

    public function renderLookupForEdit(string $name, mixed $value): mixed;

    public function renderLookupForView(string $name, mixed $value): mixed;

    public function lookupSelecting(DbField $field, string &$filter): void;
}

<?php

namespace PHPMaker2025\pssk2025;

/**
 * Chart renderer interface
 */
interface ChartRendererInterface
{

    public function getContainer(int $width, int $height): string;

    public function getScript(int $width, int $height): string;
}

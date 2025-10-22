<?php

namespace App\Models\Packages\Waybills;

class Styles {
    public int $position;

    public int $size;

    public string $align;

    public int $margin_top;

    public int $margin_bottom;

    public static function alignBlock(string $align): string
    {
        return match($align) {
            'left' => 'margin: 0 auto; margin-left: 0;',
            'right' => 'margin: 0 auto; margin-right: 0;',
            default => 'margin: 0 auto;'
        };
    }

    public function __construct(
        int $position,
        int $size,
        string $align = 'center',
        int $margin_top = 5,
        int $margin_bottom = 5
    )
    {
        $this->position = $position;
        $this->size = $size;
        $this->align = $align;
        $this->margin_top = $margin_top;
        $this->margin_bottom = $margin_bottom;
    }

    public function buildArray(): array
    {
        $styles = [
            'position' => $this->position,
            'size' => $this->size,
            'align' => $this->align,
            'margin_top' => $this->margin_top,
            'margin_bottom' => $this->margin_bottom,
        ];
        return $styles;
    }
}
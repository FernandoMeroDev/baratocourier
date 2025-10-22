<?php

namespace App\Models\Packages\Waybills;

class TextStyles extends Styles {

    public ?string $font_style;

    public ?string $font_weight;

    public function __construct(
        int $position,
        int $size,
        string $align = 'center',
        int $margin_top = 5,
        int $margin_bottom = 5,
        string $font_style = 'normal',
        string $font_weight = 'normal',
    )
    {
        parent::__construct($position, $size, $align, $margin_top, $margin_bottom);
        $this->font_style = $font_style;
        $this->font_weight = $font_weight;
    }

    public function buildArray(): array
    {
        $styles = parent::buildArray();
        if( ! is_null($this->font_style) && ! is_null($this->font_weight)){
            $styles['font_style'] = $this->font_style;
            $styles['font_weight'] = $this->font_weight;
        }
        return $styles;
    }
}
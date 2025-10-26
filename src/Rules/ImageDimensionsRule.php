<?php

namespace MightyWeb\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageDimensionsRule implements Rule
{
    protected $minWidth;
    protected $minHeight;
    protected $maxWidth;
    protected $maxHeight;

    public function __construct($minWidth = null, $minHeight = null, $maxWidth = null, $maxHeight = null)
    {
        $this->minWidth = $minWidth;
        $this->minHeight = $minHeight;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value || !$value->isValid()) {
            return false;
        }

        $dimensions = getimagesize($value->getRealPath());
        
        if (!$dimensions) {
            return false;
        }

        [$width, $height] = $dimensions;

        if ($this->minWidth && $width < $this->minWidth) {
            return false;
        }

        if ($this->minHeight && $height < $this->minHeight) {
            return false;
        }

        if ($this->maxWidth && $width > $this->maxWidth) {
            return false;
        }

        if ($this->maxHeight && $height > $this->maxHeight) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $messages = [];

        if ($this->minWidth || $this->minHeight) {
            $messages[] = "minimum {$this->minWidth}x{$this->minHeight}px";
        }

        if ($this->maxWidth || $this->maxHeight) {
            $messages[] = "maximum {$this->maxWidth}x{$this->maxHeight}px";
        }

        $dimensionsText = implode(', ', $messages);

        return "The :attribute must have dimensions of {$dimensionsText}.";
    }
}

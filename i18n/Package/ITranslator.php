<?php

namespace Frame\Package;

use Frame\I18n;

interface ITranslator
{
    public function translator(I18n $translator);
}
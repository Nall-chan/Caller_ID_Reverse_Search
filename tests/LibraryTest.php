<?php

declare(strict_types=1);

include_once __DIR__ . '/stubs/Validator.php';

class LibraryTest extends TestCaseSymconValidation
{
    public function testValidateLibrary(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }

    public function testValidate11880(): void
    {
        $this->validateModule(__DIR__ . '/../Rueckwaertssuche11880');
    }
    public function testValidateDasOertliche(): void
    {
        $this->validateModule(__DIR__ . '/../RueckwaertssucheDasOertliche');
    }
    public function testValidateTelSearchCH(): void
    {
        $this->validateModule(__DIR__ . '/../RueckwaertssucheTelSearchCH');
    }
}

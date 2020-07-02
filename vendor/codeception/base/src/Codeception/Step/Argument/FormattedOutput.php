<?php

namespace Codeception\Step\Argument;

/**
 * Implemented in Step arguments where literal values need to be modified in test execution output (e.g. passwords).
 */
interface FormattedOutput
{
    /**
     * Returns the argument's value formatted for output.
     *
     * @return string
     */
    public function getOutput();

    /**
     * Returns the argument's literal value.
     *
     * @return string
     */
    public function __toString();
}

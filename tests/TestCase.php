<?php
/**
 * TestCase abstract class file
 * 
 * @author Pieterjan Fiers <pjfiers@gmail.com>
 * @version 0.1
 */

/**
 * Abstract testcase class
 * @category Tests
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}

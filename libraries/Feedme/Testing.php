<?php

/**
 * Testing application (for all phpunit etc.)
 */

namespace Feedme;

use Phalcon\Exception;

class Testing extends InstanceAbstract
{
    public function run()
    {
        try {
            $this->registerNamespaces();

        } catch (Exception $e) {
            echo "Phalcon Exception : " . $e->getMessage();
        } catch (\PDOException $e) {
            echo "PHP Exception : " . $e->getMessage();
        }
    }
}

<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Event\Test;

use PHPUnit\Event\Subscriber;

/**
<<<<<<< HEAD:vendor/phpunit/phpunit/src/Event/Events/Test/HookMethod/PostConditionErroredSubscriber.php
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise for PHPUnit
=======
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
>>>>>>> af3220020a35046e3fbe63c13a1df52bccccf17d:vendor/phpunit/phpunit/src/Runner/Exception/NoIgnoredEventException.php
 */
interface PostConditionErroredSubscriber extends Subscriber
{
    public function notify(PostConditionErrored $event): void;
}

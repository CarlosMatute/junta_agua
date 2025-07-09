<?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\TextUI\Command;

<<<<<<< HEAD
use const PHP_EOL;
use function assert;
=======
use function file_get_contents;
>>>>>>> af3220020a35046e3fbe63c13a1df52bccccf17d
use function sprintf;
use function version_compare;
use PHPUnit\Util\Http\Downloader;

/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
final class VersionCheckCommand implements Command
{
    private readonly Downloader $downloader;
    private readonly int $majorVersionNumber;
    private readonly string $versionId;

    public function __construct(Downloader $downloader, int $majorVersionNumber, string $versionId)
    {
        $this->downloader         = $downloader;
        $this->majorVersionNumber = $majorVersionNumber;
        $this->versionId          = $versionId;
    }

    public function execute(): Result
    {
        $latestVersion = $this->downloader->download('https://phar.phpunit.de/latest-version-of/phpunit');

        assert($latestVersion !== false);

        $latestCompatibleVersion = $this->downloader->download('https://phar.phpunit.de/latest-version-of/phpunit-' . $this->majorVersionNumber);

        assert($latestCompatibleVersion !== false);

        $notLatest           = version_compare($latestVersion, $this->versionId, '>');
        $notLatestCompatible = version_compare($latestCompatibleVersion, $this->versionId, '>');

        if (!$notLatest && !$notLatestCompatible) {
            return Result::from(
                'You are using the latest version of PHPUnit.' . PHP_EOL,
            );
        }

        $buffer = 'You are not using the latest version of PHPUnit.' . PHP_EOL;

        if ($notLatestCompatible) {
            $buffer .= sprintf(
                'The latest version compatible with PHPUnit %s is PHPUnit %s.' . PHP_EOL,
                $this->versionId,
                $latestCompatibleVersion,
            );
        }

        if ($notLatest) {
            $buffer .= sprintf(
                'The latest version is PHPUnit %s.' . PHP_EOL,
                $latestVersion,
            );
        }

        return Result::from($buffer);
    }
}

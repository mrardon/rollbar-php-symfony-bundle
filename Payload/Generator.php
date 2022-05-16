<?php

namespace Rollbar\Symfony\RollbarBundle\Payload;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

class Generator
{
    protected ?Kernel $kernel;

    public function __construct(protected ContainerInterface $container)
    {
        $this->kernel = $container->get('kernel');
    }

    /**
     * Get payload a log record.
     */
    public function getExceptionPayload(\Exception $exception): array
    {
        /**
         * Build payload
         * @link https://rollbar.com/docs/api/items_post/
         */
        $payload = [
            'body'             => [],
            'framework'        => Kernel::VERSION,
            'server'           => $this->getServerInfo(),
            'request'          => $this->getRequestInfo(),
            'environment'      => $this->getKernel()->getEnvironment(),
        ];

        // handle exception
        $chain = new TraceChain();
        $item  = new TraceItem();

        $data            = $item($exception);
        $message         = $data['exception']['message'];
        $payload['body'] = ['trace_chain' => $chain($exception)];

        return [$message, $payload];
    }

    #[ArrayShape(['trace' => "array"])]
    protected function buildGeneratorError(object $object, string $file, int $line): array
    {
        $item = new ErrorItem();

        return ['trace' => $item(0, serialize($object), $file, $line)];
    }

    public function getErrorPayload(int $code, string $message, string $file, int $line): array
    {
        $item = new ErrorItem();

        $payload = [
            'body'             => ['trace' => $item($code, $message, $file, $line)],
            'request'          => $this->getRequestInfo(),
            'environment'      => $this->getKernel()->getEnvironment(),
            'framework'        => Kernel::VERSION,
            'server'           => $this->getServerInfo(),
        ];

        return [$message, $payload];
    }

    #[ArrayShape(['url' => "string",
        'method' => "string",
        'headers' => "mixed",
        'query_string' => "null|string",
        'body' => "mixed",
        'user_ip' => "null|string"])]
    protected function getRequestInfo(): array
    {
        /** @var $request Request */
        $request = $this->getContainer()->get('request_stack')->getCurrentRequest();

        if ($request === null) {
            $request = new Request();
        }

        return [
            'url'          => $request->getRequestUri(),
            'method'       => $request->getMethod(),
            'headers'      => $request->headers->all(),
            'query_string' => $request->getQueryString(),
            'body'         => $request->getContent(),
            'user_ip'      => $request->getClientIp(),
        ];
    }

    #[ArrayShape(['host' => "false|string",
        'root' => "string",
        'user' => "string",
        'file' => "mixed|null",
        'argv' => "string"])]
    protected function getServerInfo(): array
    {
        $args   = $_SERVER['argv'] ?? [];
        $kernel = $this->getKernel();

        return [
            'host' => gethostname(),
            'root' => $kernel->getRootDir(),
            'user' => get_current_user(),
            'file' => array_shift($args),
            'argv' => implode(' ', $args),
        ];
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getKernel(): Kernel
    {
        return $this->kernel;
    }
}

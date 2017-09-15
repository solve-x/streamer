<?php

namespace App\ViewModels;

use Illuminate\Http\Request;
use RuntimeException;
use SolveX\ViewModel\DataSourceInterface;

class RequestDataSource implements DataSourceInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * RequestDataSource constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the data source contains a non-empty value for a key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->request->has($key);
    }
    /**
     * Retrieve an item from the data source.
     *
     * @param string $key Lookup key.
     * @return string|array
     * @throws RuntimeException When $key is missing.
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return $this->request->input($key);
        }
        throw new RuntimeException('Invalid key!');
    }
}
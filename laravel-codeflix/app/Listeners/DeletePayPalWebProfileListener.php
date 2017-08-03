<?php

namespace CodeFlix\Listeners;

use CodeFlix\Models\PayPalWebProfile;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use CodeFlix\PayPal\WebProfileClient;
use CodeFlix\Repositories\PayPalWebProfileRepository;

class DeletePayPalWebProfileListener
{
    /**
     * @var WebProfileClient
     */
    private $webProfileClient;
    /**
     * @var PayPalWebProfileRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WebProfileClient $webProfileClient, PayPalWebProfileRepository $repository)
    {
        //
        $this->webProfileClient = $webProfileClient;
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityDeleted  $event
     * @return void
     */
    public function handle(RepositoryEntityDeleted $event)
    {
        $model = $event->getModel();
        if(!($model instanceof PayPalWebProfile)){
            return;
        }

        $this->webProfileClient->delete($model->code);
    }
}
